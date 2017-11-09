<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;


use Illuminate\Database\Eloquent\SoftDeletes;

class Posttag extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'posttag';
    
    protected $fillable = [
          'tag_id',
          'post_id'
    ];
    

    public static function boot()
    {
        parent::boot();

        Posttag::observe(new UserActionsObserver);
    }
    
    public function tag()
    {
        return $this->hasOne('App\Tag', 'id', 'tag_id');
    }


    public function post()
    {
        return $this->hasOne('App\Post', 'id', 'post_id');
    }


    
    
    
}