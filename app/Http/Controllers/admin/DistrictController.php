<?php

namespace App\Http\Controllers\admin;

use App\District;
use App\Division;
use App\Http\Controllers\Controller;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Image;

class DistrictController extends Controller
{
    public function index()
    {
        return view('admin.district.index');
    }

    public function getData()
    {
        $district = District::select('districts.id as id', 'districts.name as name', 'divisions.name as division_name')
                    ->leftJoin('divisions', function($join){
                        $join->on('districts.division_id', '=', 'divisions.id'); 
                    })
                    ->get();

        return DataTables::of($district)
            ->addIndexColumn()
                
            ->editColumn('action', function ($district) {
                $return = "<div class=\"btn-group\">";
                if (!empty($district->name))
                {
                    $return .= "
                            <a href=\"/district/edit/$district->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                            ||
                            <a rel=\"$district->id\" rel1=\"district/destroy\" href=\"javascript:\" style='margin-left: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
                                ";
                }
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'action'
            ])
            ->make(true);
    }

    public function create()
    {
        $divisions = Division::latest()->get();

        return view('admin.district.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $district = new District();

                $district->division_id = $request->division_id;
                $district->name = $request->name;
                $district->slug = Str::snake($request->name, '_');

                if($request->hasFile('image')){

                    $image_tmp = $request->file('image');

                    if($image_tmp->isValid()){

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/district/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/district/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/district/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/district/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);


                        $district->image = $image_name;
                    }
                }

                $district->save();

                DB::commit();

                return response()->json([
                    'message' => 'District store successful',
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
        $divisions = Division::latest()->get();

        $district = District::findOrFail($id);

        return view('admin.district.edit', compact('divisions','district'));
    }

    public function update(Request $request, $id)
    {
        if($request->_method == 'PUT')
        {
            DB::beginTransaction();

            try{

                $district = District::findOrFail($id);

                $district->division_id = $request->division_id;
                $district->name = $request->name;
                $district->slug = Str::snake($request->name, '_');

                if($request->hasFile('image')){

                    $image_tmp = $request->file('image');

                    if($district->image == null){
                        // delete old images

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/district/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/district/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/district/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/district/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                        $district->image = $image_name;


                    }else{
                        if (file_exists(public_path().'/assets/admin/uploads/district/original/'.$district->image)) {
                            unlink(public_path().'/assets/admin/uploads/district/original/'.$district->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/district/large/'.$district->image)) {
                            unlink(public_path().'/assets/admin/uploads/district/large/'.$district->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/district/medium/'.$district->image)) {
                            unlink(public_path().'/assets/admin/uploads/district/medium/'.$district->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/district/small/'.$district->image)) {
                            unlink(public_path().'/assets/admin/uploads/district/small/'.$district->image);
                        }

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/district/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/district/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/district/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/district/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                        $district->image = $image_name;
                    }
                }

                $district->save();

                DB::commit();

                return response()->json([
                    'message' => 'District updated successful'
                ],Response::HTTP_OK);

            }catch(QueryException $e){
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
        $district = District::findOrFail($id);

        if($district->image != null)
        {
            $original_image_path = public_path().'/assets/admin/uploads/district/original/'.$district->image;
            $large_image_path = public_path().'/assets/admin/uploads/district/large/'.$district->image;
            $medium_image_path = public_path().'/assets/admin/uploads/district/medium/'.$district->image;
            $small_image_path = public_path().'/assets/admin/uploads/district/small/'.$district->image;

            unlink($original_image_path);
            unlink($large_image_path);
            unlink($medium_image_path);
            unlink($small_image_path);

            $district->delete();
        }else{
            $district->delete();
        }
       

        return response()->json([
            'message' => 'District destory successful'
        ],Response::HTTP_OK);
    }
}
