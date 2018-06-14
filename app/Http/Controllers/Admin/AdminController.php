<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Show Dashboard
     *
     * @return \Illuminate\Http\Response
     */
	public function showDashboard(){
		return view('admin.dashboard');
	}
}
