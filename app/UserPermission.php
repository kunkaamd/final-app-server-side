<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;


use Illuminate\Database\Eloquent\SoftDeletes;

class UserPermission extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'userpermission';
    
    protected $fillable = [
          'user_id',
          'permission_id'
    ];
    

    public static function boot()
    {
        parent::boot();

        UserPermission::observe(new UserActionsObserver);
    }
    
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }


    public function permission()
    {
        return $this->hasOne('App\Permission', 'id', 'permission_id');
    }


    
    
    
}