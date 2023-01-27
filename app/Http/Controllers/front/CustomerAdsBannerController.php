<?php

namespace App\Http\Controllers\front;

use App\Ads;
use App\AdsBanner;
use App\AdsBannerCategory;
use App\AdsCategory;
use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;
use Yajra\DataTables\Facades\DataTables;

class CustomerAdsBannerController extends Controller
{
    public function index()
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $id = Auth::guard('customer')->id();

        $customer =  Customer::findOrFail($id);

        

        return view('customer.banner.index', compact('all_category','ads_count','customer'));
    }

    public function getData()
    {
        $ads_banner = AdsBanner::select('ads_banners.*', 'ads_banner_categories.name as ads_banner_category_name','customers.name as customer_name','customers.id as customer_id')
                        ->leftJoin('ads_banner_categories', function($join){
                            $join->on('ads_banners.ads_banner_category_id', '=', 'ads_banner_categories.id');
                        
                        })
                        ->leftJoin('customers', function($join){
                            $join->on('ads_banners.customer_id', '=', 'customers.id');
                        })
                        ->where('customers.id','=',Auth::guard('customer')->id())
                        ->get();

        return DataTables::of($ads_banner)
                ->addIndexColumn()
                ->addColumn('image',function ($ads_banner){
                    $url=asset("assets/admin/uploads/banner/medium/$ads_banner->image");
                    return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center"/>';
                })
                ->editColumn('action', function ($ads_banner) {
                    $return = "<div class=\"btn-group\">";
                    if (!empty($ads_banner->id))
                    {
                        $return .= "
                                <a href=\"/customer_ads_banner/edit/$ads_banner->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                                ||
                                <a rel=\"$ads_banner->id\" rel1=\"customer_ads_banner/destroy\" href=\"javascript:\" style='margin-left: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
                                ";
                    }
                    $return .= "</div>";
                    return $return;
                })
                ->rawColumns([
                    'action','image'
                ])
                ->make(true);
    }

    public function create()
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $id = Auth::guard('customer')->id();

        $customer =  Customer::findOrFail($id);

        $ads_banner_category = AdsBannerCategory::latest()->get();

        return view('customer.banner.create', compact('all_category','ads_count','customer','ads_banner_category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'max:5120'
        ]);

        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try {
                //code...

                $ads_banner = new AdsBanner();

                $ads_banner->customer_id = Auth::guard('customer')->id();
                $ads_banner->ads_banner_category_id = $request->ads_banner_category_id;
                $ads_banner->company_name = $request->company_name;
                $ads_banner->title = $request->title;
                $ads_banner->description = $request->description;

                if($request->hasFile('image')){

                    $image_tmp = $request->file('image');

                    if($image_tmp->isValid()){

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/banner/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/banner/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/banner/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/banner/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);


                        $ads_banner->image = $image_name;
                    }
                }

                $ads_banner->save();

                DB::commit();

                return response()->json([
                    'message' => 'Ads banner store successful'
                ], Response::HTTP_CREATED);

            } catch (QueryException $e) {
                //throw $th;
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
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $customer_id = Auth::guard('customer')->id();

        $customer =  Customer::findOrFail($customer_id);

        $ads_banner_category = AdsBannerCategory::latest()->get();

        $ads_banner = AdsBanner::findOrFail($id);

        return view('customer.banner.edit', compact('all_category','ads_count','customer','ads_banner_category','ads_banner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'max:5120'
        ]);
        
        if($request->_method == 'PUT')
        {
            DB::beginTransaction();

            try {
                //code...

                $ads_banner = AdsBanner::findOrFail($id);

                $ads_banner->customer_id = Auth::guard('customer')->id();
                $ads_banner->ads_banner_category_id = $request->ads_banner_category_id;
                $ads_banner->company_name = $request->company_name;
                $ads_banner->title = $request->title;
                $ads_banner->description = $request->description;

                if($request->hasFile('image')){

                    $image_tmp = $request->file('image');

                    if($ads_banner->image == null){
                        // delete old images

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/banner/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/banner/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/banner/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/banner/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                        $ads_banner->image = $image_name;


                    }else{
                        if (file_exists(public_path().'/assets/admin/uploads/banner/original/'.$ads_banner->image)) {
                            unlink(public_path().'/assets/admin/uploads/banner/original/'.$ads_banner->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/banner/large/'.$ads_banner->image)) {
                            unlink(public_path().'/assets/admin/uploads/banner/large/'.$ads_banner->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/banner/medium/'.$ads_banner->image)) {
                            unlink(public_path().'/assets/admin/uploads/banner/medium/'.$ads_banner->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/banner/small/'.$ads_banner->image)) {
                            unlink(public_path().'/assets/admin/uploads/banner/small/'.$ads_banner->image);
                        }

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/banner/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/banner/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/banner/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/banner/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                        $ads_banner->image = $image_name;
                    }
                }

                $ads_banner->save();

                DB::commit();

                return response()->json([
                    'message' => 'Ads banner updated successful'
                ],Response::HTTP_OK);

            } catch (QueryException $e) {
                //throw $e;

                DB::rollback();

                $error = $e->getMessage();

                return response()->json([
                    'error' => $error
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function destroy($id)
    {
        $ads_banner = AdsBanner::findOrFail($id);

        if($ads_banner->image != null)
        {
            $original_image_path = public_path().'/assets/admin/uploads/banner/original/'.$ads_banner->image;
            $large_image_path = public_path().'/assets/admin/uploads/banner/large/'.$ads_banner->image;
            $medium_image_path = public_path().'/assets/admin/uploads/banner/medium/'.$ads_banner->image;
            $small_image_path = public_path().'/assets/admin/uploads/banner/small/'.$ads_banner->image;

            unlink($original_image_path);
            unlink($large_image_path);
            unlink($medium_image_path);
            unlink($small_image_path);

            $ads_banner->delete();
        }else{
            $ads_banner->delete();
        }

        return response()->json([
            'message' => 'Ads banner destory successful',
            'status_code' => 200
        ],Response::HTTP_OK);
    }
}
