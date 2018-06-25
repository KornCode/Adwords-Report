<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  \Spatie\Permission\Models\Role  $role
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $roles, $permissions, $guard = 'admin')
    {
        if (Auth::guest()) {
            return redirect()->route('index');
        }

        if (strpos($roles, "|") > 0) {
          $roles = explode('|', $roles);
        }
        if (! $request->user()->hasRole($roles)) {
           abort(403);
        }

        if (strpos($permissions, "|") > 0) {
          $permissions = explode('|', $permissions);
        }
        if (is_array($permissions)) {
          foreach ($permissions as $permission) {
            $this->checkPermission($request, $permission, $guard);
          }
        } elseif (is_string($permissions)) {
          $this->checkPermission($request, $permissions, $guard);
        }

        return $next($request);
    }

    private function checkPermission($request, $permission, $guard) {
      if (! $request->user()->hasPermissionTo($permission, $guard)) {
         abort(403);
      }
    }

}