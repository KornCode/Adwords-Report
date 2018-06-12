<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TestController extends Controller {

    public function index() {
        $data['tasks'] = [
            [
                'name' => 'Clicks',
                'progress' => '87',
                'color' => 'danger'
            ],
            [
                'name' => 'Cost',
                'progress' => '76',
                'color' => 'warning'
            ],
            [
                'name' => 'Impression',
                'progress' => '32',
                'color' => 'success'
            ],
            [
                'name' => 'Start Building Website',
                'progress' => '56',
                'color' => 'info'
            ],
            [
                'name' => 'Develop an Awesome Algorithm',
                'progress' => '10',
                'color' => 'success'
            ]
        ];
        return view('test')->with($data);
    }
}