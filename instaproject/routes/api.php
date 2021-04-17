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

Route::middleware(['ApiAuthentication'])->group(function () 
{
	Route::post('add_post','Api\AddpostController@add_post');
	// Route::post('getuser_post','Api\AddpostController@getuser_post');
	Route::post('get_profile_data','Api\AddpostController@get_profile_data');
	Route::post('following_user','Api\AddpostController@following_user');
	Route::post('followers_user','Api\AddpostController@followers_user');
	Route::post('search_user','Api\AddpostController@search_user');
	Route::post('user_comment','Api\AddpostController@user_comment');
	Route::post('replay_comment','Api\AddpostController@replay_comment');
	Route::post('user_like','Api\AddpostController@user_like');
	Route::post('user_dislike','Api\AddpostController@user_dislike');
	Route::post('getuser_feed','Api\AddpostController@getuser_feed');
	Route::post('getusercomment_replay','Api\AddpostController@getusercomment_replay');
	Route::post('get_following','Api\AddpostController@get_following');
	Route::post('get_followers','Api\AddpostController@get_followers');
	

	
});	

Route::post('register_user','Api\AddpostController@register_user');
Route::post('login_user','Api\AddpostController@login_user');

Route::get('get_post','Api\AddpostController@get_post');


// Route::post('get_following_lat','Api\AddpostController@get_following_lat');









