<?php
// CHECK POINT
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\UserMeta;

class AdminController extends Controller
{
    /**
     * Show Dashboard
     *
     * @return \Illuminate\Http\Response
     */
	public function showDashboard(){
        $data['member_count'] = User::count();
        $data['member_with_adwordsKey'] = UserMeta::where('meta_key', 'adwords')->count();
        $data['member_with_socialKey'] = UserMeta::where('meta_key', '!=', 'adwords')->count();
        
		return view('admin.dashboard', $data);
	}
}
