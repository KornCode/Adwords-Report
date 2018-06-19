<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use App\UserMeta;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Socialize;
use Auth;
use Redirect;
use Hash;

class SocialLoginController extends Controller
{
    public function __construct() {

	}
 
	public function index() {
		return view('home');
	}

	private function registerUser($email, $first_name, $last_name, $password, $token) {
 		$user = new User;
		$user->email = $email;
		$user->first_name = $first_name;
		$user->last_name = $last_name;
		$user->password = Hash::make($password); // fill password with hash token
		$user->remember_token = $token;
		$user->assignRole('user');
        $user->givePermissionTo('view ads dashboard');
		$user->save();

		return $user;
 	}

 	private function registerUserMeta($uid, $key, $value) {
 		$new_user_meta = new UserMeta;
		$new_user_meta->user_id = $uid;
		$new_user_meta->meta_key = $key;
		$new_user_meta->meta_value = $value;
		$new_user_meta->save();

		return $new_user_meta;
 	}

 	/*
 	 * Facebook Social Login Controller
 	 */
	public function facebookAuthRedirect() {
 	 	return Socialize::with('facebook')->redirect();
 	}

 	public function facebookSuccess() {
 		$provider = Socialize::with('facebook');
 		if (Input::has('code')) {
 			
 			$user = $provider->stateless()->user();
 			//dd($user);
 			$name = explode(" ", $user->name);
 			$first_name = $name[0];
 			$last_name = $name[1];
 			$email = $user->email;
 			$token = Hash::make($user->token);
 			$password = substr($token, 0, 10);
 			$facebook_id = $user->id;

 			// Check whether email exsist in users table or not
	 		if (User::where('email', '=', $email)->exists()) {

	 			$local_user = User::where('email', '=', $email)->first();

	 			// Check if user email has meta facebook id in meta table or not
	 			if (UserMeta::where('user_id', '=', $local_user->id)->where('meta_value', '=', $facebook_id)->exists()) {
	 				// Login
	 				Auth::login($local_user);
			    	return redirect('home/');
	 			}
	 			// Add user meta to new meta table
	 			else {
		    		$this->registerUserMeta($local_user->id, 'facebook', $facebook_id);
		    		Auth::login($local_user);
			    	return redirect('home/');
	 			}
	 		}
	 		else {
	 			// Register and record in users table
	 			$new_user = $this->registerUser($email, $first_name, $last_name, $password, $token);

		    	// Add user meta to meta table
		    	$this->registerUserMeta($new_user->id, 'facebook', $facebook_id);

		    	Auth::login($new_user);
		    	return redirect('home/');
	 		}
 		} 
 		else {
 			return redirect('/did_not_receive_user_data_from_facebook');
 		}

 		return redirect('/');
 	}

 	
 
 	/*
 	 * Github Social Login Controller
 	 */	
 	public function githubAuthRedirect() {
 	 	return Socialize::with('github')->redirect();
 	}
 
 	public function githubSuccess() {
 
 	  	$provider = Socialize::with('github');
 		if (Input::has('code')) {
 			
 			$user = $provider->stateless()->user();
 			//dd($user);
 			$name = explode(" ", $user->name);
 			$first_name = $name[0];
 			$last_name = $name[1];
 			$email = $user->email;
 			$token = Hash::make($user->token);
 			$password = substr($token, 0, 10);
 			$github_id = $user->id;

 			// Check whether email exsist in users table or not
	 		if (User::where('email', '=', $email)->exists()) {

	 			$local_user = User::where('email', '=', $email)->first();

	 			// Check if user email has meta facebook id in meta table or not
	 			if (UserMeta::where('user_id', '=', $local_user->id)->where('meta_value', '=', $github_id)->exists()) {
	 				// Login
	 				Auth::login($local_user);
			    	return redirect('home/');
	 			}
	 			// Add user meta to new meta table
	 			else {
		    		$this->registerUserMeta($local_user->id, 'github', $github_id);
		    		Auth::login($local_user);
			    	return redirect('home/');
	 			}
	 		}
	 		else {
	 			// Register and record in users table
	 			$new_user = $this->registerUser($email, $first_name, $last_name, $password, $token);

		    	// Add user meta to meta table
		    	$this->registerUserMeta($new_user->id, 'github', $github_id);

		    	Auth::login($new_user);
		    	return redirect('home/');
	 		}
 		} 
 		else {
 			return redirect('/did_not_receive_user_data_from_github');
 		}

 		return redirect('/');
 	}

 	/*
 	 * Google+ Social Login Controller
 	 */	
 	public function googleAuthRedirect() {
 	 	return Socialize::with('google')->redirect();
 	}
 
 	public function googleSuccess() {
 
 	  	$provider = Socialize::with('google');
 		if (Input::has('code')) {
 			
 			$user = $provider->stateless()->user();
 			//dd($user);
 			$name = explode(" ", $user->name);
 			$first_name = $name[0];
 			$last_name = $name[1];
 			$email = $user->email;
 			$token = Hash::make($user->token);
 			$password = substr($token, 0, 10);
 			$google_id = $user->id;

 			// Check whether email exsist in users table or not
	 		if (User::where('email', '=', $email)->exists()) {

	 			$local_user = User::where('email', '=', $email)->first();

	 			// Check if user email has meta facebook id in meta table or not
	 			if (UserMeta::where('user_id', '=', $local_user->id)->where('meta_value', '=', $google_id)->exists()) {
	 				// Login
	 				Auth::login($local_user);
			    	return redirect('home/');
	 			}
	 			// Add user meta to new meta table
	 			else {
		    		$this->registerUserMeta($local_user->id, 'google', $google_id);
		    		Auth::login($local_user);
			    	return redirect('home/');
	 			}
	 		}
	 		else {
	 			// Register and record in users table
	 			$new_user = $this->registerUser($email, $first_name, $last_name, $password, $token);

		    	// Add user meta to meta table
		    	$this->registerUserMeta($new_user->id, 'google', $google_id);

		    	Auth::login($new_user);
		    	return redirect('home/');
	 		}
 		} 
 		else {
 			return redirect('/did_not_receive_user_data_from_google');
 		}

 		return redirect('/');
 	}
}
