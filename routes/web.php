<?php
//
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

Route::get('/home', 'HomeController@index')->name('index');

// Route::get('/home/ads', 'AdWordsController@retrieveAdsData')->name('ads');

Route::get('ads_dashboard', function () {
    return view('ads_dashboard');
});

Route::group(['middleware' => ['role:user|admin','permission:view_ads']], function () {

	Route::get('test', 'TestController@index')->name('ads.dashboard');
});



Route::prefix('auth/login/')->group(function() {

	// for redirect to facebook auth.
	Route::get('facebook', 'SocialLoginController@facebookAuthRedirect');
	// facebook call back after login success.
	Route::get('facebook/home', 'SocialLoginController@facebookSuccess');

	// for redirect to github auth.
	Route::get('github', 'SocialLoginController@githubAuthRedirect');
	// github call back after login success.
	Route::get('github/home', 'SocialLoginController@githubSuccess');

	// for redirect to google auth.
	Route::get('google', 'SocialLoginController@googleAuthRedirect');
	// google call back after login success.
	Route::get('google/home', 'SocialLoginController@googleSuccess');
});

Route::prefix('users')->group(function() {

	Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('/login', 'Auth\LoginController@authenticatedUser')->name('auth.login');
	// Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
	Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

	Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('/password/reset', 'Auth\ResetPasswordController@reset');
	Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
});

Route::prefix('admin')->group(function() {

	Route::namespace('Admin')->group(function() {

		Route::group(['middleware' => ['role:admin','permission:view_ads|admin_access']], function () {

		    Route::get('/', 'AdminController@showDashboard')->name('admin.dashboard');

			/*
			|--------------------------------------------------------------------------
			| Members Mananagement
			|--------------------------------------------------------------------------
			*/
			Route::prefix('members')->group(function() {
				// Show Members
				Route::get('/', 'MemberController@showMembers')->name('admin.members.index');

				// Create Member
				Route::get('/create', 'MemberController@showCreateMember')->name('admin.members.create');
				Route::post('/create', 'MemberController@postCreateMember')->name('admin.members.create.post');

				// Edit Members
				Route::get('/edit/{user_id}', 'MemberController@showEditMember')->name('admin.members.edit');
				Route::post('/edit', 'MemberController@postEditMember')->name('admin.members.edit.post');
			});

			/*
			|--------------------------------------------------------------------------
			| Roles Management
			|--------------------------------------------------------------------------
			*/
			Route::prefix('roles')->group(function() {
				// Show Roles
				Route::get('/', 'RoleController@showRoles')->name('admin.roles.index');

				// Create Role
				Route::get('/create', 'RoleController@showCreateRole')->name('admin.roles.create');
				Route::post('/create', 'RoleController@postCreateRole')->name('admin.roles.create.post');

				// Edit Role
				Route::get('/edit/{role_id}', 'RoleController@showEditRole')->name('admin.roles.edit');
				Route::post('/edit', 'RoleController@postEditRole')->name('admin.roles.edit.post');

				// Delete Role
				Route::post('/delete', 'RoleController@postDeleteRole')->name('admin.roles.delete.post');
			});

			/*
			|--------------------------------------------------------------------------
			| Permissions Management
			|--------------------------------------------------------------------------
			*/
			Route::prefix('permissions')->group(function() {
				// Show Permissions
				Route::get('/', 'PermissionController@showPermissions')->name('admin.permissions.index');

				// Create Permissions
				Route::get('/create', 'PermissionController@showCreatePermission')->name('admin.permissions.create');
				Route::post('/create', 'PermissionController@postCreatePermission')->name('admin.permissions.create.post');

				// Edit Permissions
				Route::get('/edit/{role_id}', 'PermissionController@showEditPermission')->name('admin.permissions.edit');
				Route::post('/edit', 'PermissionController@postEditPermission')->name('admin.permissions.edit.post');

				// Delete Permissions
				Route::post('/delete', 'PermissionController@postDeletePermission')->name('admin.permissions.delete.post');
			});
		});
	});
});



















