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

if (env('APP_ENV') === 'production') {
    URL::forceScheme('https');
}

Route::get('/', function () {
	// return view('welcome');
	return redirect()->route('login');
});

Auth::routes();

Route::any('/get_components', 'EmbedController@testFunction')->middleware('cors');

Route::get('/home', 'HomeController@index')->name('index');

Route::group(['middleware' => []], function () {

	Route::get('/overview', 'AdsController@showAdwords')->name('ads.dashboard');
	Route::post('/overview', 'AdsController@postAdwords')->name('ads.dashboard.post');
	// Route::get('/debug', 'AdsController@postAdwords')->name('ads.dashboard');

	// Embed
	// Route::get('/embed', 'EmbedController@sendEmbedCode')->name('embed');
	// Route::post('/embed', 'EmbedController@postSendEmbedCode')->name('embed.embed');
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
	Route::post('/login', 'Auth\LoginController@login');
	// Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
	Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

	Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('/password/reset', 'Auth\ResetPasswordController@reset');
	Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
});


/*
|--------------------------------------------------------------------------
| Admin Mananagement
|--------------------------------------------------------------------------
*/
route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function() {

	Route::group(['middleware' => ['role:admin,admin_access']], function () {

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

		/*
		|--------------------------------------------------------------------------
		| Widgets Management
		|--------------------------------------------------------------------------
		*/
		Route::prefix('widgets')->group(function() {
			// Show Widget
			Route::get('/', 'WidgetController@showWidgets')->name('admin.widgets.index');

			// Create Widget
			Route::get('/create_widget', 'WidgetController@showCreateWidget')->name('admin.widgets.create');
			Route::post('/create_widget', 'WidgetController@postCreateWidget')->name('admin.widgets.create.post');

			// Create Component
			route::get('/create_comp', 'WidgetController@showCreateComponent')->name('admin.components.create');
			route::post('/create_comp', 'WidgetController@postCreateComponent')->name('admin.components.create.post');

			// Create Widget Component
			Route::get('/create_wc', 'WidgetController@showCreateWidgetComponent')->name('admin.widget.component.create');
			Route::post('/create_wc', 'WidgetController@postCreateWidgetComponent')->name('admin.widget.component.create.post');

			// Edit Widget
			Route::get('/edit_widget/{widget_id}', 'WidgetController@showEditWidget')->name('admin.widgets.edit');
			route::post('/edit_widget', 'WidgetController@postEditWidget')->name('admin.widgets.edit.post');

			// Edit Component
			Route::get('/edit_comp/{component_id}', 'WidgetController@showEditComponent')->name('admin.components.edit');
			route::post('/edit_comp', 'WidgetController@postEditComponent')->name('admin.components.edit.post');

			// Edit Widget Component
			Route::get('/edit_wc/{wid_comp_id}', 'WidgetController@showEditWidgetComponent')->name('admin.widget.component.edit');
			route::post('/edit_wc', 'WidgetController@postEditWidgetComponent')->name('admin.widget.component.edit.post');

			// Delete Widget
			Route::post('/delete_widget', 'WidgetController@postDeleteWidget')->name('admin.widgets.delete.post');
			// Delete Component
			Route::post('/delete_comp', 'WidgetController@postDeleteComponent')->name('admin.components.delete.post');
			// Delete Widget Component
			Route::post('/delete_wc', 'WidgetController@postDeleteWidgetComponent')->name('admin.widget.component.delete.post');
		});
	});
});



















