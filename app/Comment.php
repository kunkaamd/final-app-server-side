<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;


use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'comment';
    
    protected $fillable = [
          'comment',
          'user_id',
          'post_id'
    ];
    

    public static function boot()
    {
        parent::boot();

        Comment::observe(new UserActionsObserver);
    }
    
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }


    public function post()
    {
        return $this->hasOne('App\Post', 'id', 'post_id');
    }


    
    
    
}