<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;


use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'post';

    protected $fillable = [
          'title',
          'content',
          'image',
          'author',
          'view_count',
          'published',
          'rate',
          'source',
          'series_id',
          'user_id'
    ];

    public static $published = ["yes" => "yes", "no" => "no"];


    public static function boot()
    {
        parent::boot();

        Post::observe(new UserActionsObserver);
    }

    public function series()
    {
        return $this->belongsTo('App\Series', 'series_id');
    }


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function comment()
    {
        return $this->hasMany('App\Comment', 'post_id');
    }
    public function tag()
    {
        return $this->belongsToMany('App\Tag', 'posttag', 'post_id', 'tag_id');
    }





}
