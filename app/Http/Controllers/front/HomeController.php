<?php

namespace App\Http\Controllers\front;

use App\AdPricing;
use App\Ads;
use App\AdsCategory;
use App\AdsSubCategory;
use App\AutoTv;
use App\ContactUs;
use App\District;
use App\Division;
use App\Http\Controllers\Controller;
use App\Job;
use App\JobCategory;
use App\Subscribe;
use App\Tvs;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $ads_count = Ads::count();

        $total_views = Ads::sum('view_count');

        $all_category = AdsCategory::latest()->get();

        $all_division = Division::latest()->get();

        $categories = AdsCategory::take(10)->latest()->get();

        $ads = Ads::select('ads.*','divisions.name as division_name')
                ->leftJoin('divisions', function($join){
                    $join->on('ads.division_id','=','divisions.id');
                })
                ->where('approve','=',1)
                ->where('view_count', '>=', 120)
                ->orderBy('ads.id','desc')
                ->take(8)
                ->get();

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

        $recently_ads = Ads::select('ads.*','divisions.name as division_name')
                        ->leftJoin('divisions', function($join){
                            $join->on('ads.division_id','=','divisions.id');
                        })
                        ->where('approve','=',1)
                        ->latest()
                        ->take(8)
                        ->get();
        
        $tvc = Tvs::where('approve','=',1)->latest()->take(3)->get();

        $auto_tv = AutoTv::where('approve','=',1)->latest()->first();

        $ads_pricing = AdPricing::where('status','=',1)->get();

        return view('welcome', compact('all_category','categories','ads','division_ads_total','recently_ads','tvc','auto_tv','ads_pricing','ads_count','all_division','total_views'));
    }

    public function details($id)
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $ads =Ads::select('ads.*','divisions.name as division_name','districts.name as district_name','users.name as user_name','users.phone as user_phone')
                ->leftJoin('divisions', function($join){
                    $join->on('ads.division_id','=','divisions.id');
                })
                ->leftJoin('districts', function($join){
                    $join->on('ads.district_id','=','districts.id');
                })
                ->leftJoin('users', function($join){
                    $join->on('ads.user_id','=','users.id');
                })
                ->where('ads.id','=',$id)
                ->first();
        
        $ads_gallery = DB::table('ads_images')->where('ads_id',$id)->get();

        $related_ads = Ads::select('ads.*','divisions.name as division_name','ads_categories.name as category_name')
                            ->leftJoin('divisions', function($join){
                                $join->on('ads.division_id','=','divisions.id');
                            })
                            ->leftJoin('ads_categories', function($join){
                                $join->on('ads.category_id','=','ads_categories.id');
                            })
                            ->where('ads.category_id',$ads->category_id)
                            ->take(4)
                            ->get();

        return view('details',compact('ads','ads_gallery','related_ads','all_category','ads_count'));
    }

    public function addViewCount(Request $request)
    {
        $ads_id = $_GET['id'];

        $ads = Ads::findOrFail($ads_id);
        $ads->increment('view_count');
    }

    public function tvcViewCount(Request $request)
    {
        $tvc_id = $_GET['id'];

        $tvc = Tvs::findOrFail($tvc_id);
        $tvc->increment('view_count');
    }

    public function allAds()
    {
        $min_price = Ads::min('unit_price');

        $max_price = Ads::max('unit_price');

        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $all_division = Division::latest()->get();

        $ads = Ads::select('ads.*', 'ads_categories.name as category_name','divisions.name as division_name')
                ->leftJoin('ads_categories', function($join){
                    $join->on('ads.category_id','=','ads_categories.id');
                })
                ->leftJoin('divisions', function($join){
                    $join->on('ads.division_id','=','divisions.id');
                })
                ->where('ads.approve','=',1)
                ->latest()
                ->paginate(6);

        $category_ads = Ads::selectRaw('ads.*, count(ads.category_id) AS category_count')
                        ->leftJoin('ads_categories', function($join){
                            $join->on('ads.category_id','=','ads_categories.id');
                        })
                        ->groupBy('ads.category_id')
                        ->get();
        
        $category = AdsCategory::latest()->get();

        $sub_category = AdsSubCategory::latest()->get();

        $total_cat_sub = [];

        foreach($category as $cat)
        {
            $total_cat_sub[$cat->id] = array("category_name" => $cat->name, "category_count" => 0, "category_image" => $cat->image);

            foreach($category_ads as $ca){
                if($cat->id == $ca->category_id){
                    $total_cat_sub[$cat->id] = array("category_name" => $cat->name, "category_count" => $ca->category_count, "category_image" => $cat->image);
                }
            }
        }

        return view('all_ads', compact('ads','total_cat_sub','all_category','ads_count','all_division','min_price','max_price','sub_category'));
    }

    public function adsSearch(Request $request)
    {
        $min_price = Ads::min('unit_price');

        $max_price = Ads::max('unit_price');

        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $all_division = Division::latest()->get();

        $search = $request->search;
        $division_id = $request->division_id;
        $category_id = $request->category_id;

        $ads = Ads::when($division_id, function($query) use ($request){
                        $query->where('division_id', '=', $request->division_id);
                    })
                    ->when($category_id, function($query) use ($request){
                        $query->where('category_id', '=',  $request->category_id);
                    })
                    ->when($search, function($query) use ($request){
                        $query->where('name', 'like', '%'.$request->search.'%');
                    })
                    ->where('ads.approve','=',1)
                    ->paginate(8);


        $category_ads = Ads::selectRaw('ads.*, count(ads.category_id) AS category_count')
                        ->leftJoin('ads_categories', function($join){
                            $join->on('ads.category_id','=','ads_categories.id');
                        })
                        ->groupBy('ads.category_id')
                        ->get();
        
        $category = AdsCategory::latest()->get();

        $sub_category = AdsSubCategory::latest()->get();

        $total_cat_sub = [];

        foreach($category as $cat)
        {
            $total_cat_sub[$cat->id] = array("category_name" => $cat->name, "category_count" => 0, "category_image" => $cat->image);

            foreach($category_ads as $ca){
                if($cat->id == $ca->category_id){
                    $total_cat_sub[$cat->id] = array("category_name" => $cat->name, "category_count" => $ca->category_count, "category_image" => $cat->image);
                }
            }
        }

        return view('all_ads', compact('ads','total_cat_sub','all_category','ads_count','all_division','min_price','max_price'));
    }

    public function adsPriceRange(Request $request)
    {
        $min_price = Ads::min('unit_price');

        $max_price = Ads::max('unit_price');

        $filter_min_price = $request->min_price;

        $filter_max_price = $request->max_price;

        //$category_id = $request->category_id;
         
        #Get products according to filter
        if($filter_min_price && $filter_max_price){
            if($filter_min_price >0 && $filter_max_price >0)
            {
            $ads = Ads::select('ads.*', 'ads_categories.name as category_name','divisions.name as division_name')
                            ->leftJoin('ads_categories', function($join){
                                $join->on('ads.category_id','=','ads_categories.id');
                            })
                            ->leftJoin('divisions', function($join){
                                $join->on('ads.division_id','=','divisions.id');
                            })
                            // ->where('ads.category_id', $category_id)
                            ->where('ads.approve','=',1)
                            ->whereBetween('unit_price',[$filter_min_price,$filter_max_price])
                            ->paginate(8);
            
            

          }
        }  
        #Show default product list in Blade file
        else{
            $ads = Ads::select('ads.*', 'ads_categories.name as category_name','divisions.name as division_name')
                    ->leftJoin('ads_categories', function($join){
                        $join->on('ads.category_id','=','ads_categories.id');
                    })
                    ->leftJoin('divisions', function($join){
                        $join->on('ads.division_id','=','divisions.id');
                    })
                    // ->where('ads.category_id', $category_id)
                    ->where('ads.approve','=',1)
                    ->paginate(8);
        }

        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $all_division = Division::latest()->get();

        $category_ads = Ads::selectRaw('ads.*, count(ads.category_id) AS category_count')
                        ->leftJoin('ads_categories', function($join){
                            $join->on('ads.category_id','=','ads_categories.id');
                        })
                        ->groupBy('ads.category_id')
                        ->get();
        
        $category = AdsCategory::latest()->get();

        $sub_category = AdsSubCategory::latest()->get();

        $total_cat_sub = [];

        foreach($category as $cat)
        {
            $total_cat_sub[$cat->id] = array("category_name" => $cat->name, "category_count" => 0, "category_image" => $cat->image);

            foreach($category_ads as $ca){
                if($cat->id == $ca->category_id){
                    $total_cat_sub[$cat->id] = array("category_name" => $cat->name, "category_count" => $ca->category_count, "category_image" => $cat->image);
                }
            }
        }
        
        return view('all_ads', compact('ads','total_cat_sub','all_category','ads_count','all_division','min_price','max_price'));
    }

    public function categoryAds($id)
    {
        $min_price = Ads::min('unit_price');

        $max_price = Ads::max('unit_price');

        $category_id = AdsCategory::findOrFail($id);

        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $all_division = Division::latest()->get();

        $ads = Ads::select('ads.*', 'ads_categories.name as category_name','divisions.name as division_name')
                    ->leftJoin('ads_categories', function($join){
                        $join->on('ads.category_id','=','ads_categories.id');
                    })
                    ->leftJoin('divisions', function($join){
                        $join->on('ads.division_id','=','divisions.id');
                    })
                    ->where('ads.category_id', $id)
                    ->where('ads.approve','=',1)
                    ->paginate(8);

        $category_ads = Ads::selectRaw('ads.*, count(ads.category_id) AS category_count')
                        ->leftJoin('ads_categories', function($join){
                            $join->on('ads.category_id','=','ads_categories.id');
                        })
                        ->groupBy('ads.category_id')
                        ->get();
        
        $category = AdsCategory::latest()->get();

        $sub_category = AdsSubCategory::latest()->get();

        $total_cat_sub = [];

        foreach($category as $cat)
        {
            $total_cat_sub[$cat->id] = array("category_name" => $cat->name, "category_count" => 0, "category_image" => $cat->image);

            foreach($category_ads as $ca){
                if($cat->id == $ca->category_id){
                    $total_cat_sub[$cat->id] = array("category_name" => $cat->name, "category_count" => $ca->category_count, "category_image" => $cat->image);
                }
            }
        }

        return view('category_ads',compact('ads','total_cat_sub','all_category','ads_count','sub_category','all_division','min_price','max_price','category_id'));
    }

    public function categorySearch(Request $request)
    {
        $min_price = Ads::min('unit_price');

        $max_price = Ads::max('unit_price');

        $search = $request->search;
        $division_id = $request->division_id;
        $category_id = $request->category_id;

        $ads = Ads::when($division_id, function($query) use ($request){
                        $query->where('division_id', '=', $request->division_id);
                    })
                    ->when($category_id, function($query) use ($request){
                        $query->where('category_id', '=',  $request->category_id);
                    })
                    ->when($search, function($query) use ($request){
                        $query->where('name', 'like', '%'.$request->search.'%');
                    })
                    ->where('ads.approve','=',1)
                    ->paginate(8);

        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $all_division = Division::latest()->get();

        $category_ads = Ads::selectRaw('ads.*, count(ads.category_id) AS category_count')
        ->leftJoin('ads_categories', function($join){
            $join->on('ads.category_id','=','ads_categories.id');
        })
        ->groupBy('ads.category_id')
        ->get();

        $category = AdsCategory::latest()->get();

        $sub_category = AdsSubCategory::latest()->get();

        $total_cat_sub = [];

        foreach($category as $cat)
        {
            $total_cat_sub[$cat->id] = array("category_name" => $cat->name, "category_count" => 0, "category_image" => $cat->image);

            foreach($category_ads as $ca){
                if($cat->id == $ca->category_id){
                    $total_cat_sub[$cat->id] = array("category_name" => $cat->name, "category_count" => $ca->category_count, "category_image" => $cat->image);
                }
            }
        }

        return view('category_ads',compact('ads','total_cat_sub','all_category','ads_count','sub_category','all_division','min_price','max_price'));
    }

    public function priceRange(Request $request)
    {
        $min_price = Ads::min('unit_price');

        $max_price = Ads::max('unit_price');

        $filter_min_price = $request->min_price;

        $filter_max_price = $request->max_price;

        //$category_id = $request->category_id;
         
        #Get products according to filter
        if($filter_min_price && $filter_max_price){
            if($filter_min_price >0 && $filter_max_price >0)
            {
            $ads = Ads::select('ads.*', 'ads_categories.name as category_name','divisions.name as division_name')
                            ->leftJoin('ads_categories', function($join){
                                $join->on('ads.category_id','=','ads_categories.id');
                            })
                            ->leftJoin('divisions', function($join){
                                $join->on('ads.division_id','=','divisions.id');
                            })
                            // ->where('ads.category_id', $category_id)
                            ->where('ads.approve','=',1)
                            ->whereBetween('unit_price',[$filter_min_price,$filter_max_price])
                            ->paginate(8);
            
            

          }
        }  
        #Show default product list in Blade file
        else{
            $ads = Ads::select('ads.*', 'ads_categories.name as category_name','divisions.name as division_name')
                    ->leftJoin('ads_categories', function($join){
                        $join->on('ads.category_id','=','ads_categories.id');
                    })
                    ->leftJoin('divisions', function($join){
                        $join->on('ads.division_id','=','divisions.id');
                    })
                    // ->where('ads.category_id', $category_id)
                    ->where('ads.approve','=',1)
                    ->paginate(8);
        }

        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $all_division = Division::latest()->get();

        $category_ads = Ads::selectRaw('ads.*, count(ads.category_id) AS category_count')
        ->leftJoin('ads_categories', function($join){
            $join->on('ads.category_id','=','ads_categories.id');
        })
        ->groupBy('ads.category_id')
        ->get();

        $category = AdsCategory::latest()->get();

        $sub_category = AdsSubCategory::latest()->get();

        $total_cat_sub = [];

        foreach($category as $cat)
        {
            $total_cat_sub[$cat->id] = array("category_name" => $cat->name, "category_count" => 0, "category_image" => $cat->image);

            foreach($category_ads as $ca){
                if($cat->id == $ca->category_id){
                    $total_cat_sub[$cat->id] = array("category_name" => $cat->name, "category_count" => $ca->category_count, "category_image" => $cat->image);
                }
            }
        }

        return view('category_ads',compact('ads','total_cat_sub','all_category','ads_count','sub_category','all_division','min_price','max_price'));
    }

    public function subCategoryAds($id)
    {
        $min_price = Ads::min('unit_price');

        $max_price = Ads::max('unit_price');

        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $all_division = Division::latest()->get();

        $ads = Ads::select('ads.*', 'ads_categories.name as category_name','divisions.name as division_name')
                    ->leftJoin('ads_categories', function($join){
                        $join->on('ads.category_id','=','ads_categories.id');
                    })
                    ->leftJoin('divisions', function($join){
                        $join->on('ads.division_id','=','divisions.id');
                    })
                    ->where('ads.sub_category_id', $id)
                    ->where('ads.approve','=',1)
                    ->paginate(6);

        $category_ads = Ads::selectRaw('ads.*, count(ads.category_id) AS category_count')
                        ->leftJoin('ads_categories', function($join){
                            $join->on('ads.category_id','=','ads_categories.id');
                        })
                        ->groupBy('ads.category_id')
                        ->get();
        
        $category = AdsCategory::latest()->get();

        $sub_category = AdsSubCategory::latest()->get();

        $total_cat_sub = [];

        foreach($category as $cat)
        {
            $total_cat_sub[$cat->id] = array("category_name" => $cat->name, "category_count" => 0, "category_image" => $cat->image, "sub_category" => '');

            foreach($category_ads as $ca){
                if($cat->id == $ca->category_id){
                    $total_cat_sub[$cat->id] = array("category_name" => $cat->name, "category_count" => $ca->category_count, "category_image" => $cat->image, "sub_category" => '');
                }
            }
        }

        return view('sub_category',compact('ads','total_cat_sub','all_category','ads_count','sub_category','all_division','min_price','max_price'));
    }

    public function subCategorySearch(Request $request)
    {
        $min_price = Ads::min('unit_price');

        $max_price = Ads::max('unit_price');

        $search = $request->search;
        $division_id = $request->division_id;
        $category_id = $request->category_id;

        $ads = Ads::when($division_id, function($query) use ($request){
                        $query->where('division_id', '=', $request->division_id);
                    })
                    ->when($category_id, function($query) use ($request){
                        $query->where('category_id', '=',  $request->category_id);
                    })
                    ->when($search, function($query) use ($request){
                        $query->where('name', 'like', '%'.$request->search.'%');
                    })
                    ->where('ads.approve','=',1)
                    ->paginate(8);

        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $all_division = Division::latest()->get();

        $category_ads = Ads::selectRaw('ads.*, count(ads.category_id) AS category_count')
        ->leftJoin('ads_categories', function($join){
            $join->on('ads.category_id','=','ads_categories.id');
        })
        ->groupBy('ads.category_id')
        ->get();

        $category = AdsCategory::latest()->get();

        $sub_category = AdsSubCategory::latest()->get();

        $total_cat_sub = [];

        foreach($category as $cat)
        {
            $total_cat_sub[$cat->id] = array("category_name" => $cat->name, "category_count" => 0, "category_image" => $cat->image, "sub_category" => '');

            foreach($category_ads as $ca){
                if($cat->id == $ca->category_id){
                    $total_cat_sub[$cat->id] = array("category_name" => $cat->name, "category_count" => $ca->category_count, "category_image" => $cat->image, "sub_category" => '');
                }
            }
        }

        return view('sub_category',compact('ads','total_cat_sub','all_category','ads_count','sub_category','all_division','min_price','max_price'));
    }

    public function subCategoryPriceRange(Request $request)
    {
        $min_price = Ads::min('unit_price');

        $max_price = Ads::max('unit_price');

        $filter_min_price = $request->min_price;

        $filter_max_price = $request->max_price;
         
        #Get products according to filter
        if($filter_min_price && $filter_max_price){
            if($filter_min_price >0 && $filter_max_price >0)
            {
            $ads = Ads::select('ads.*', 'ads_categories.name as category_name','divisions.name as division_name')
                            ->leftJoin('ads_categories', function($join){
                                $join->on('ads.category_id','=','ads_categories.id');
                            })
                            ->leftJoin('divisions', function($join){
                                $join->on('ads.division_id','=','divisions.id');
                            })
                            // ->where('ads.category_id', $category_id)
                            ->where('ads.approve','=',1)
                            ->whereBetween('unit_price',[$filter_min_price,$filter_max_price])
                            ->paginate(8);
            
            

          }
        }  
        #Show default product list in Blade file
        else{
            $ads = Ads::select('ads.*', 'ads_categories.name as category_name','divisions.name as division_name')
                    ->leftJoin('ads_categories', function($join){
                        $join->on('ads.category_id','=','ads_categories.id');
                    })
                    ->leftJoin('divisions', function($join){
                        $join->on('ads.division_id','=','divisions.id');
                    })
                    // ->where('ads.category_id', $category_id)
                    ->where('ads.approve','=',1)
                    ->paginate(8);
        }

        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $all_division = Division::latest()->get();

        $category_ads = Ads::selectRaw('ads.*, count(ads.category_id) AS category_count')
        ->leftJoin('ads_categories', function($join){
            $join->on('ads.category_id','=','ads_categories.id');
        })
        ->groupBy('ads.category_id')
        ->get();

        $category = AdsCategory::latest()->get();

        $sub_category = AdsSubCategory::latest()->get();

        $total_cat_sub = [];

        foreach($category as $cat)
        {
            $total_cat_sub[$cat->id] = array("category_name" => $cat->name, "category_count" => 0, "category_image" => $cat->image, "sub_category" => '');

            foreach($category_ads as $ca){
                if($cat->id == $ca->category_id){
                    $total_cat_sub[$cat->id] = array("category_name" => $cat->name, "category_count" => $ca->category_count, "category_image" => $cat->image, "sub_category" => '');
                }
            }
        }

        return view('sub_category',compact('ads','total_cat_sub','all_category','ads_count','sub_category','all_division','min_price','max_price'));
    }

    public function allCategory()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        return view('all_category', compact('all_category','ads_count'));
    }

    public function allTvc()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $tvc = Tvs::latest()->paginate(3);

        return view('all_tvc', compact('tvc','all_category','ads_count'));
    }

    public function tvcDetails($id)
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $tvc = Tvs::findOrfail($id);

        return view('tvc_details', compact('tvc','all_category','ads_count'));
    }

    public function allLocation()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $division_ads = Ads::selectRaw('ads.*, count(ads.division_id) AS division_count')
                        ->leftJoin('divisions', function($join){
                            $join->on('ads.division_id','=','divisions.id');
                        })
                        ->groupBy('ads.division_id')
                        ->where('ads.approve','=',1)
                        ->get();

        $divisions = Division::get();

        $division_ads_total = [];

        foreach($divisions as $key => $division)
        {
            $division_ads_total[$division->name] = array("id" => $division->id, "image" => $division->image, "total" => 0);

            foreach($division_ads as $k => $ad){

                if($division->id == $ad->division_id){

                    $division_ads_total[$division->name] = array("id" => $division->id, "image" => $division->image, "total" => $ad->division_count);

                }

            }

        }

        return view('all_location', compact('division_ads_total','all_category','ads_count'));
    }

    public function allDistrict($id)
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $division = Division::findOrfail($id);

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

        return view('district', compact('district_ads_total','division','all_category','ads_count'));
    }

    public function divisionAds($id)
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $division = Division::findOrFail($id);

        $ads = Ads::select('ads.*','ads_categories.name as category_name')
                    ->leftJoin('ads_categories', function($join){
                        $join->on('ads.category_id','=','ads_categories.id');
                    })
                    ->where('ads.division_id', $id)
                    ->where('ads.approve','=',1)
                    ->latest()
                    ->paginate(6);

        $category_ads = Ads::selectRaw('ads.*, count(ads.category_id) AS category_count')
                        ->leftJoin('ads_categories', function($join){
                            $join->on('ads.category_id','=','ads_categories.id');
                        })
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

        return view('division_ads', compact('division','ads','total_cat_sub','all_category','ads_count'));
    }

    public function districtAds($id)
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $district = District::findOrFail($id);

        $ads = Ads::select('ads.*','ads_categories.name as category_name')
                ->leftJoin('ads_categories', function($join){
                    $join->on('ads.category_id','=','ads_categories.id');
                })
                ->where('ads.district_id', $id)
                ->where('ads.approve','=',1)
                ->latest()
                ->paginate(6);

        $category_ads = Ads::selectRaw('ads.*, count(ads.category_id) AS category_count')
                    ->leftJoin('ads_categories', function($join){
                        $join->on('ads.category_id','=','ads_categories.id');
                    })
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

        return view('district_ads', compact('district','ads','total_cat_sub','all_category','ads_count'));
    }

    public function jobCategory()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $job_category = JobCategory::latest()->get();

        $job = Job::selectRaw('jobs.*, count(jobs.category_id) AS category_count')
                    ->leftJoin('job_categories', function($join){
                        $join->on('jobs.category_id','=','job_categories.id');
                    })
                    ->groupBy('jobs.category_id')
                    ->where('jobs.approve','=',1)
                    ->get();

        $total_cat_job = [];

        foreach($job_category as $jc){
            $total_cat_job[$jc->name] = array("id" => $jc->id, "image" => $jc->image, "total" => 0);

            foreach($job as $j){
                if($jc->id == $j->category_id){
                    $total_cat_job[$jc->name] = array("id" => $jc->id, "image" => $jc->image, "total" => $j->category_count);
                }
            }
        }

        
        return view('job_category', compact('total_cat_job','all_category','ads_count'));
    }

    public function categoryJobList($id)
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $single_job_category = JobCategory::findOrFail($id);

        $job_category = JobCategory::latest()->get();

        $jobs = Job::where('category_id', $id)->paginate(6);

        return view('category_job_list', compact('jobs','job_category','single_job_category','all_category','ads_count'));
    }

    public function allJob()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $job_category = JobCategory::latest()->get();

        $jobs = Job::where('approve','=',1)->latest()->paginate(6);

        return view('job', compact('jobs','job_category','all_category','ads_count'));
    }

    public function jobSearch(Request $request)
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $job_category = JobCategory::latest()->get();

        $all_division = Division::latest()->get();

        $search = $request->search;
        $division_id = $request->division_id;
        $category_id = $request->category_id;

        $jobs = Job::when($category_id, function($query) use ($request){
                        $query->where('category_id', '=',  $request->category_id);
                    })
                    ->when($search, function($query) use ($request){
                        $query->where('name', 'like', '%'.$request->search.'%');
                    })
                    ->where('jobs.approve','=',1)
                    ->paginate(8);

        return view('job', compact('jobs','job_category','all_category','ads_count'));
    }

    public function jobDetails($id)
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $job = Job::findOrFail($id);
        
        return view('job_details', compact('job','all_category','ads_count'));
    }

    public function subscribe(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $subscribe = new Subscribe();

                $subscribe->email = $request->email;

                $subscribe->save();

                DB::commit();

                return response()->json([
                    'message' => 'Subscribe successful'
                ],Response::HTTP_CREATED);

            }catch(QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return response()->json([
                    'error' => $error
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function search(Request $request)
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $search = $request->search;
        $division_id = $request->division_id;
        $category_id = $request->category_id;

        $result = Ads::when($division_id, function($query) use ($request){
                        $query->where('division_id', '=', $request->division_id);
                    })
                    ->when($category_id, function($query) use ($request){
                        $query->where('category_id', '=',  $request->category_id);
                    })
                    ->when($search, function($query) use ($request){
                        $query->where('name', 'like', '%'.$request->search.'%');
                    })
                    ->get();

        return view('search', compact('result','ads_count','all_category'));
    }

    public function Strategy()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        return view('strategy', compact('ads_count','all_category'));
    }

    public function missionVission()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        return view('mission_vission', compact('ads_count','all_category'));
    }

    public function Management()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();
        
        $director_image1 = asset('/img/Md-Ahsan-Habib-Hirak-Managing-Director.png');
        $chairman_image = asset('/img/Md-Sirajul-Haque-Chairman.png');
        $director_image2 = asset('/img/Mohammad-Kamruzzaman-Director.png');

        $team = array(
            array("name" => "Md.Ahsan Habib Hirak", "company_name" => "Public market", "details" => "He is Managing disector of the company", "image" => $director_image1, "position" => "Managing Director"),
            array("name" => "Md. Sirajul Haque", "company_name" => "Public market", "details" => "He is Chairman of the company", "image" =>  $chairman_image, "position" => "Chairman"),
            array("name" => "Mohammad Kamruzzaman", "company_name" => "Public market", "details" => "He is Director of the company", "image" => $director_image2, "position" => "Director"),
        );

        return view('management', compact('ads_count','all_category','team'));
    }

    public function SellingTips()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        return view('sellings_tips', compact('ads_count','all_category'));
    }

    public function buySellQuick()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        return view('buy_sell_quick_tips', compact('ads_count','all_category'));
    }

    public function pricingTips()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        return view('pricing_tips', compact('ads_count','all_category'));
    }

    public function bannerAds()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        return view('banner_ads', compact('ads_count','all_category'));
    }

    public function promoteAds()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        return view('promote_ads', compact('ads_count','all_category'));
    }

    public function contactUs()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        return view('contact_us', compact('ads_count','all_category'));
    }

    public function contactUsStore(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $contact_us = new ContactUs();

                $contact_us->name = $request->name;
                $contact_us->email = $request->email;
                $contact_us->subject = $request->subject;
                $contact_us->message = $request->message;

                $contact_us->save();

                DB::commit();

                return response()->json([
                    'message' => 'Message send successful'
                ],Response::HTTP_OK);

            }catch(QueryException $e){

                DB::rollBack();

                $error = $e->getMessage();

                return response()->json([
                    'error' => $error
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function privacyPolicy()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        return view('privacy_policy', compact('ads_count','all_category'));
    }

    public function termsConditions()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        return view('terms_conditions', compact('ads_count','all_category'));
    }

    public function safe()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        return view('safe', compact('ads_count','all_category'));
    }

    public function faq()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        return view('faq', compact('ads_count','all_category'));
    }

    public function siteMap()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        $divisions = Division::latest()->get();

        return view('sitemap', compact('ads_count','all_category','divisions'));
    }

    public function refund_policy()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        return view('refund_policy', compact('ads_count','all_category'));
    }

    public function bin_no()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        return view('bin_no', compact('ads_count','all_category'));
    }

    public function about()
    {
        $ads_count = Ads::count();

        $all_category = AdsCategory::latest()->get();

        return view('about', compact('ads_count','all_category'));
    }
}
