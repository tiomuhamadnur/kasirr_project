<?php

namespace App\Http\Controllers\API;

use App\Services\ActivationMailService;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\ActivationCode;
use App\Models\Group;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseController
{
    protected ActivationMailService $activationService;

    public function __construct(ActivationMailService $activationService)
    {
        $this->activationService = $activationService;
    }

    public function sendActivationCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if($user->email_verified_at) {
            return $this->sendError('Your email has been verified, you don’t need an activation code.');
        }

        $activation_code = $this->activationService->sendActivationCode($request->email);

        return $this->sendResponse(['activation_code' => $activation_code], 'Activation code has been sent successfully.');
    }

    public function verifyActivationCode(Request $request)
    {
        $request->validate([
            'activation_code' => 'required|numeric',
        ]);

        $user = Auth::user();

        $validate = ActivationCode::where('user_id', $user->id)->where('code', $request->activation_code)->where('status', 'active')->count();

        if($validate == 0) {
            return $this->sendError('Your activation code is wrong.');
        }

        $user = User::with(['group', 'gender', 'role'])->find($user->id);

        $user->update([
            'email_verified_at' => Carbon::now(),
        ]);

        ActivationCode::where('user_id', $user->id)->where('code', $request->activation_code)->where('status', 'active')->delete();

        return $this->sendResponse(['user' => $user], 'Activation code is valid, your email has been verified.');
    }

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'phone' => 'required|numeric|digits_between:9,15',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['role_id'] = 3;
        $input['group_id'] = $this->generateGroupBySystem();
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['user'] =  $user;

        return $this->sendResponse($success, 'User register successfully, but need email verification');
    }

    private function generateGroupBySystem()
    {
        $group = Group::create([
            'name' => rand(10000, 100000) . '-' . auth()->user()->name,
            'code' => rand(10000, 100000) . '-' . auth()->user()->name . '-' . auth()->user()->email,
            'description' => 'Group ini digenerate otomatis oleh system pada ' . Carbon::now(),
        ]);

        return $group->id;
    }

    public function login(Request $request): JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['user'] =  $user;

            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorized.', ['error'=>'Unauthorized']);
        }
    }

    public function logout()
    {
        $user = Auth::user();

        // Revoke token yang sedang aktif
        $user->token()->delete();

        return $this->sendResponse($user, "User logout successfully.");
    }
}
