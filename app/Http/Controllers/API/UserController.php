<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\ActivationCode;
use App\Models\Project;
use App\Models\User;
use App\Services\ForgetPinMailService;
use App\Services\ImageUploadService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends BaseController
{
    protected $forgetPinMailService;
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService, ForgetPinMailService $forgetPinMailService)
    {
        $this->imageUploadService = $imageUploadService;
        $this->forgetPinMailService = $forgetPinMailService;
    }

    public function index()
    {
        $user = Auth::user();

        $project = Project::with([
                'license',
                'license.category',
                'license.status',
                'group',
            ])
            ->where('group_id', $user->group_id)
            ->first();

        return $this->sendResponse([
            'user' => $user,
            'license' => optional($project)->license,
        ], 'User retrieved successfully.');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'gender_id' => 'required|numeric',
            'phone' => 'required|numeric|digits_between:9,15',
            'birth_date' => 'required|date',
            'address' => 'required|string',
        ]);

        $user = Auth::user();

        if(!$user){
            return $this->sendError('User not found.' );
        }

        $user->update($data);

        return $this->sendResponse(['user' => $user], 'User updated successfully.');
    }

    public function update_photo_profile(Request $request)
    {
        $request->validate([
            'photo' => 'required|file|image|max:2048'
        ]);

        $photo = $request->file('photo');

        $user = User::find(Auth::id());

        if (!$user) {
            return $this->sendError('User not found.');
        }

        if ($photo) {
            $photoPath = $this->imageUploadService->uploadPhoto(
                $photo,
                'photo/profile/',
                300
            );

            if ($user->photo) {
                Storage::delete($user->photo);
            }

            $user->update(['photo' => $photoPath]);
        }

        return $this->sendResponse(['user' => $user], 'User photo profile updated successfully.');
    }

    public function update_shop(Request $request)
    {
        $validated = $request->validate([
            'shop_name' => 'required|string',
            'shop_address' => 'required|string',
            'shop_phone' => 'required|numeric|digits_between:9,15',
        ]);

        $user = User::findOrFail(Auth::id());

        $user->update($validated);

        return $this->sendResponse(['user' => $user], 'Shop updated successfully.');
    }

    public function update_shop_photo(Request $request)
    {
        $request->validate([
            'shop_photo' => 'required|file|image|max:2048'
        ]);

        $shop_photo = $request->file('shop_photo');

        $user = User::with(['group', 'role', 'gender'])->findOrFail(Auth::id());

        if ($shop_photo) {
            $photoPath = $this->imageUploadService->uploadPhoto(
                $shop_photo,
                'photo/shop/',
                300
            );

            if ($user->shop_photo) {
                Storage::delete($user->shop_photo);
            }

            $user->update(['shop_photo' => $photoPath]);
        }

        return $this->sendResponse(['user' => $user], 'Shop photo updated successfully.');
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/[A-Z]/', // Harus mengandung huruf kapital
                'regex:/[0-9]/', // Harus mengandung angka
                'confirmed', // Password confirmation
                function ($attribute, $value, $fail) {
                    if (Hash::check($value, Auth::user()->password)) {
                        $fail('Password baru tidak boleh sama dengan password lama.');
                    }
                }
            ],
        ], [
            'current_password.current_password' => 'Password lama yang Anda masukkan salah!',
            'password.regex' => 'Password harus mengandung setidaknya satu huruf kapital dan satu angka.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $current_password = $request->current_password;
        $password = $request->password;

        $user = Auth::user();

        // Verifikasi password lama
        if (!Hash::check($current_password, $user->password)) {
            return $this->sendError('Current password is incorrect.');
        }

        // Update password baru
        $user->update([
            'password' => Hash::make($password),
        ]);

        // Revoke token yang sedang aktif
        $user->token()->delete();

        return $this->sendResponse([
            'user' => $user
        ], 'User password updated successfully & you have to login again.');
    }

    public function create_pin(Request $request)
    {
        $request->validate([
            'pin' => 'required|digits:6|numeric',
            'c_pin' => 'required|same:pin',
        ]);

        $pin = $request->pin;

        $user = Auth::user();

        $user->update([
            'pin' => $pin,
            'pin_verified_at' => Carbon::now(),
        ]);

        return $this->sendResponse([
            'user' => $user
        ], 'User pin created successfully.');
    }

    public function update_pin(Request $request)
    {
        $request->validate([
            'old_pin' => 'required|numeric|digits:6',
            'pin' => 'required|digits:6|numeric|different:old_pin',
            'c_pin' => 'required|same:pin',
        ]);

        $old_pin = $request->old_pin;
        $pin = $request->pin;

        $user = Auth::user();

        if ($user->pin != $old_pin) {
            return $this->sendError('Old PIN is incorrect.');
        }

        $user->update([
            'pin' => $pin,
            'pin_verified_at' => Carbon::now(),
        ]);

        return $this->sendResponse([
            'user' => $user
        ], 'User pin updated successfully.');
    }

    public function sendForgetPinEmail()
    {
        $user = Auth::user();

        $code = $this->forgetPinMailService->sendVerificationCode($user->email);

        return $this->sendResponse(['email' => $user->email,'code' => $code], "Verification code has been sent successfully.");
    }

    public function verifyForgetPin(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric|digits:6',
            'pin' => 'required|digits:6|numeric',
            'c_pin' => 'required|same:pin',
        ]);

        $code = $request->code;
        $pin = $request->pin;

        $user = Auth::user();

        // Cek apakah kode masih aktif
        $verificationCode = ActivationCode::where('email', $user->email)
            ->where('code', $code)
            ->where('status', 'active')
            ->first();

        if (!$verificationCode) {
            return $this->sendError('Your forget pin code is wrong or expired.');
        }

        $user->update([
            'pin' => $pin,
            'pin_verified_at' => Carbon::now(),
        ]);

        $verificationCode->delete();

        return $this->sendResponse([
            'user' => $user
        ], 'User pin updated successfully.');
    }


    public function destroy(string $id)
    {
        //
    }
}
