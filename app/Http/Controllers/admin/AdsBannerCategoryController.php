<?php

namespace App\Http\Controllers\admin;

use App\AdsBannerCategory;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdsBannerCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ads_banner_category-list|ads_banner_category-create|ads_banner_category-edit|ads_banner_category-delete', ['only' => ['index','store']]);
        $this->middleware('permission:ads_banner_category-create', ['only' => ['create','store']]);
        $this->middleware('permission:ads_banner_category-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:ads_banner_category-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('admin.ads_banner_category.index');
    }

    public function getData()
    {
        $ads_banner_category = AdsBannerCategory::latest()->get();

        return DataTables::of($ads_banner_category)
        ->addIndexColumn()
            
        ->editColumn('action', function ($ads_banner_category) {
            $return = "<div class=\"btn-group\">";
            if (!empty($ads_banner_category->id))
            {
                $return .= "
                        <a href=\"/ads_banner_category/edit/$ads_banner_category->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                        ||
                        <a rel=\"$ads_banner_category->id\" rel1=\"ads_banner_category/destroy\" href=\"javascript:\" style='margin-left: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
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
        return view('admin.ads_banner_category.create');
    }

    public function store(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $ads_banner_category = new AdsBannerCategory();
                $ads_banner_category->name = $request->name;
                $ads_banner_category->slug = Str::snake($request->name, '_');

                $ads_banner_category->save();

                DB::commit();

                return response()->json([
                    'message' => 'Ads banner category store successful'
                ],Response::HTTP_CREATED);

            }catch(QueryException $e){
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
        $ads_banner_category = AdsBannerCategory::findOrFail($id);
        return view('admin.ads_banner_category.edit', compact('ads_banner_category'));
    }

    public function update(Request $request, $id)
    {
        if($request->_method == 'PUT')
        {
            DB::beginTransaction();

            try{

                $ads_banner_category = AdsBannerCategory::findOrFail($id);
                $ads_banner_category->name = $request->name;
                $ads_banner_category->slug = Str::snake($request->name, '_');

                $ads_banner_category->save();

                DB::commit();

                return response()->json([
                    'message' => 'Ads banner category updated successful'
                ],Response::HTTP_CREATED);

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
        $ads_banner_category = AdsBannerCategory::findOrFail($id);
        $ads_banner_category->delete();

        return response()->json([
            'message' => 'Ads banner category deleted successful'
        ],Response::HTTP_OK);
    }
}
