<?php

namespace App\Http\Middleware;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

use Closure;

class MustBeAdministrator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->role = 'admin') {
            return redirect('/admin');
        }
        else {
            return redirect('/test');
        }

        return $next($request);
    }
}
