<?php

namespace App\Http\Controllers\api\v1;

use App\Ads;
use App\District;
use App\Division;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LocationController extends Controller
{
    public function adsDivision()
    {
        $division_ads = Ads::selectRaw('ads.*, count(ads.division_id) AS division_count')
                            ->leftJoin('divisions', function($join){
                                $join->on('ads.division_id','=','divisions.id');
                            })
                            ->groupBy('ads.division_id')
                            ->where('ads.approve','=',1)
                            ->get();

        $divisions = Division::take(3)->get();

        $division_ads_total = [];

        foreach($divisions as $key => $division)
        {
            $division_ads_total[$division->name] = array("id" => $division->id, "image" => $division->image, "total" => 0);
            
            foreach($division_ads as $k => $ad){
                
                if($division->id == $ad->division_id){
                    
                    $division_ads_total[$division->name] = array("id" => $division->id,"image" => $division->image, "total" => $ad->division_count);
                    
                }
                
            }
            
        }

        return response()->json([
            'division_ads' => $division_ads_total
        ],Response::HTTP_OK);
    }

    public function allDivision()
    {
        $division_ads = Ads::selectRaw('ads.*, count(ads.division_id) AS division_count')
                        ->leftJoin('divisions', function($join){
                            $join->on('ads.division_id','=','divisions.id');
                        })
                        ->groupBy('ads.division_id')
                        ->where('ads.approve','=',1)
                        ->get();

        $divisions = Division::latest()->get();

        $division_ads_total = [];

        foreach($divisions as $key => $division)
        {
            $division_ads_total[$division->name] = array("id" => $division->id, "image" => $division->image, "total" => 0);

            foreach($division_ads as $k => $ad){

                if($division->id == $ad->division_id){

                    $division_ads_total[$division->name] = array("id" => $division->id,"image" => $division->image, "total" => $ad->division_count);

                }

            }

        }

        return response()->json([
            'all_divisions' => $division_ads_total
        ],Response::HTTP_OK);

    }

    public function allDistrict($id)
    {

        $district = District::where('division_id', $id)->get();

        $district_ad = Ads::selectRaw('ads.*, count(ads.district_id) AS district_count')
                        ->leftJoin('districts', function($join){
                            $join->on('ads.district_id','=','districts.id');
                        })
                        ->groupBy('ads.district_id')
                        ->where('ads.approve','=',1)
                        ->get();

        $district_ads_total = [];

        foreach($district as $key => $d)
        {
            $district_ads_total[$d->name] = array("id" => $d->id, "image" => $d->image, "total" => 0);

            foreach($district_ad as $k => $da){

                if($d->id == $da->district_id){

                    $district_ads_total[$d->name] = array("id" => $d->id,"image" => $d->image, "total" => $da->district_count);

                }

            }

        }

        if(count($district_ads_total) > 0)
        {
            return response()->json([
                'district_ads' => $district_ads_total
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'No Data Found'
            ],Response::HTTP_OK);
        }
    }

    public function allDivisionAds($id)
    {
        $ads = Ads::select('ads.*','ads_categories.name as category_name')
                ->leftJoin('ads_categories', function($join){
                    $join->on('ads.category_id','=','ads_categories.id');
                })
                ->where('ads.division_id', $id)
                ->where('ads.approve','=',1)
                ->latest()
                ->paginate(6);

        return response()->json([
            'division_ads' => $ads
        ],Response::HTTP_OK);
    }

    public function allDistrictAds($id)
    {
        $ads = Ads::select('ads.*','ads_categories.name as category_name')
                ->leftJoin('ads_categories', function($join){
                    $join->on('ads.category_id','=','ads_categories.id');
                })
                ->where('ads.district_id', $id)
                ->where('ads.approve','=',1)
                ->latest()
                ->paginate(6);

        return response()->json([
            'division_ads' => $ads
        ],Response::HTTP_OK);
    }
}
