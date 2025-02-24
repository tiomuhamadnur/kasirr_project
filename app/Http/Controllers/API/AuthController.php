<?php

namespace App\Http\Controllers\API;

use App\Services\ActivationMailService;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\ActivationCode;
use App\Models\Group;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    protected ActivationMailService $activationService;

    public function __construct(ActivationMailService $activationService)
    {
        $this->activationService = $activationService;
    }

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
            'phone' => 'required|numeric|digits_between:9,15',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        try {
            $input = $validator->validated();
            $input['password'] = Hash::make($input['password']);
            $input['role_id'] = 3; // ID role user default
            $input['group_id'] = $this->generateGroupBySystem();

            $user = User::create($input);

            // Kirim email aktivasi setelah registrasi
            $activationCode = $this->sendActivationCode($user);

            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['user'] = $user->load('role', 'gender', 'group');
            $success['email_verification'] = $activationCode->original;

            return $this->sendResponse($success, 'User registered successfully, activation email sent.');
        } catch (Exception $e) {
            return $this->sendError('Registration failed.', ['error' => $e->getMessage()], 500);
        }
    }

    public function sendActivationCode(User $user): JsonResponse
    {
        if ($user->email_verified_at) {
            return $this->sendError('Your email has already been verified, no activation code needed.');
        }

        // Kirim kode aktivasi
        $activationCode = $this->activationService->sendActivationCode($user->email);

        return $this->sendResponse(['email' => $user->email, 'activation_code' => $activationCode], 'Activation code has been sent successfully.');
    }

    public function resendActivationEmail(): JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return $this->sendError('Unauthorized.', ['error' => 'User not logged in.'], 401);
        }

        if ($user->email_verified_at) {
            return $this->sendError('Your email has already been verified, no activation code needed.');
        }

        $activationCode = $this->sendActivationCode($user);

        return $this->sendResponse($activationCode, 'Activation code has been sent successfully.');
    }

    public function verifyActivationCode(Request $request)
    {
        $request->validate([
            'activation_code' => 'required|numeric',
        ]);

        $user = Auth::user();

        if($user->email_verified_at) {
            return $this->sendError('Your email account is verified, you dont need an activation code.');
        }

        $validate = ActivationCode::where('email', $user->email)->where('code', $request->activation_code)->where('status', 'active')->count();

        if($validate == 0) {
            return $this->sendError('Your activation code is wrong.');
        }

        $user = User::with(['group', 'gender', 'role'])->find($user->id);

        $user->update([
            'email_verified_at' => Carbon::now(),
        ]);

        ActivationCode::where('email', $user->email)->where('code', $request->activation_code)->where('status', 'active')->delete();

        return $this->sendResponse(['user' => $user], 'Activation code is valid, your email has been verified.');
    }

    private function generateGroupBySystem()
    {
        $code = strtoupper(Str::random(30));
        $code = preg_replace('/[^A-Z0-9]/', '', $code);
        $code = substr($code, 0, 20);

        $group = Group::create([
            'name' => $code,
            'code' => $code,
            'description' => 'Group ini digenerate otomatis oleh system pada ' . Carbon::now(),
        ]);

        return $group->id;
    }

    public function login(Request $request): JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();

            $user->tokens()->delete();

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
