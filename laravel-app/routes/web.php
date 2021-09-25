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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('social-auth/{provider}/callback','SocialLoginController@providerCallback');
// Route::get('social-auth/{provider}','SocialLoginController@redirectToProvider')->name('social.redirect');

// GitHubの認証後に戻るためのルーティング
Route::get('social-auth/{provider}/callback','Auth\SocialLoginController@providerCallback');
// GitHubの認証ベージに遷移するためのルーティング
Route::get('social-auth/{provider}','Auth\SocialLoginController@redirectToProvider')->name('social.redirect');