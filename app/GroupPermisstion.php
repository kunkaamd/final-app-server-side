<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;


use Illuminate\Database\Eloquent\SoftDeletes;

class GroupPermisstion extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'grouppermisstion';
    
    protected $fillable = [
          'group_id',
          'permission_id'
    ];
    

    public static function boot()
    {
        parent::boot();

        GroupPermisstion::observe(new UserActionsObserver);
    }
    
    public function group()
    {
        return $this->hasOne('App\Group', 'id', 'group_id');
    }


    public function permission()
    {
        return $this->hasOne('App\Permission', 'id', 'permission_id');
    }


    
    
    
}