<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
class VerifyPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$permission)
    {
        $user = $request->get('user');
        foreach ($user->permission as $item) {
          if($permission == $item->name){
            return $next($request);
          }
        }
        foreach ($user->group as $group) {
            foreach ($group->permission as $item) {
              if($permission == $item->name){
                return $next($request);
              }
            }
        }
        return response()->json('user is not authorized',403);
    }
}
