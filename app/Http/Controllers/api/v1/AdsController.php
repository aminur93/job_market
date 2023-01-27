<?php

namespace App\Http\Controllers\api\v1;

use App\Ads;
use App\AdsCategory;
use App\AdsSubCategory;
use App\Customer;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;

class AdsController extends Controller
{

    public function index()
    {
        $customer_id = auth('api')->id();

        $ads = Ads::where('customer_id', $customer_id)->paginate(10);

        if(empty($ads))
        {
            return response()->json([
                'message' => 'No Data Found'
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'ads' => $ads
            ],Response::HTTP_OK);
        }
    }

    public function store(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try {
                //code...

                $ads = new Ads();

                $ads->customer_id = auth('api')->id();
                $ads->category_id = $request->category_id;
                $ads->sub_category_id = $request->sub_category_id;
                $ads->division_id = $request->division_id;
                $ads->district_id = $request->district_id;
                $ads->title = $request->title;
                $ads->name = $request->name;
                $ads->brand_name = $request->brand_name;
                $ads->model = $request->model;
                $ads->authenticity = $request->authenticity;
                $ads->bluetooth = $request->bluetooth;
                $ads->camera = $request->camera;
                $ads->platform = $request->platform;
                $ads->display = $request->display;
                $ads->memory = $request->memory;
                $ads->land_type = $request->land_type;
                $ads->bedrooms = $request->bedrooms;
                $ads->bathrooms = $request->bathrooms;
                $ads->size = $request->size;
                $ads->address = $request->address;
                $ads->land_size = $request->land_size;
                $ads->unit = $request->unit;
                $ads->house_size = $request->house_size;
                $ads->type = $request->type;
                $ads->condition = $request->condition;
                $ads->unit_price = $request->unit_price;

                if($request->price_on_call == false)
                {
                    $ads->price_on_call = 0;
                }else{
                    $ads->price_on_call = 1;
                }

                $ads->description = $request->description;

                if($request->hasFile('image')){

                    $image_tmp = $request->file('image');

                    if($image_tmp->isValid()){

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/ads/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/ads/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/ads/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/ads/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);


                        $ads->image = $image_name;
                    }
                }

                $ads->date = $request->date;

                $ads->save();

                $ads_id = DB::getPdo()->lastInsertId();

                if ($request->gallery_image !== null){
                    foreach ($request->gallery_image as $gi){

                        $images = $request->file($gi);

                        $extenson =$gi->getClientOriginalExtension();
                        $filename = rand(111,99999).'.'.$extenson;

                        $original_image_path = public_path().'/assets/admin/uploads/ads_gallery/original/'.$filename;
                        $large_image_path = public_path().'/assets/admin/uploads/ads_gallery/large/'.$filename;
                        $medium_image_path = public_path().'/assets/admin/uploads/ads_gallery/medium/'.$filename;
                        $small_image_path = public_path().'/assets/admin/uploads/ads_gallery/small/'.$filename;

                        //Resize Image
                        Image::make($gi)->save($original_image_path);
                        Image::make($gi)->resize(1110,680)->save($large_image_path);
                        Image::make($gi)->resize(520,329)->save($medium_image_path);
                        Image::make($gi)->resize(100,75)->save($small_image_path);

                        DB::table('ads_images')->insert([
                            'ads_id' => $ads_id,
                            'image' => $filename,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                    }
                }

                DB::commit();

                return response()->json([
                    'message' => 'Customer Ads store successful'
                ], Response::HTTP_CREATED);


            } catch (Exception $e) {
                //throw $e;

                DB::rollback();

                $error = $e->getMessage();

                return response()->json([
                    'error' => $error
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function edit($id)
    {
        $customer_id =  auth('api')->id();

        $ad = Ads::where('id', $id)->where('customer_id', $customer_id)->first();

        return response()->json([
            'ad' => $ad
        ],Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try {
                //code...

                $ads = Ads::findOrFail($id);

                $ads->customer_id = auth('api')->id();
                $ads->category_id = $request->category_id;
                $ads->sub_category_id = $request->sub_category_id;
                $ads->division_id = $request->division_id;
                $ads->district_id = $request->district_id;
                $ads->title = $request->title;
                $ads->name = $request->name;
                $ads->brand_name = $request->brand_name;
                $ads->model = $request->model;
                $ads->authenticity = $request->authenticity;
                $ads->bluetooth = $request->bluetooth;
                $ads->camera = $request->camera;
                $ads->platform = $request->platform;
                $ads->display = $request->display;
                $ads->memory = $request->memory;
                $ads->land_type = $request->land_type;
                $ads->bedrooms = $request->bedrooms;
                $ads->bathrooms = $request->bathrooms;
                $ads->size = $request->size;
                $ads->address = $request->address;
                $ads->land_size = $request->land_size;
                $ads->unit = $request->unit;
                $ads->house_size = $request->house_size;
                $ads->type = $request->type;
                $ads->condition = $request->condition;
                $ads->unit_price = $request->unit_price;

                if($request->price_on_call == false)
                {
                    $ads->price_on_call = 0;
                }else{
                    $ads->price_on_call = 1;
                }

                $ads->description = $request->description;
                $ads->features = $request->features;

                if($request->hasFile('image')){

                    $image_tmp = $request->file('image');

                    if($ads->image == null){

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/ads/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/ads/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/ads/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/ads/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                        $ads->image = $image_name;


                    }else{
                        if (file_exists(public_path().'/assets/admin/uploads/ads/original/'.$ads->image)) {
                            unlink(public_path().'/assets/admin/uploads/ads/original/'.$ads->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/ads/large/'.$ads->image)) {
                            unlink(public_path().'/assets/admin/uploads/ads/large/'.$ads->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/ads/medium/'.$ads->image)) {
                            unlink(public_path().'/assets/admin/uploads/ads/medium/'.$ads->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/ads/small/'.$ads->image)) {
                            unlink(public_path().'/assets/admin/uploads/ads/small/'.$ads->image);
                        }

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/ads/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/ads/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/ads/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/ads/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                        $ads->image = $image_name;
                    }
                }

                $ads->date = $request->date;

                $ads->save();

                $ads_gallery = DB::table('ads_images')->where('ads_id', $ads->id)->get();

                if ($request->gallery_image != null)
                {
                    foreach ($request->gallery_image as $gi){

                        $images = $request->file($gi);

                        $extenson =$gi->getClientOriginalExtension();
                        $filename = rand(111,99999).'.'.$extenson;

                        $original_image_path = public_path().'/assets/admin/uploads/ads_gallery/original/'.$filename;
                        $large_image_path = public_path().'/assets/admin/uploads/ads_gallery/large/'.$filename;
                        $medium_image_path = public_path().'/assets/admin/uploads/ads_gallery/medium/'.$filename;
                        $small_image_path = public_path().'/assets/admin/uploads/ads_gallery/small/'.$filename;

                        //Resize Image
                        Image::make($gi)->save($original_image_path);
                        Image::make($gi)->resize(1110,680)->save($large_image_path);
                        Image::make($gi)->resize(520,329)->save($medium_image_path);
                        Image::make($gi)->resize(100,75)->save($small_image_path);

                        DB::table('ads_images')->where('ads_id', $id)->update([
                            'ads_id' => $ads->id,
                            'image' => $filename,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                    }
                }

                

                DB::commit();

                return response()->json([
                    'message' => 'Customer Ads updated successful',
                ],Response::HTTP_ACCEPTED);


            } catch (Exception $e) {
                //throw $e;

                DB::rollBack();

                $error = $e->getMessage();

                return response()->json([
                    'error' => $error
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }


    public function destroy($id)
    {
        $ads = Ads::findOrFail($id);

        $ads_gallery = DB::table('ads_images')->where('ads_id', $id)->get();

        
        foreach($ads_gallery as $ag)
        {
            if($ag->ads_id == $id)
            {
                $original_image_path = public_path().'/assets/admin/uploads/ads_gallery/original/'.$ag->image;
                $large_image_path = public_path().'/assets/admin/uploads/ads_gallery/large/'.$ag->image;
                $medium_image_path = public_path().'/assets/admin/uploads/ads_gallery/medium/'.$ag->image;
                $small_image_path = public_path().'/assets/admin/uploads/ads_gallery/small/'.$ag->image;

                unlink($original_image_path);
                unlink($large_image_path);
                unlink($medium_image_path);
                unlink($small_image_path);
            }
            
        }

        DB::table('ads_images')->where('ads_id', $id)->delete();
        

        if($ads->image != null)
        {
            $original_image_path = public_path().'/assets/admin/uploads/ads/original/'.$ads->image;
            $large_image_path = public_path().'/assets/admin/uploads/ads/large/'.$ads->image;
            $medium_image_path = public_path().'/assets/admin/uploads/ads/medium/'.$ads->image;
            $small_image_path = public_path().'/assets/admin/uploads/ads/small/'.$ads->image;

            unlink($original_image_path);
            unlink($large_image_path);
            unlink($medium_image_path);
            unlink($small_image_path);

            $ads->delete();
        }else{
            $ads->delete();
        }

        return response()->json([
            'message' => 'Ads deleted successful'
        ],Response::HTTP_OK);
    }

    public function getSubcategory(Request $request)
    {
        $catgeory_id = $request->category_id;

        $sub_cat = AdsSubCategory::where('category_id', $catgeory_id)->get();

        return response()->json([
            'sub_cat' => $sub_cat
        ],Response::HTTP_OK);
    }

    public function getDistrict(Request $request)
    {
        $division_id = $request->division_id;

        $query = DB::table('districts')
                ->select(
                    'districts.id as id',
                    'districts.division_id as division_id',
                    'districts.name as district_name'
                )
                ->join('divisions','districts.division_id','=','divisions.id')
                ->where('districts.division_id',$division_id)
                ->get();

        if(empty($query)){
            return response()->json([
                'message' => 'No Data Found'
            ],Response::HTTP_OK);

        }else{
            return response()->json([
                'distroct' => $query
            ],Response::HTTP_OK);
        }
    }


    public function popularAds()
    {
        $popular_ads = Ads::select('ads.*','divisions.name as division_name')
                        ->leftJoin('divisions', function($join){
                            $join->on('ads.division_id','=','divisions.id');
                        })
                        ->where('approve','=',1)
                        ->where('view_count', '>=', 120)
                        ->orderBy('ads.id','desc')
                        ->take(8)
                        ->get();
        
        return response()->json([
            'popular_ads' => $popular_ads
        ],Response::HTTP_OK);
    }

    public function allPopularAds()
    {
        $all_popular_ads = Ads::select('ads.*','divisions.name as division_name')
                        ->leftJoin('divisions', function($join){
                            $join->on('ads.division_id','=','divisions.id');
                        })
                        ->where('approve','=',1)
                        ->where('view_count', '>=', 120)
                        ->orderBy('ads.id','desc')
                        ->paginate(6);
        
        return response()->json([
            'all_popular_ads' => $all_popular_ads
        ],Response::HTTP_OK);
    }

    public function recentAds()
    {
        $recent_ads = Ads::select('ads.*','divisions.name as division_name')
                        ->leftJoin('divisions', function($join){
                            $join->on('ads.division_id','=','divisions.id');
                        })
                        ->where('approve','=',1)
                        ->orderBy('ads.id','desc')
                        ->take(8)
                        ->get();
        
        return response()->json([
            'recent_ads' => $recent_ads
        ],Response::HTTP_OK);
    }

    public function allRecentAds()
    {
        $all_recent_ads = Ads::select('ads.*','divisions.name as division_name')
                        ->leftJoin('divisions', function($join){
                            $join->on('ads.division_id','=','divisions.id');
                        })
                        ->where('approve','=',1)
                        ->orderBy('ads.id','desc')
                        ->paginate(6);
        
        return response()->json([
            'all_recent_ads' => $all_recent_ads
        ],Response::HTTP_OK);
    }

    public function adsDetails($id)
    {
        $ads_details = Ads::select('ads.*','divisions.name as division_name')
                        ->leftJoin('divisions', function($join){
                            $join->on('ads.division_id','=','divisions.id');
                        })
                        ->where('approve','=',1)
                        ->where('ads.id',$id)
                        ->orderBy('ads.id','desc')
                        ->first();

        $related_ads = Ads::select('ads.*','divisions.name as division_name','ads_categories.name as category_name')
                        ->leftJoin('divisions', function($join){
                            $join->on('ads.division_id','=','divisions.id');
                        })
                        ->leftJoin('ads_categories', function($join){
                            $join->on('ads.category_id','=','ads_categories.id');
                        })
                        ->where('ads.category_id',$ads_details->category_id)
                        ->take(4)
                        ->get();

        if($ads_details != null)
        {
            return response()->json([
                'ads_details' => $ads_details,
                'related_ads' => $related_ads
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'No Data Found'
            ],Response::HTTP_OK);
        }
    }

    public function adsSearch(Request $request)
    {
        $search = $request->search;
        $division_id = $request->division_id;
        $category_id = $request->category_id;

        $search_result = Ads::where('division_id', $division_id)
                    ->where('category_id', $category_id)
                    ->orWhere('name','like','%'.$search.'%')
                    ->orWhere('title','like','%'.$search.'%')
                    ->paginate(10);

        if(count($search_result) > 0)
        {
            return response()->json([
                'ads_search' => $search_result
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'No Data Found'
            ],Response::HTTP_OK);
        }
    }

   
}
