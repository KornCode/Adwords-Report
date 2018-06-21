<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Edujugon\GoogleAds\GoogleAds;
use Google\AdsApi\AdWords\v201710\cm\CampaignService;
use Google\AdsApi\AdWords\v201710\cm\BidLandscapeLandscapePoint;
use App\Http\Controllers\DB;
use Response;

use DateTime;
use DatePeriod;
use DateIntercal;

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

    private function modifyDate($stringDate, $config_date) {
        $date = new DateTime($stringDate);
        $date->modify('-'.$config_date.'day');
        $dateYMD = $date->format('Ymd');

        return $dateYMD;
    }

    public function showAdwordsSummary(Request $request) {

        $summary = new GoogleAds();

        $config_date = $request->input('config');

        // $from_date = $this->modifyDate(date('Ymd'), 277);
        $from_date = $this->modifyDate('20171022', $config_date);
        // $to_date = date('Ymd');
        $to_date = '20171022';

        $obj = $summary->report()
                ->from('ACCOUNT_PERFORMANCE_REPORT')
                ->during($from_date, $to_date)
                ->select('Date', 'Clicks', 'Impressions', 'AverageCpc', 'Cost')
                ->getAsObj();

        $items = $obj->result;

        return Response::json($items);
    }

    // public function showAdwordsBudget(Request $request) {
        
    //     $budget = new GoogleAds();

    //     $obj = $budget->report()
    //             ->select('BudgetName')
    //             ->from('BUDGET_PERFORMANCE_REPORT')
    //             ->saveToFile('/public')
    //             ->getAsObj();

    //     $items = $obj->result;
    // }
}



