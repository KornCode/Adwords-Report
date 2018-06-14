<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Validator;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Show Roles
     *
     * @return \Illuminate\Http\Response
     */
     public function showRoles(){
     	$data['roles'] = Role::all(); // data from spatie lib
     	return view('admin.roles.index', $data);
     }    

     /**
     * Show Create Role Form
     *
     * @return \Illuminate\Http\Response
     */
     public function showCreateRole(){
     	return view('admin.roles.create');
     }   

     /**
     * Create a new Role
     *
     * @return \Illuminate\Http\Response
     */ 
     public function postCreateRole(Request $request){

          $validator = Validator::make($request->all(), [
               'name' => 'required|unique:roles|max:255',
               'guard_name' => 'required',
          ]);
		if ($validator->fails()) {
		    return back()->withErrors($validator)->withInput();
		}

		$role = Role::create(['guard_name' => $request->get('guard_name'), 'name' => $request->get('name')]);

		return redirect()->route('admin.roles.index');

     }

     /**
     * Show edit role form
     *
     * @return \Illuminate\Http\Response
     */ 
     public function showEditRole($role_id){
     	$data['role'] = Role::find($role_id);
          $data['permissions'] = Permission::all()->groupBy('guard_name');;
     	return view('admin.roles.edit', $data);
     }


     /**
     * Save edited role to database
     *
     * @return \Illuminate\Http\Response
     */ 
     public function postEditRole(Request $request){

          $validator = Validator::make($request->all(), [
               'role_id' => 'required',
               'name' => 'required|max:255',
               'guard_name' => 'required',
          ]);
		if ($validator->fails()) {
		    return back()->withErrors($validator)->withInput();
		};
		$role = Role::find($request->get('role_id'));
		$role->name = $request->get('name');
		$role->guard_name = $request->get('guard_name');
		$role->save();

          $permissions = $request->has('permissions') ? $request->get('permissions') : [];

          $role->permissions()->sync($permissions);

		return redirect()->route('admin.roles.index');

     }

     /**
     * Delete Role
     *
     * @return \Illuminate\Http\Response
     */ 
     public function postDeleteRole(Request $request){
          $role = Role::find($request->get('role_id'));
          $validator = Validator::make($request->all(), [
               'delete_name' => 'required|in:'.$role->name,
          ]);
          if ($validator->fails()) {
              return back()->withErrors($validator)->withInput();
          }
          $role->delete();
          return redirect()->route('admin.roles.index');
     }
}
