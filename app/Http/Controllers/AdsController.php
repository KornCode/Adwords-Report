<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Edujugon\GoogleAds\GoogleAds;
use Google\AdsApi\AdWords\v201710\cm\CampaignService;
use Google\AdsApi\AdWords\v201710\cm\BidLandscapeLandscapePoint;
use DB;
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

        // $adwords_client_id_temp = UserMeta::where('user_id', '=', Auth::user()->id)->get(['meta_value']);
        $adwords_client_id_temp = DB::select('select meta_value from umeta where user_id = ?', [Auth::user()->id]);
        $adwords_client_id = $adwords_client_id_temp[0]->meta_value;

        $summary->session([
            'clientCustomerId' => $adwords_client_id
        ]);

        $config_date = $request->input('config');

        $from_date = $this->modifyDate(date('Ymd'), $config_date);
        // $from_date = $this->modifyDate('20171022', 277);
        $to_date = date('Ymd');
        // $to_date = '20171022';

        $obj = $summary->report()
                ->from('ACCOUNT_PERFORMANCE_REPORT')
                ->during($from_date, $to_date)
                ->select('Date', 'Clicks', 'Impressions', 'AverageCpc', 'Cost')
                ->getAsObj();


        $items = $obj->result;

        return Response::json($items);
    }
}



