<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends BaseController
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    public function index()
    {
        $user = auth()->user()->load(['role', 'group', 'gender']);

        return $this->sendResponse(['user' => $user], 'User retrieved successfully.');
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

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'gender_id' => 'required|numeric',
            'phone' => 'required|numeric|digits_between:9,15',
            'birth_date' => 'required|date',
        ]);

        $user = User::find($id);

        if(!$user){
            return $this->sendError('User not found.' );
        }

        $user->update($data);

        $user = User::with([
            'group',
            'role',
            'gender',
        ])->find($id);

        return $this->sendResponse(['user' => $user], 'User updated successfully.');
    }

    public function update_photo_profile(Request $request)
    {
        $request->validate([
            'photo' => 'required|file|image|max:2048'
        ]);

        $photo = $request->file('photo');

        $user = User::with(['group', 'role', 'gender'])->find($request->user_id);

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


    public function destroy(string $id)
    {
        //
    }
}
