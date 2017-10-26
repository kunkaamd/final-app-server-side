<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;


use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'group';

    protected $fillable = ['name'];


    public static function boot()
    {
        parent::boot();

        Group::observe(new UserActionsObserver);
    }
    public function permission(){
        return $this->belongsToMany('App\Permission', 'grouppermisstion', 'group_id', 'permission_id');
    }




}
