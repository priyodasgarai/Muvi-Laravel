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
Route::any('/add-post', 'adminController\postController@create');
Route::any('admin-post', 'adminController\postController@post_get');   
Route::get('admin-post-edit-{id}', 'adminController\postController@post_edit');
Route::put('admin-post-submit-{id}', 'adminController\postController@post_edit_submit');
Route::get('admin-post-delete-{id}', 'adminController\postController@post_delete');



Route::get('/', 'adminController\postController@view_post'); 
Route::get('/post-details-{id}', 'adminController\postController@post_details'); 
Route::get('/play-video-{id}', 'adminController\postController@play_video'); 

/*
Route::get('/react', function () {
    return view('welcome');
});
Route::get('/', function () {
    return "Hi this is a e-com web";
});

Route::get('/login', function () {
    return view('admin-view.login');
});

Route::get('/dashboard', function () {
    //return 'dashboard';
    return view('user.user_new');
});
 
 */