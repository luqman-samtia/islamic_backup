<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // public function handle( $request, Closure $next ) {
    //     $publicPermissions = ['logincontroller.logout'];
    //     if ( Auth::check() ) {

    //         $routeArray       = Route::getCurrentRoute()->getAction();

    //         if(!@$routeArray['controller'])
    //             return $next( $request );

    //         $controllerAction = class_basename( $routeArray['controller'] );
    //         list( $controller, $action ) = explode( '@', $controllerAction );

    //         $permission = strtolower( $controller . '.' . $action );
    //         if (in_array($permission, $publicPermissions))
    //             return $next( $request );

    //         if ( ! Auth::user()->can( $permission ) ) {
    //             throw UnauthorizedException::forPermissions( [ $permission ] );
    //         }
    //     }
    //     return $next( $request );

    // }
 public function handle($request, Closure $next) {
    // Define public permissions that everyone can access, including non-authenticated users
    $publicPermissions = ['logincontroller.logout'];

    // Allow all users (authenticated or not) to access public permissions
    if (in_array(Route::currentRouteName(), $publicPermissions)) {
        return $next($request);
    }

    // Check if the user is authenticated
    if (Auth::check()) {
        $user = Auth::user();

        // If the user is an admin, check permissions
        if ($user->type === 'admin') {
            $routeArray = Route::getCurrentRoute()->getAction();

            // If no controller is associated with the route, allow access
            if (!@$routeArray['controller']) {
                return $next($request);
            }

            // Extract controller and action
            $controllerAction = class_basename($routeArray['controller']);
            list($controller, $action) = explode('@', $controllerAction);

            // Build permission string
            $permission = strtolower($controller . '.' . $action);

            // Check if the admin has the required permission
            if (!Auth::user()->can($permission)) {
                throw UnauthorizedException::forPermissions([$permission]);
            }
        }

        // Allow non-admin users to access all routes without checking permissions
        return $next($request);
    }

    // If not authenticated, simply proceed without redirection
    return $next($request);
}

    
}
