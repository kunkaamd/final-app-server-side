<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;


use Illuminate\Database\Eloquent\SoftDeletes;

class Series extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'series';

    protected $fillable = [
          'name',
          'user_id',
          'postnumber'
    ];


    public static function boot()
    {
        parent::boot();

        Series::observe(new UserActionsObserver);
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function post()
    {
      return $this->hasMany('App\Post','series_id');
    }





}
