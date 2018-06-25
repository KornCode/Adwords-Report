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

use Auth;
use App\User;
use App\UserMeta;

use Illuminate\Http\Request;

class AdsController extends Controller {

    public function showAdwordsSummary() {
        return view('overview');
    }

    private function modifyDate($stringDate, $config_date) {
        $date = new DateTime($stringDate);
        $date->modify('-'.$config_date.'day');
        $dateYMD = $date->format('Ymd');

        return $dateYMD;
    }

    public function postAdwordsSummary(Request $request) {

        $summary = new GoogleAds();

        $summary->session([
            'clientCustomerId' => '880-440-7050',
        ]);

        $config_date = $request->filled('config') ? $request->input('config') : 30;

        $from_date = $this->modifyDate(date('Ymd'), $config_date);
        
        $to_date = date('Ymd');

        $obj = $summary->report()
                ->from('ACCOUNT_PERFORMANCE_REPORT')
                ->during($from_date, $to_date)
                ->select('Date', 'Clicks', 'Impressions', 'AverageCpc', 'Cost')
                ->getAsObj();            

        $items = $obj->result;

        $return_data = null;
        foreach($items as $value){
            $return_data[] = $value;
        }

        $sorted = array_values(array_sort($return_data, function ($value) {
            return strtotime($value->day);
        }));

        return $sorted;
    }
}



