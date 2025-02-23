<?php

namespace App\Services;

use App\Mail\ActivationEmail;
use App\Models\ActivationCode;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ActivationMailService
{
    public function sendActivationCode($email)
    {
        $user = Auth::user();

        // Pastikan user sudah login
        if (!$user) {
            return [
                'success' => false,
                'message' => 'User not authenticated'
            ];
        }

        $code = rand(100000, 999999);

        ActivationCode::where('user_id', $user->id)->delete();

        $data = ActivationCode::create([
            'code' => $code,
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        try {
            Mail::to($email)->send(new ActivationEmail($code));
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to send activation email',
                'error' => $e->getMessage()
            ];
        }

        return $data->code;
    }
}
