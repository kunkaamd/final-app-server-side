<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\DB;
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
        $listpermission = $this->getPermissionOfUser($user->id);
        foreach ($listpermission as $item) {
          if($permission == $item->name){
            return $next($request);
          }
        }
        return response()->json('user is not authorized',403);
    }
    private function getPermissionOfUser($id){
      return DB::select('SELECT permission.name FROM permission WHERE permission.id IN (SELECT userpermission.permission_id FROM users INNER JOIN userpermission on users.id = userpermission.user_id WHERE users.id= :user_id1) OR permission.id IN (SELECT grouppermisstion.permission_id FROM usergroup INNER JOIN grouppermisstion ON grouppermisstion.group_id = usergroup.group_id WHERE usergroup.user_id=:user_id2)', ["user_id1"=>$id,"user_id2"=>$id]);
    }

}
