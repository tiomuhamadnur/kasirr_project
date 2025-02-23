<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\API\BaseController as BaseController;

class EmailVerified extends BaseController
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return $this->sendError('Unauthorized.');
        }

        // Periksa apakah email sudah diverifikasi
        if (is_null(Auth::user()->email_verified_at)) {
            return $this->sendError('Email not verified.');
        }

        return $next($request);
    }
}
