<?php

namespace App\Http\Controllers\api\v1;

use App\AdsBanner;
use App\AdsBannerCategory;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;

class ApiAdsBannerController extends Controller
{
    public function index()
    {
        $customer_id = auth('api')->id();

        $ads_banner = AdsBanner::where('customer_id', $customer_id)->paginate(10);

        if(empty($ads_banner))
        {
            return response()->json([
                'message' => 'No Data Found'
            ],Response::HTTP_OK);

        }else{
            return response()->json([
                'ads_banner' => $ads_banner
            ],Response::HTTP_OK);
        }
    }

    public function getCategory()
    {
        $banner_category = AdsBannerCategory::latest()->get();

        if(empty($banner_category))
        {
            return response()->json([
                'message' => 'No Data Found'
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'banner_category' => $banner_category
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

                $ads_banner = new AdsBanner();

                $ads_banner->customer_id = auth('api')->id();
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

            } catch (Exception $e) {
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
        $customer_id = auth('api')->id();

        $ads_banner = AdsBanner::where('id', $id)->where('customer_id', $customer_id)->first();

        if(empty($ads_banner))
        {
            return response()->json([
                'message' => 'No Data Found'
            ], Response::HTTP_OK);
        }else{
            return response()->json([
                'ads_banner' => $ads_banner
            ],Response::HTTP_OK);
        }

       
    }

    public function update(Request $request, $id)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try {
                //code...

                $ads_banner = AdsBanner::findOrFail($id);

                $ads_banner->customer_id = auth('api')->id();
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
        ],Response::HTTP_OK);
    }
}
