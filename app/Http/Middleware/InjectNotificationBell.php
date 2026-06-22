<?php

namespace App\Http\Middleware;

use Closure;

class InjectNotificationBell
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (auth()->check()) {

            // sirf HTML responses pe kaam karo (JSON / file download skip)
            if (!method_exists($response, 'getContent')) {
                return $response;
            }

            $content = $response->getContent();

            // Ye string AdminLTE 2 ke HAR admin page par hoti hai
            $isAdminLtePage = is_string($content)
                && strpos($content, 'AdminLTE.min.css') !== false;

            if ($isAdminLtePage) {

                /* ---------- 1) Premium CSS inject (</head> se pehle) ---------- */
                $cssTag = '<link rel="stylesheet" href="' . asset('/assets/css/admin-custom.css') . '?v=' . time() . '">';

                if (strpos($content, '</head>') !== false &&
                    strpos($content, 'admin-custom.css') === false) {
                    $content = str_replace('</head>', $cssTag . "\n</head>", $content);
                }

                /* ---------- 2) Notification bell (sirf admin) ---------- */
                if (auth()->user()->type === 'admin' &&
                    strpos($content, '</body>') !== false) {
                    $bell = view('partials.notifications')->render();
                    $content = str_replace('</body>', $bell . '</body>', $content);
                }

                $response->setContent($content);
            }
        }

        return $response;
    }
}