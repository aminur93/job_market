<?php

namespace App\Http\Controllers\api\v1;

use App\Ads;
use App\AdsCategory;
use App\AdsSubCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index()
    {
        $category_ads = Ads::selectRaw('ads.*, count(ads.category_id) AS category_count')
                ->leftJoin('ads_categories', function($join){
                    $join->on('ads.category_id','=','ads_categories.id');
                })
                ->where('ads.approve','=',1)
                ->groupBy('ads.category_id')
                ->get();

        $category = AdsCategory::take(10)->latest()->get();

        $total_cat = [];

        foreach($category as $cat){
            $total_cat[$cat->name] = array("category_ads_count" => 0, "category_image" => $cat->image);

            foreach($category_ads as $ca){
                if($cat->id == $ca->category_id){
                    $total_cat[$cat->name] = array("category_ads_count" => $ca->category_count,"category_image" => $cat->image);
                }
            }
        }

        return response()->json([
            'ads_category' => $total_cat
        ],Response::HTTP_OK);
    }

    public function allCategory()
    {
        $category_ads = Ads::selectRaw('ads.*, count(ads.category_id) AS category_count')
                ->leftJoin('ads_categories', function($join){
                    $join->on('ads.category_id','=','ads_categories.id');
                })
                ->where('ads.approve','=',1)
                ->groupBy('ads.category_id')
                ->get();

        $category = AdsCategory::latest()->get();

        $total_cat = [];

        foreach($category as $cat){
            $total_cat[$cat->name] = array("category_ads_count" => 0, "category_image" => $cat->image);

            foreach($category_ads as $ca){
                if($cat->id == $ca->category_id){
                    $total_cat[$cat->name] = array("category_ads_count" => $ca->category_count,"category_image" => $cat->image);
                }
            }
        }
        return response()->json([
            'all_ads_category' => $total_cat
        ],Response::HTTP_OK);
    }

    public function categoryProduct($id)
    {
        $ads = Ads::select('ads.*', 'ads_categories.name as category_name','divisions.name as division_name')
                ->leftJoin('ads_categories', function($join){
                    $join->on('ads.category_id','=','ads_categories.id');
                })
                ->leftJoin('divisions', function($join){
                    $join->on('ads.division_id','=','divisions.id');
                })
                ->where('ads.category_id', $id)
                ->where('ads.approve','=',1)
                ->paginate(6);

        $category_ads = Ads::selectRaw('ads.*, count(ads.category_id) AS category_count')
                ->leftJoin('ads_categories', function($join){
                    $join->on('ads.category_id','=','ads_categories.id');
                })
                ->where('ads.approve','=',1)
                ->groupBy('ads.category_id')
                ->get();

        $category = AdsCategory::latest()->get();

        $sub_category = AdsSubCategory::latest()->get();

        $total_cat_sub = [];

        foreach($category as $cat){
            $total_cat_sub[$cat->name] = array("category_count" => 0, "category_image" => $cat->image, "sub_category" => []);

            foreach($category_ads as $ca){
                if($cat->id == $ca->category_id){
                    $total_cat_sub[$cat->name] = array("category_count" => $ca->category_count,"category_image" => $cat->image, "sub_category" => []);
                }
            }

            foreach($sub_category as $sc){
                if($cat->id == $sc->category_id){
                    $total_cat_sub[$cat->name] = array("category_count" => $ca->category_count,"category_image" => $cat->image, "sub_category" => [$sc->name]);
                }
            }
        }

        return response()->json([
            'ads' => $ads,
            'total_category' => $total_cat_sub
        ],Response::HTTP_OK);
    }

    public function categorySearch(Request $request)
    {
        $search = $request->search;

        $search_result = AdsCategory::where('name','like','%'.$search.'%')->get();

        if(count($search_result) > 0)
        {
            return response()->json([
                'caetgory_search' => $search_result
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'No category found'
            ],Response::HTTP_OK);
        }
        
    }
}
