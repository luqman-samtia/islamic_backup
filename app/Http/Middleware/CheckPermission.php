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
    public function handle( $request, Closure $next ) {
        $publicPermissions = ['logincontroller.logout'];
        if ( Auth::check() ) {

            $routeArray       = Route::getCurrentRoute()->getAction();

            if(!@$routeArray['controller'])
                return $next( $request );

            $controllerAction = class_basename( $routeArray['controller'] );
            list( $controller, $action ) = explode( '@', $controllerAction );

            $permission = strtolower( $controller . '.' . $action );
            if (in_array($permission, $publicPermissions))
                return $next( $request );

            if ( ! Auth::user()->can( $permission ) ) {
                throw UnauthorizedException::forPermissions( [ $permission ] );
            }
        }
        return $next( $request );

    }
}
