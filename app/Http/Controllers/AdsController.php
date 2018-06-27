<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Edujugon\GoogleAds\GoogleAds;
use Google\AdsApi\AdWords\v201710\cm\CampaignService;
use Google\AdsApi\AdWords\v201710\cm\BidLandscapeLandscapePoint;
use Response;

use DateTime;
use DatePeriod;
use DateIntercal;

use DB;
use Auth;
use App\User;
use App\UserMeta;

use Illuminate\Http\Request;

class AdsController extends Controller {

    private function modifyDate($stringDate, $config_date) {
        $date = new DateTime($stringDate);
        $date->modify('-'.$config_date.'day');
        $dateYMD = $date->format('Ymd');

        return $dateYMD;
    }

    public function postAdwordsKey() {
        $adwordsKey_temp = UserMeta::select('meta_value')->where('meta_key', '=', 'adwords')->where('meta_value', '!=', null)->get();

        $adwordsKey = array();
        foreach ($adwordsKey_temp as $key) {
            array_push($adwordsKey, $key->meta_value);
        }

        return $adwordsKey;
    }

    public function showAdwordsSummary() {
        return view('overview');
    }

    public function postAdwordsSummary(Request $request) {

        $summary = new GoogleAds();

        /*
		|---------------------------------------
		| Key Mananagement
		|---------------------------------------
		*/
        if ($request->filled('config_key')) {
            $config_key = $request->input('config_key');
        }
        else {
            $config_key_temp = UserMeta::where('user_id', '=', Auth::user()->id)->where('meta_key', '=', 'adwords')->first();
            $config_key = $config_key_temp->meta_value;
        }
        
        $summary->session([
            'clientCustomerId' => $config_key,
        ]);

        /*
		|---------------------------------------
		| Date Mananagement
		|---------------------------------------
		*/
        $config_date = $request->filled('config_date') ? $request->input('config_date') : 90;
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
            $value->day = date('d/m/Y', strtotime($value->day));
            $return_data[] = $value;
        }

        $sorted = array_values(array_sort($return_data, function ($value) {
            return strtotime($value->day);
        }));

        $ads_key = $this->postAdwordsKey();

        $items = array();
        array_push($items, $sorted, $ads_key);

        return $items;
    }
}



