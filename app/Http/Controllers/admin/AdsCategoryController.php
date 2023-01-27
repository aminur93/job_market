<?php

namespace App\Http\Controllers\admin;

use App\AdsCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdsCategoryRequest;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Image;

class AdsCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ads_category-list|ads_category-create|ads_category-edit|ads_category-delete', ['only' => ['index','store']]);
        $this->middleware('permission:ads_category-create', ['only' => ['create','store']]);
        $this->middleware('permission:ads_category-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:ads_category-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('admin.ads_category.index');
    }

    public function getData()
    {
        $category = AdsCategory::latest()->get();

        return DataTables::of($category)
            ->addIndexColumn()
            ->addColumn('image',function ($category){
                $url=asset("assets/admin/uploads/category/medium/$category->image");
                return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />';
            })
            ->editColumn('action', function ($category) {
                $return = "<div class=\"btn-group\">";
                if (!empty($category->id))
                {
                    $return .= "
                            <a href=\"/category/edit/$category->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                            ||
                              <a rel=\"$category->id\" rel1=\"category/destroy\" href=\"javascript:\" style='margin-left: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
                                  ";
                }
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'image','action'
            ])
            ->make(true);
    }

    public function create()
    {
        return view('admin.ads_category.create');
    }

    public function store(AdsCategoryRequest $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $category = new AdsCategory();

                $category->name = $request->name;

                if($request->hasFile('image')){

                    $image_tmp = $request->file('image');

                    if($image_tmp->isValid()){

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/category/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/category/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/category/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/category/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);


                        $category->image = $image_name;
                    }
                }

                $category->save();

                DB::commit();

                return response()->json([
                    'message' => 'Category Stored Successfully',
                    'status_code' => 201
                ],Response::HTTP_CREATED);

            }catch(QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return response()->json([
                    'error' => $error,
                    'status_code' => 500
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function edit($id)
    {
        $category = AdsCategory::findOrFail($id);
        return view('admin.ads_category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        if($request->_method == 'PUT')
        {
            DB::beginTransaction();

            try{

                $category = AdsCategory::findOrFail($id);

                $category->name = $request->name;

                if($request->hasFile('image')){

                    $image_tmp = $request->file('image');

                    if($category->image == null){
                        // delete old images

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/category/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/category/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/category/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/category/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                        $category->image = $image_name;


                    }else{
                        if (file_exists(public_path().'/assets/admin/uploads/category/original/'.$category->image)) {
                            unlink(public_path().'/assets/admin/uploads/category/original/'.$category->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/category/large/'.$category->image)) {
                            unlink(public_path().'/assets/admin/uploads/category/large/'.$category->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/category/medium/'.$category->image)) {
                            unlink(public_path().'/assets/admin/uploads/category/medium/'.$category->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/category/small/'.$category->image)) {
                            unlink(public_path().'/assets/admin/uploads/category/small/'.$category->image);
                        }

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/category/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/category/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/category/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/category/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                        $category->image = $image_name;
                    }
                }

                $category->save();

                DB::commit();

                return response()->json([
                    'message' => 'Catgeory updated successfully',
                    'status_code' => 200
                ],Response::HTTP_OK);

            }catch(QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return response()->json([
                    'error' => $error,
                    'status_code' => 500
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function destroy($id)
    {
        $category = AdsCategory::findOrFail($id);

        if($category->image != null)
        {
            $original_image_path = public_path().'/assets/admin/uploads/category/original/'.$category->image;
            $large_image_path = public_path().'/assets/admin/uploads/category/large/'.$category->image;
            $medium_image_path = public_path().'/assets/admin/uploads/category/medium/'.$category->image;
            $small_image_path = public_path().'/assets/admin/uploads/category/small/'.$category->image;

            unlink($original_image_path);
            unlink($large_image_path);
            unlink($medium_image_path);
            unlink($small_image_path);

            $category->delete();
        }else{
            $category->delete();
        }

        return response()->json([
            'message' => 'Catgeory destory successful',
            'status_code' => 200
        ],Response::HTTP_OK);
    }
}
