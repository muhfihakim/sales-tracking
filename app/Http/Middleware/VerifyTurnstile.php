<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VerifyTurnstile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $turnstileResponse = $request->input('cf-turnstile-response');
        $secretKey = env('TURNSTILE_SECRET_KEY');

        $response = Http::post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => $secretKey,
            'response' => $turnstileResponse
        ]);

        $responseBody = $response->json();

        if (!$responseBody['success']) {
            return back()->withErrors(['captcha' => 'CAPTCHA verification failed.']);
        }

        return $next($request);
    }
}
