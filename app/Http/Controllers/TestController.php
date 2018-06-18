<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Edujugon\GoogleAds\GoogleAds;
use Google\AdsApi\AdWords\v201710\cm\CampaignService;
use Google\AdsApi\AdWords\v201710\cm\BidLandscapeLandscapePoint;
use App\Http\Controllers\DB;
use Response;

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

    public function showAdwords() {
        $ads = new GoogleAds();

        $obj = $ads->report()
                ->from('ACCOUNT_PERFORMANCE_REPORT')
                ->during('20000101','20200101')
                ->select('Date', 'Clicks', 'Impressions', 'AverageCpc', 'Cost')
                ->getAsObj();

        $items = $obj->result;

        return Response::json($items);
    }
}



