<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;


use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'permission';

    protected $fillable = [
          'name',
          'description'
    ];


    public static function boot()
    {
        parent::boot();

        Permission::observe(new UserActionsObserver);
    }




}
