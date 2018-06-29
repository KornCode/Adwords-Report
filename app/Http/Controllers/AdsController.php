<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Google\AdsApi\AdWords\v201710\cm\CampaignService;
use Google\AdsApi\AdWords\v201710\cm\BidLandscapeLandscapePoint;
use DB;
use Response;
use App\User;
use App\UserMeta;
use Auth;
use DateTime;
use Edujugon\GoogleAds\GoogleAds;
use Illuminate\Http\Request;

class AdsController extends Controller
{

    public function postAdwordsKey()
    {
        $adwordsKey_temp = UserMeta::select('meta_value')->where('meta_key', '=', 'adwords')->where('meta_value', '!=', null)->get();

        $adwordsKey = array();
        foreach ($adwordsKey_temp as $key) {
            array_push($adwordsKey, $key->meta_value);
        }

        return $adwordsKey;
    }

    public function showAdwordsSummary()
    {
        return view('overview');
    }

    public function postAdwordsSummary(Request $request)
    {

        $summary = new GoogleAds();

        $config_key = null;

        /*
        |---------------------------------------
        | Key Mananagement
        |---------------------------------------
         */
        if ($request->filled('config_key')) {
            $config_key = $request->input('config_key');
        } else {
            $config_key_temp = UserMeta::where('user_id', '=', Auth::user()->id)->where('meta_key', '=', 'adwords')->first();
            if ($config_key_temp) {
                $config_key = $config_key_temp->meta_value;
            }
        }

        $summary->session([
            'clientCustomerId' => $config_key,
        ]);

        /*
        |---------------------------------------
        | Date Mananagement
        |---------------------------------------
         */
        $config_date = $request->filled('config_date') ? $request->input('config_date') : 'first day of this month';

        // $from_date = $this->modifyDate(date('Ymd'), $config_date);
        // $to_date = date('Ymd');

        switch ($config_date) {
            case 'today':
                $from_date = date('Ymd');
                $to_date = date('Ymd');
                break;
            case 'yesterday':
                $from_date = date('Ymd', strtotime('yesterday'));
                $to_date = date('Ymd', strtotime('yesterday'));
                break;
            default:
                $from_date = date('Ymd', strtotime($config_date));
                $to_date = date('Ymd');
                break;
        }

        $obj = $summary->report()
            ->from('ACCOUNT_PERFORMANCE_REPORT')
            ->during($from_date, $to_date)
            ->select('Date', 'Clicks', 'Impressions', 'AverageCpc', 'Cost')
            ->getAsObj();

        $items = $obj->result;

        $return_data = null;
        foreach ($items as $value) {
            $value->day = date('Y/m/d', strtotime($value->day));
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
