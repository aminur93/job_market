<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\JobCategory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Image;

class JobCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:job_bank_category-list|job_bank_category-create|job_bank_category-edit|job_bank_category-delete', ['only' => ['index','store']]);
        $this->middleware('permission:job_bank_category-create', ['only' => ['create','store']]);
        $this->middleware('permission:job_bank_category-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:job_bank_category-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('admin.job_category.index');
    }

    public function getData()
    {
        $job_category = JobCategory::latest()->get();

        return DataTables::of($job_category)
        ->addIndexColumn()
            ->addColumn('image',function ($job_category){
                $url=asset("assets/admin/uploads/job_category/medium/$job_category->image");
                return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />';
            })
            ->editColumn('action', function ($job_category) {
                $return = "<div class=\"btn-group\">";
                if (!empty($job_category->name))
                {
                    $return .= "
                            <a href=\"/job_category/edit/$job_category->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                            ||
                              <a rel=\"$job_category->id\" rel1=\"job_category/destroy\" href=\"javascript:\" style='margin-left: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
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
        return view('admin.job_category.create');
    }

    public function store(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try {
                //code...

                $job_category = new JobCategory();

                $job_category->name = $request->name;
                $job_category->slug = Str::snake($request->name, '_');

                if($request->hasFile('image')){

                    $image_tmp = $request->file('image');

                    if($image_tmp->isValid()){

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/job_category/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/job_category/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/job_category/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/job_category/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);


                        $job_category->image = $image_name;
                    }
                }

                $job_category->save();

                DB::commit();

                return response()->json([
                    'message' => 'Job category store successful'
                ],Response::HTTP_CREATED);
            } catch (QueryException $e) {
                //throw $e;

                DB::rollBack();

                $error = $e->getMessage();

                return response()->json([
                    'error' => $error
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function edit($id)
    {
        $job_category = JobCategory::findOrFail($id);
        return view('admin.job_category.edit', compact('job_category'));
    }

    public function update(Request $request, $id)
    {
        if($request->_method == 'PUT')
        {
            DB::beginTransaction();

            try{

                $job_category = JobCategory::findOrFail($id);

                $job_category->name = $request->name;
                $job_category->slug = Str::snake($request->name, '_');

                if($request->hasFile('image')){

                    $image_tmp = $request->file('image');

                    if($job_category->image == null){
                        // delete old images

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/job_category/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/job_category/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/job_category/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/job_category/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                        $job_category->image = $image_name;


                    }else{
                        if (file_exists(public_path().'/assets/admin/uploads/job_category/original/'.$job_category->image)) {
                            unlink(public_path().'/assets/admin/uploads/job_category/original/'.$job_category->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/job_category/large/'.$job_category->image)) {
                            unlink(public_path().'/assets/admin/uploads/job_category/large/'.$job_category->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/job_category/medium/'.$job_category->image)) {
                            unlink(public_path().'/assets/admin/uploads/job_category/medium/'.$job_category->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/job_category/small/'.$job_category->image)) {
                            unlink(public_path().'/assets/admin/uploads/job_category/small/'.$job_category->image);
                        }

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/job_category/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/job_category/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/job_category/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/job_category/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                        $job_category->image = $image_name;
                    }
                }

                $job_category->save();

                DB::commit();

                return response()->json([
                    'message' => 'Job category updated successful'
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

    public function destroy($id)
    {
        $job_category = JobCategory::findOrFail($id);

        if($job_category->image != null)
        {
            $original_image_path = public_path().'/assets/admin/uploads/job_category/original/'.$job_category->image;
            $large_image_path = public_path().'/assets/admin/uploads/job_category/large/'.$job_category->image;
            $medium_image_path = public_path().'/assets/admin/uploads/job_category/medium/'.$job_category->image;
            $small_image_path = public_path().'/assets/admin/uploads/job_category/small/'.$job_category->image;

            unlink($original_image_path);
            unlink($large_image_path);
            unlink($medium_image_path);
            unlink($small_image_path);

            $job_category->delete();
        }else{
            $job_category->delete();
        }

        return response()->json([
            'message' => 'Job category destroy successful'
        ],Response::HTTP_OK);
    }
}
