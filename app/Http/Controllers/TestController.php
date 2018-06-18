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

        // Overview Sections
        // $obj = $ads->report()
        //         ->from('ACCOUNT_PERFORMANCE_REPORT')
        //         ->select('AccountDescriptiveName', 'Clicks', 'Impressions', 'AverageCpc', 'Cost')
        //         ->getAsObj();

        $obj = $ads->report()
                ->from('ACCOUNT_PERFORMANCE_REPORT')
                ->during('20000101','20200101')
                ->select('Date', 'Clicks', 'Impressions', 'AverageCpc', 'Cost')
                ->getAsObj();

        $items = $obj->result;

        // $campaign_id = array();
        // $campaign = array();
        // $clicks = array();
        // $impressions = array();
        // $avg_cpc = array();
        // $cost = array();    

        // foreach ($items as $key => $value) {
        //     array_push($campaign_id, $value->campaignID);
        //     array_push($campaign, $value->keywordPlacement);
        //     array_push($clicks, $value->clicks);
        //     array_push($impressions, $value->impressions);
        //     array_push($avg_cpc, $value->avgCPC);
        //     array_push($cost, $value->cost);
        // }

        // $data['campaigns_id'] = $campaign_id;
        // $data['campaigns'] = $campaign;
        // $data['clicks'] = $clicks;
        // $data['impressions'] = $impressions;
        // $data['avg_cpc'] = $avg_cpc;
        // $data['cost'] = $cost;

        // dd($data);
        // return view('ads.data', $data);
        // return response()->json([
        //     'campaigns_id' => $campaign_id,
        //     'campaigns' => $campaign,
        //     'clicks' => $clicks,
        //     'impressions' => $impressions,
        //     'avg_cpc' => $avg_cpc,
        //     'cost' => $cost
        // ]);

        return Response::json($items);
    }
}



