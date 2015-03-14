<?php namespace App\Http\Middleware;

use App\Component\Js;
use Lang;
use Closure;
use Route;
use App\Models\Backend\System\Access as AccessModel;

class AclAuthenticate {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $status = AccessModel::hasRoutePermission(Route::currentRouteName());
        if (!$status) {
            if ($request->ajax()) {
                return Js::response(Lang::get('params.10006'), false);
            } else {
                return Js::error(Lang::get('params.10006'));
            }
        }

        return $next($request);
    }

}
