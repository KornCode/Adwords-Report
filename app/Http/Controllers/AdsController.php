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

        $adwords_client_id_temp = DB::select('select meta_value from umeta where user_id = ?', [Auth::user()->id]);
        $adwords_client_id = $adwords_client_id_temp[0]->meta_value;

        if ($adwords_client_id !== null) {

            $summary->session([
                'clientCustomerId' => $adwords_client_id
            ]);
    
            $config_date = $request->input('config');
    
            $from_date = $this->modifyDate(date('Ymd'), $config_date);
            $to_date = date('Ymd');
    
            $obj = $summary->report()
                    ->from('ACCOUNT_PERFORMANCE_REPORT')
                    ->during($from_date, $to_date)
                    ->select('Date', 'Clicks', 'Impressions', 'AverageCpc', 'Cost')
                    ->getAsObj();
    
    
            $items1 = $obj->result;
            $items2 = $this->postAdwordsKey();

            $items = array();
            array_push($items, $items1, $items2);
    
            return Response::json($items);
        }
        else {

            return view('overview')->with('is_empty', "true");
        }
    }

    public function postAdwordsKey() {
        $adwordsKey_temp = UserMeta::select('meta_value')->where('meta_key', '=', 'adwords')->where('meta_value', '!=', null)->get();

        $adwordsKey = array();
        foreach ($adwordsKey_temp as $key) {
            array_push($adwordsKey, $key->meta_value);
        }

        return $adwordsKey;
    }
}



