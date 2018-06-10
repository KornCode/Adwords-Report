<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Edujugon\GoogleAds\GoogleAds;
use Google\AdsApi\AdWords\v201710\cm\CampaignService;
use App\Http\Controllers\DB;

use Auth;

class AdWordsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function retrieveAdsData() {

        if (Auth::check()) {
            return view('ads');
        }
        else {
            echo "You must logged in as the customer to view this page.";
        }
        
		//$ads = new GoogleAds();
		//$ads->service(CampaignService::class)->select(['Id', 'Name', 'Status', 'ServingStatus', 'StartDate', 'EndDate'])->get();
		// dd($ads);
	}  
}
