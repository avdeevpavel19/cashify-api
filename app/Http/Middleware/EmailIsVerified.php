<?php

namespace App\Http\Middleware;

use App\Exceptions\EmailNotConfirmedException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     *
     * @throws EmailNotConfirmedException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = \Auth::user();

        if (!$user->email_verified_at) {
            throw new EmailNotConfirmedException('Пройдите верификацию аккаунта');
        }

        return $next($request);
    }
}
