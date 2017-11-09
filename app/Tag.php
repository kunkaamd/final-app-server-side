<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;


use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'tag';
    
    protected $fillable = ['name'];
    

    public static function boot()
    {
        parent::boot();

        Tag::observe(new UserActionsObserver);
    }
    
    
    
    
}