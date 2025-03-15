<?php

namespace App\Services;

use App\Mail\ActivationEmail;
use App\Mail\ForgetPasswordEmail;
use App\Models\ActivationCode;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ForgetPasswordMailService
{
    public function sendVerificationCode($email)
    {
        $code = rand(100000, 999999);

        ActivationCode::where('email', $email)->delete();

        $data = ActivationCode::create([
            'code' => $code,
            'email' => $email,
            'status' => 'active',
        ]);

        try {
            Mail::to($email)->send(new ForgetPasswordEmail($code));
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
