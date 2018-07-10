<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Validator;

use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Show Permissions
     *
     * @return \Illuminate\Http\Response
     */
     public function showPermissions(){
     	$data['permissions'] = Permission::all();
     	return view('admin.permissions.index', $data);
     }    

     /**
     * Show Create Permissions Form
     *
     * @return \Illuminate\Http\Response
     */
     public function showCreatePermission(){
     	return view('admin.permissions.create');
     }   

     /**
     * Create a new Permission
     *
     * @return \Illuminate\Http\Response
     */ 
     public function postCreatePermission(Request $request){

	    $validator = Validator::make($request->all(), [
	        'name' => 'required|unique:permissions|max:255',
	        'guard_name' => 'required',
	    ]);
		if ($validator->fails()) {
		    return back()->withErrors($validator)->withInput();
		}

		$role = Permission::create(['guard_name' => $request->get('guard_name'), 'name' => $request->get('name')]);

		return redirect()->route('admin.permissions.index');

     }

     /**
     * Show edit permissions form
     *
     * @return \Illuminate\Http\Response
     */ 
     public function showEditPermission($role_id){
     	$data['permission'] = Permission::find($role_id);
     	return view('admin.permissions.edit', $data);
     }


     /**
     * Save edited permissions to database
     *
     * @return \Illuminate\Http\Response
     */ 
     public function postEditPermission(Request $request){

	    $validator = Validator::make($request->all(), [
			'permission_id' => 'required',
			'name' => 'required|max:255',
			'guard_name' => 'required',
	    ]);
		if ($validator->fails()) {
		    return back()->withErrors($validator)->withInput();
		}

		$role = Permission::find($request->get('permission_id'));
		$role->name = $request->get('name');
		$role->guard_name = $request->get('guard_name');
		$role->save();

		return redirect()->route('admin.permissions.index');

     }

     /**
     * Delete Permission
     *
     * @return \Illuminate\Http\Response
     */ 
     public function postDeletePermission(Request $request){
          $role = Permission::find($request->get('permission_id'));
          $validator = Validator::make($request->all(), [
               'delete_name' => 'required|in:'.$role->name,
          ]);
          if ($validator->fails()) {
              return back()->withErrors($validator)->withInput();
          }
          $role->delete();
          return redirect()->route('admin.permissions.index');
     }
}
