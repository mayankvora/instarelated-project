<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*Route::get('login','PostController@login');
Route::get('register','PostController@register');
Route::post('login_redirect','PostController@login_redirect');
Route::post('user_registration','PostController@user_registration');
Route::get('/dashboard','PostController@dashboard');
Route::get('/logout','PostController@logout');
Route::get('/homescreen','PostController@homescreen');
Route::get('fetch_userprofile','PostController@fetch_userprofile');
Route::get('getuser_post','PostController@getuser_post');
Route::post('adduser_post','PostController@adduser_post');
Route::get('edit_profile','PostController@edit_profile');
Route::post('update_profile','PostController@update_profile');

Route::get('getuser_feed','PostController@getuser_feed');
Route::get('search_user','PostController@search_user');
Route::get('user_like','PostController@user_like');
Route::get('following_user','PostController@following_user');
Route::post('post_comment','PostController@post_comment');
Route::get('get_comment','PostController@get_comment');
Route::post('post_comment_replay','PostController@post_comment_replay');
Route::get('get_following','PostController@get_following');
Route::get('get_followers','PostController@get_followers');
*/


Route::get('following/{user_id}','InstaController@following');
Route::get('followers/{user_id}','InstaController@followers');
Route::get('profile/{user_id}','InstaController@profile');
Route::get('get_profile/','InstaController@get_profile');
Route::get('user_comment/{post_id}/{user_id}','InstaController@user_comment');
Route::get('image/{user_id}','InstaController@image');
// Route::get('user_comment/{post_id}/{user_id}','InstaController@user_comment_data');
// Route::get('user_comment','InstaController@user_comment');


Route::get('get_post','InstaController@get_post');

Route::get('login','InstaController@login');
Route::get('register','InstaController@register');
Route::post('login_redirect','InstaController@login_redirect');
Route::post('user_registration','InstaController@user_registration');
Route::get('/dashboard','InstaController@dashboard');
Route::get('/logout','InstaController@logout');		
Route::get('/homescreen','InstaController@homescreen');
Route::get('fetch_userprofile','InstaController@fetch_userprofile');
Route::get('getuser_post','InstaController@getuser_post');
Route::post('adduser_post','InstaController@adduser_post');
Route::get('edit_profile','InstaController@edit_profile');
Route::post('update_profile','InstaController@update_profile');

Route::get('getuser_feed','InstaController@getuser_feed');
Route::get('search_user','InstaController@search_user');
Route::get('user_like','InstaController@user_like');
Route::get('following_user','InstaController@following_user');
Route::post('post_comment','InstaController@post_comment');
Route::get('get_comment','InstaController@get_comment');
Route::post('post_comment_replay','InstaController@post_comment_replay');
Route::get('get_following','InstaController@get_following');
Route::get('get_followers','InstaController@get_followers');
// Route::get('user_unfollow','InstaController@user_unfollow');
Route::get('user_dislike','InstaController@user_dislike');


Route::get('getuser_profile/{user_id}/{newuser_id}','InstaController@getuser_profile');
Route::get('getalluser_profile','InstaController@getalluser_profile');


// Route::get('showmore_comment','InstaController@showmore_comment');














