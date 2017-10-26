<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;


use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationGroup extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'notificationgroup';
    
    protected $fillable = [
          'notification_id',
          'group_id'
    ];
    

    public static function boot()
    {
        parent::boot();

        NotificationGroup::observe(new UserActionsObserver);
    }
    
    public function notification()
    {
        return $this->hasOne('App\Notification', 'id', 'notification_id');
    }


    public function group()
    {
        return $this->hasOne('App\Group', 'id', 'group_id');
    }


    
    
    
}