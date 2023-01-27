<?php

namespace App\Http\Controllers\admin;

use App\Ads;
use App\AdsCategory;
use App\AdsSubCategory;
use App\Division;
use App\District;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;
use Yajra\DataTables\Facades\DataTables;

class AdsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ads-list|ads-create|ads-edit|ads-delete', ['only' => ['index','store']]);
        $this->middleware('permission:ads-create', ['only' => ['create','store']]);
        $this->middleware('permission:ads-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:ads-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('admin.ads.index');
    }

    public function getData()
    {
        $admin =  User::role('admin')->first();

        if($admin->id == Auth::id())
        {
            $ads = Ads::select('ads.*','users.name as user_name','ads_categories.name as category_name')
                ->leftJoin('users', function($join){
                    $join->on('ads.user_id','=','users.id');
                })
                ->leftJoin('ads_categories', function($join){
                    $join->on('ads.category_id','=','ads_categories.id');
                })
                ->orderBy('ads.id','desc')
                ->get();

        return DataTables::of($ads)
        ->addIndexColumn()
        ->addColumn('image',function ($ads){
            $url=asset("assets/admin/uploads/ads/medium/$ads->image");
            return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />';
        })
        ->addColumn('approve',function ($ads){
            if($ads->approve == 0)
            {

                return '<div>
                        <label class="switch patch">
                            <input type="checkbox" class="approve_toggle" data-value="'.$ads->id.'" id="approve_change" value="'.$ads->id.'">
                            <span class="slider"></span>
                        </label>
                      </div>';
            }else{
                return '<div>
                    <label class="switch patch">
                        <input type="checkbox" id="approve_change"  class="approve_toggle" data-value="'.$ads->id.'"  value="'.$ads->id.'" checked>
                        <span class="slider"></span>
                    </label>
                  </div>';
            }

        })
        ->editColumn('action', function ($ads) {
            $return = "<div class=\"btn-group\">";
            if (!empty($ads->id))
            {
                $return .= "
                        <a href=\"/ads/edit/$ads->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                        ||
                        <a href=\"/ads/details/$ads->id\" style='margin-left: 5px;margin-right:5px' class=\"btn btn-sm btn-info\"><i class='fa fa-eye'></i></a>
                        ||
                        <a rel=\"$ads->id\" rel1=\"ads/destroy\" href=\"javascript:\" style='margin-left: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
                              ";
            }
            $return .= "</div>";
            return $return;
        })
        ->rawColumns([
            'image','action','approve'
        ])
        ->make(true);
        }else{

            $ads = Ads::select('ads.*','users.name as user_name','ads_categories.name as category_name','users.id as user_id')
                ->leftJoin('users', function($join){
                    $join->on('ads.user_id','=','users.id');
                })
                ->leftJoin('ads_categories', function($join){
                    $join->on('ads.category_id','=','ads_categories.id');
                })
                ->leftJoin('model_has_roles', function($join){
                    $join->on('users.id','=','model_has_roles.model_id');
                })
                ->leftJoin('roles', function($join){
                    $join->on('model_has_roles.role_id','=','roles.id');
                })
                ->where('users.id','=',Auth::id())
                ->orderBy('ads.id','desc')
                ->get();

        return DataTables::of($ads)
        ->addIndexColumn()
        ->addColumn('image',function ($ads){
            $url=asset("assets/admin/uploads/ads/medium/$ads->image");
            return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />';
        })
        ->addColumn('approve',function ($ads){
            if($ads->approve == 0)
            {

                return '<div>
                        <label class="switch patch">
                            <input type="checkbox" class="approve_toggle" data-value="'.$ads->id.'" id="approve_change" value="'.$ads->id.'">
                            <span class="slider"></span>
                        </label>
                      </div>';
            }else{
                return '<div>
                    <label class="switch patch">
                        <input type="checkbox" id="approve_change"  class="approve_toggle" data-value="'.$ads->id.'"  value="'.$ads->id.'" checked>
                        <span class="slider"></span>
                    </label>
                  </div>';
            }

        })
        ->editColumn('action', function ($ads) {
            $return = "<div class=\"btn-group\">";
            if (!empty($ads->id))
            {
                $return .= "
                        <a href=\"/ads/edit/$ads->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                        ||
                        <a href=\"/ads/details/$ads->id\" style='margin-left: 5px;margin-right:5px' class=\"btn btn-sm btn-info\"><i class='fa fa-eye'></i></a>
                        ||
                        <a rel=\"$ads->id\" rel1=\"ads/destroy\" href=\"javascript:\" style='margin-left: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
                              ";
            }
            $return .= "</div>";
            return $return;
        })
        ->rawColumns([
            'image','action','approve'
        ])
        ->make(true);
        }

       
    }

    public function create()
    {
        $ads_category = AdsCategory::latest()->get();

        $division = Division::latest()->get();

        return view('admin.ads.create', compact('ads_category','division'));
    }

    public function store(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try {
                //code...

                $ads = new Ads();

                $ads->user_id = Auth::id();
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
                $ads->features = $request->features;

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
                    'message' => 'Ads store successful'
                ],Response::HTTP_CREATED);


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

    public function edit($id)
    {
        $ads_category = AdsCategory::latest()->get();

        $ads = Ads::findOrFail($id);

        $category = AdsCategory::where('id', $ads->category_id)->first();

        $ads_gallery = DB::table('ads_images')->where('ads_id', $id)->get();

        $division = Division::latest()->get();

        $district = District::latest()->get();

        return view('admin.ads.edit', compact('ads_category','ads','ads_gallery','division','district','category'));
    }

    public function update(Request $request, $id)
    {
        if($request->_method == 'PUT')
        {
            DB::beginTransaction();

            try {
                //code...

                $ads = Ads::findOrFail($id);

                $ads->user_id = Auth::id();
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


                if ($request->gallery_image)
                {
                    $ads_gallery = DB::table('ads_images')->where('ads_id', $ads->id)->get();
                    foreach ($ads_gallery as $pig){
                        if (file_exists(public_path().'/assets/admin/uploads/ads_gallery/original/'.$pig->image)) {
                            unlink(public_path().'/assets/admin/uploads/ads_gallery/original/'.$pig->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/ads_gallery/large/'.$pig->image)) {
                            unlink(public_path().'/assets/admin/uploads/ads_gallery/large/'.$pig->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/ads_gallery/medium/'.$pig->image)) {
                            unlink(public_path().'/assets/admin/uploads/ads_gallery/medium/'.$pig->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/ads_gallery/small/'.$pig->image)) {
                            unlink(public_path().'/assets/admin/uploads/ads_gallery/small/'.$pig->image);
                        }
                    }

                    DB::table('ads_images')->where('ads_id', $id)->delete();

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
                            'ads_id' => $ads->id,
                            'image' => $filename,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                    }
                }else{

                    $current_image = $request->input('current_image');
                    $current_image_id = $request->input('current_image_id');

                    $g_current_image = array_map(null,  $current_image_id,  $current_image);

                    foreach ($g_current_image as $gi){

                        DB::table('ads_images')->where('id', $gi[0])->update([
                            'ads_id' => $ads->id,
                            'image' => $gi[1],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                    }

                }

                DB::commit();

                return response()->json([
                    'message' => 'Ads updated successful'
                ],Response::HTTP_ACCEPTED);


            } catch (QueryException $e) {

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

    public function approve($id)
    {
        $ads = Ads::findOrFail($id);

        if($ads->approve == 0)
        {
            $ads->update(['approve' => 1]);

            return response()->json([
                'message' => 'Ads is approve'
            ],Response::HTTP_OK);
        }else{
            $ads->update(['approve' => 0]);

            return response()->json([
                'message' => 'Ads approve cancel'
            ],Response::HTTP_OK);
        }
    }

    public function details($id)
    {
        $ads = Ads::findOrFail($id);

        return view('admin.ads.details', compact('ads'));
    }

    public function getDistrict()
    {
        if (isset($_POST['division_id']))
        {
            $division_id = $_POST['division_id'];
        
            $query = DB::table('districts')
                ->select(
                    'districts.id as id',
                    'districts.division_id as division_id',
                    'districts.name as district_name'
                )
                ->join('divisions','districts.division_id','=','divisions.id')
                ->where('districts.division_id',$division_id)
                ->get();

           
        
            return response()->json([
                'district' => $query
            ],Response::HTTP_OK);
        }
    }

    public function getCategoryValue()
    {
        $catgeory_id = $_GET['category'];

        $catgeory = AdsCategory::where('id', $catgeory_id)->first();

        $sub_cat = AdsSubCategory::where('category_id', $catgeory_id)->get();

        return response()->json([
            'category' => $catgeory,
            'sub_cat' => $sub_cat
        ],Response::HTTP_OK);
    }
}
