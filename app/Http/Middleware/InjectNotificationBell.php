<?php

namespace App\Http\Middleware;

use Closure;

class InjectNotificationBell
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (auth()->check() && auth()->user()->type === 'admin') {

            $content = $response->getContent();

            if (is_string($content) && strpos($content, 'navbar-custom-menu') !== false) {

                $bell = view('partials.notifications')->render();

                $content = str_replace('</body>', $bell . '</body>', $content);

                $response->setContent($content);
            }
        }

        return $response;
    }
}