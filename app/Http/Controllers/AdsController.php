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
        // dd(env('CLIENT_CUSTOMER_ID'));

        // $adwords_client_id = UserMeta::where('user_id', '=', Auth::user()->id)
        // dd($adwords_client_id);

        // $summary->session([
            // 'clientCustomerId' => '880-440-7050',
            // 'clientId' => '502572626924-ekjmmdfjauhbt8d83m0fojtujitupgl3.apps.googleusercontent.com',
            // 'clientSecret' => '7J46SVLrliqjn7ihv7PfDgp6',
            // 'refreshToken' => '4/AAA1DCfxnZAUpBdFulbfMY3pmXj_JAFSCdzzhdpINAgL4-NFEn8MoU8'
        // ]);


        $config_date = $request->input('config');

        $from_date = $this->modifyDate(date('Ymd'), $config_date);
        // $from_date = $this->modifyDate('20171022', $config_date);
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



