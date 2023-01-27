<?php

namespace App\Http\Controllers\admin;

use App\Division;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Image;

class DivisionController extends Controller
{
    public function index()
    {
        return view('admin.division.index');
    }

    public function getData()
    {
        $division = Division::latest()->get();

        return DataTables::of($division)
            ->addIndexColumn()
            ->addColumn('image',function ($division){
                $url=asset("assets/admin/uploads/division/medium/$division->image");
                return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />';
            })
            ->editColumn('action', function ($division) {
                $return = "<div class=\"btn-group\">";
                if (!empty($division->name))
                {
                    $return .= "
                            <a href=\"/division/edit/$division->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                            ||
                            <a rel=\"$division->id\" rel1=\"division/destroy\" href=\"javascript:\" style='margin-left: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
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
        return view('admin.division.create');
    }

    public function store(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $division = new Division();

                $division->name = $request->name;
                $division->slug = Str::snake($request->name, '_');

                if($request->hasFile('image')){

                    $image_tmp = $request->file('image');

                    if($image_tmp->isValid()){

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/division/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/division/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/division/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/division/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);


                        $division->image = $image_name;
                    }
                }

                $division->save();

                DB::commit();

                return response()->json([
                    'message' => 'Division store successful',
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
        $division = Division::findOrFail($id);

        return view('admin.division.edit', compact('division'));
    }

    public function update(Request $request, $id)
    {
        if($request->_method == 'PUT')
        {
            DB::beginTransaction();

            try{

                $division = Division::findOrFail($id);

                $division->name = $request->name;
                $division->slug = Str::snake($request->name, '_');

                if($request->hasFile('image')){

                    $image_tmp = $request->file('image');

                    if($division->image == null){
                        // delete old images

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/division/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/division/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/division/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/division/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                        $division->image = $image_name;


                    }else{
                        if (file_exists(public_path().'/assets/admin/uploads/division/original/'.$division->image)) {
                            unlink(public_path().'/assets/admin/uploads/division/original/'.$division->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/division/large/'.$division->image)) {
                            unlink(public_path().'/assets/admin/uploads/division/large/'.$division->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/division/medium/'.$division->image)) {
                            unlink(public_path().'/assets/admin/uploads/division/medium/'.$division->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/division/small/'.$division->image)) {
                            unlink(public_path().'/assets/admin/uploads/division/small/'.$division->image);
                        }

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/division/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/division/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/division/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/division/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                        $division->image = $image_name;
                    }
                }

                $division->save();

                DB::commit();

                return response()->json([
                    'message' => 'Division updated successful',
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
        $division = Division::findOrFail($id);
        $division->delete();

        return response()->json([
            'message' => 'Division destroy successful',
            'status_code' => 200
        ],Response::HTTP_OK);
    }
}
