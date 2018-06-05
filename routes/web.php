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

// for redirect to facebook auth.
Route::get('auth/login/facebook', 'SocialLoginController@facebookAuthRedirect');
// facebook call back after login success.
Route::get('auth/login/facebook/home', 'SocialLoginController@facebookSuccess');

// for redirect to github auth.
Route::get('auth/login/github', 'SocialLoginController@githubAuthRedirect');
// github call back after login success.
Route::get('auth/login/github/home', 'SocialLoginController@githubSuccess');

// for redirect to google auth.
Route::get('auth/login/google', 'SocialLoginController@googleAuthRedirect');
// google call back after login success.
Route::get('auth/login/google/home', 'SocialLoginController@googleSuccess');
