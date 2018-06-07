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
<<<<<<< HEAD

Route::prefix('users')->group(function() {
	Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('/login', 'Auth\LoginController@login');
	Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
	Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

	Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('/password/reset', 'Auth\ResetPasswordController@reset');
	Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
});

=======
>>>>>>> parent of b34e50d... commit temp
