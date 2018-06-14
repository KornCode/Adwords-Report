<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\User;
use Validator;
use Mail;
use App\Mail\NewUserWelcome;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Show Dashboard
     *
     * @return \Illuminate\Http\Response
     */
	public function showMembers(){
		$data['members'] = User::all();
		return view('admin.members.index', $data);
	}

    /**
     * Show Create Member Form
     *
     * @return \Illuminate\Http\Response
     */
     public function showCreateMember(){
        return view('admin.members.create');
     }

    private function registerUser($email, $first_name, $last_name, $password, $token) {
        $user = new User;
        $user->email = $email;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->password = Hash::make($password); // fill password with hash token
        $user->remember_token = $token;
        $user->save();

        return $user;
    }

    /**
     * Create a new Member
     *
     * @return \Illuminate\Http\Response
     */ 
     public function postCreateMember(Request $request){

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        };

        $first_name = $request->get('first_name');
        $last_name = $request->get('last_name');
        $email = $request->get('email');
        $password = str_random(16);
        $token = NULL;

        $this->registerUser($email, $first_name, $last_name, $password, $token);

        Mail::to($email)->send(new NewUserWelcome($email, $password));

        return redirect()->route('admin.members.index');
     }

	/**
     * Show Edit Member Form
     *
     * @return \Illuminate\Http\Response
     */
	public function showEditMember($user_id){
		$data['member'] = User::find($user_id);
		$data['roles'] = Role::all()->groupBy('guard_name');
		return view('admin.members.edit', $data);
	}

     /**
     * Save edited member to database
     *
     * @return \Illuminate\Http\Response
     */ 
     public function postEditMember(Request $request){

        $validator = Validator::make($request->all(), [
            'new_password' => 'nullable|min:8',
            'new_password_confirm' => 'required_with:new_password|same:new_password',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        };

		$member = User::find($request->get('member_id'));
		$member->first_name = $request->get('first_name');
		$member->last_name = $request->get('last_name');
        $member->password = $request->has('new_password_confirm') ? bcrypt($request->get('new_password_confirm')) : $member->password;
		$member->save();

        $roles = $request->has('roles') ? $request->get('roles') : [];

        $member->roles()->sync($roles);

		return redirect()->back()->with("success" , "Member saved successfully");

     }
}
