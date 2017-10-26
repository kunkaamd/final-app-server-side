<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/auth/register', 'ApiUserController@register');
Route::post('/auth/login', 'ApiUserController@login');
Route::group(['middleware' => 'jwt.auth'], function () {
  Route::post('/create-comment/{postId}','ApiCommentController@createComment');
  Route::get('/user-info', 'ApiUserController@getUserInfo');
  Route::post('/create-post','ApiPostController@createPost');
    //create,edit,delete posts of this user
  Route::post('/post/published','ApiPostController@publishedOn')->middleware('permission:published');
});
Route::get('/post-of-user/{id}','ApiPostController@getPostsOfUser');
Route::get('/post/{id}','ApiPostController@getPost');
Route::get('/post','ApiPostController@getManyPost');
Route::get('/post-of-series/{id}','ApiPostController@getPostsOfSeries');

Route::get('/series','SeriesController@getAllSeries');
Route::get('/series-with-posts','SeriesController@getAllSeriesWithPost');
Route::post('/test', 'TestController@test');
