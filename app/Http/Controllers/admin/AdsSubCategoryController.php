<?php

namespace App\Http\Controllers\admin;

use App\AdsCategory;
use App\AdsSubCategory;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Prophecy\Call\Call;
use Yajra\DataTables\Facades\DataTables;

class AdsSubCategoryController extends Controller
{
    public function index()
    {
        return view('admin.ads_sub_category.index');
    }

    public function getData()
    {
        $sub_category = AdsSubCategory::select('ads_sub_categories.*','ads_categories.name as category_name')
                        ->leftJoin('ads_categories', function($join){
                            $join->on('ads_sub_categories.category_id','=','ads_categories.id');
                        })
                        ->latest()
                        ->get();

        return DataTables::of($sub_category)
        ->addIndexColumn()
            
            ->editColumn('action', function ($sub_category) {
                $return = "<div class=\"btn-group\">";
                if (!empty($sub_category->name))
                {
                    $return .= "
                            <a href=\"/sub_category/edit/$sub_category->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                            ||
                            <a rel=\"$sub_category->id\" rel1=\"sub_category/destroy\" href=\"javascript:\" style='margin-left: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
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
        $category = AdsCategory::latest()->get();

        return view('admin.ads_sub_category.create', compact('category'));
    }

    public function store(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $sub_category = new AdsSubCategory();

                $sub_category->category_id = $request->category_id;
                $sub_category->name = $request->name;

                $sub_category->save();

                DB::commit();

                return response()->json([
                    'message' => 'Sub Category store successful'
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

    public function edit($id)
    {
        $category = AdsCategory::latest()->get();
        $sub_category = AdsSubCategory::findOrFail($id);
        return view('admin.ads_sub_category.edit', compact('category','sub_category'));
    }

    public function update(Request $request , $id)
    {
        if($request->_method == 'PUT')
        {
            DB::beginTransaction();

            try{

                $sub_category = AdsSubCategory::findOrFail($id);

                $sub_category->category_id = $request->category_id;
                $sub_category->name = $request->name;

                $sub_category->save();

                DB::commit();

                return response()->json([
                    'message' => 'Sub category updated successful'
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
        $sub_category = AdsSubCategory::findOrFail($id);
        $sub_category->delete();

        return response()->json([
            'message' => 'Sub category destroy successful'
        ],Response::HTTP_OK);
    }
}
