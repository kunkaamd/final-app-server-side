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
  Route::get('/resendmail','ApiUserController@reSendMail');
  Route::post('/create-comment/{postId}','ApiCommentController@createComment');
  Route::get('/user-info', 'ApiUserController@getUserInfo');
  Route::post('/create-post','ApiPostController@createPost');

  Route::post('/create-series','ApiSeriesController@createSeries')->middleware('permission:create-series');
  Route::get('/series-of-user','ApiSeriesController@getSeriesOfUser');

  Route::patch('/post-published/{id}','ApiPostController@publishedOn')->middleware('permission:published');
  Route::delete('/post-delete/{id}','ApiPostController@deletePost')->middleware('permission:delete-post');
});
//user
Route::get('/user-hot','ApiUserController@getUserHot');
//Tag
Route::get('/tag-popular','ApiTagController@getPopuparTag');
//post
Route::get('/post-of-user/{id}','ApiPostController@getPostsOfUser');
Route::get('/post/{id}','ApiPostController@getPost');
Route::get('/post','ApiPostController@getManyPost');
Route::get('/post-not-published','ApiPostController@getPostNotPublished');
Route::get('/post-of-series/{id}','ApiPostController@getPostsOfSeries');
//series
Route::get('/series','ApiSeriesController@getSeriesPopular');
Route::get('/series-with-posts','ApiSeriesController@getAllSeriesWithPost');

Route::get('/test', 'TestController@test');
