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

Route::get('/', 'RecordsController@index');

// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// 認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
        Route::get('bookmarks', 'UsersController@bookmarks')->name('users.bookmarks');
    });
    
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
    
    Route::group(['prefix' => 'records/{id}'], function () {
        Route::post('bookmark', 'BookmarksController@store')->name('bookmarks.bookmark');
        Route::delete('unbookmark', 'BookmarksController@destroy')->name('bookmarks.unbookmark');
    });
    
    Route::resource('records', 'RecordsController', ['only' => ['store', 'destroy']]);
    
    
    //Route::resource('/upload', 'UploadController');
    
    //Route::get('/test/file_upload', [UploadController::class, "index"])->name('file_upload.index'); //
    //Route::post('/test/file_upload/action', [UploadController::class, "action"])->name('file_upload.action'); //
});