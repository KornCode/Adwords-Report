<?php

namespace App\Http\Controllers;

use Socialize;
use Auth;
use Redirect;
use Hash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SocialLoginController extends Controller
{
    public function __construct()
	{
	}
 
	public function index()
	{
		return view('home');
	}
 
 	/*
 	 * Facebook Social Login Controller
 	 */
	public function facebookAuthRedirect() {
 	 	return Socialize::with('facebook')->redirect();
 	}
 
 	public function facebookSuccess() {
 
 	  	$provider = Socialize::with('facebook');
 	  	if (Input::has('code')){
	    	$user = $provider->stateless()->user();
	    	//dd($user);
	    	$email = $user->email;
	    	$name  = $user->name;
	    	$password = substr($user->token,0,10);
	    	$facebook_id = $user->id;
 
	    	if($email == null){ // case permission is not email public.
	    		$user = $this->checkExistUserByFacebookId($facebook_id); 
	    		if($user == null){
	    			$email = $facebook_id;
	    		}
	    	}
	    	else
	    	{
	    		$user = $this->checkExistUserByEmail($email); 
	    		if($user != null){
		    		if($user->facebook_id == ""){ // update account when not have facebook id.
		    			$user->facebook_id = $facebook_id;
		    			$user->save();
		    		}
	    		}
	    	}
 
		    if($user != null){ // Auth exist account.
		    	Auth::login($user);
		    	return redirect('home/');
		    }
		    else{ // new Account.
		    	$user = $this->registerFacebookUser($email, $name, $password, $facebook_id);
		    	Auth::login($user);
		    	return redirect('home/');
		    }
		}
		return redirect('/');
 	}
 
 	private function checkExistUserByEmail($email){
 		$user = \App\User::where('email','=',$email)->first();
 		return $user;
 	}
 
 	private function checkExistUserByFacebookId($facebook_id){
 		$user = \App\User::where('facebook_id','=',$facebook_id)->first();
 		return $user;
 	}

	private function registerFacebookUser($email,$name,$password,$facebook_id){
 		$user = new \App\User;
 
		$user->email = $email;
		$user->name = $name;
		$user->password = Hash::make($password); // fill password with hash token
		$user->facebook_id = $facebook_id;
		$user->save();
 
		return $user;
 	}
 
 
 	/*
 	 * Github Social Login Controller
 	 */	
 	public function githubAuthRedirect() {
 	 	return Socialize::with('github')->redirect();
 	}
 
 	public function githubSuccess() {
 
 	  	$provider = Socialize::with('github');
 	  	if (Input::has('code')){
	    	$user = $provider->stateless()->user();
	    	//dd($user);
	    	$email = $user->email;
	    	$name  = $user->name;
	    	$password = substr($user->token,0,10);
	    	$github_id = $user->id;
 
	    	if($email == null){ // case permission is not email public.
	    		$user = $this->checkExistUserByGithubId($github_id); 
	    		if($user == null){
	    			$email = $github_id;
	    		}
	    	}
	    	else
	    	{
	    		$user = $this->checkExistUserByEmail($email); 
	    		if($user != null){
		    		if($user->github_id == ""){ // update account when not have facebook id.
		    			$user->github_id = $github_id;
		    			$user->save();
		    		}
	    		}
	    	}
 
		    if($user != null){ // Auth exist account.
		    	Auth::login($user);
		    	return redirect('home/');
		    }
		    else{ // new Account.
		    	$user = $this->registerGithubUser($email, $name, $password, $github_id);
		    	Auth::login($user);
		    	return redirect('home/');
		    }
		}
		return redirect('/');
 	}
 
 	private function checkExistUserByGithubId($github_id){
 		$user = \App\User::where('github_id','=',$github_id)->first();
 		return $user;
 	}

	private function registerGithubUser($email,$name,$password,$github_id){
 		$user = new \App\User;
 
		$user->email = $email;
		$user->name = $name;
		$user->password = Hash::make($password); // fill password with hash token
		$user->github_id = $github_id;
		$user->save();
 
		return $user;
 	}

 	
}
