<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HoneypotMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('POST')) {

            if ($request->filled('website')) {
                Log::warning('Honeypot triggered', ['ip' => $request->ip()]);
                return redirect()->back()->with('success', 'Email has been sent to the team.');
            }

            $loadedAt = (int) $request->input('_form_loaded_at');
            if ($loadedAt && (time() - $loadedAt) < 3) {
                Log::warning('Form submitted too fast (bot)', ['ip' => $request->ip()]);
                return redirect()->back()->with('success', 'Email has been sent to the team.');
            }
        }

        return $next($request);
    }
}