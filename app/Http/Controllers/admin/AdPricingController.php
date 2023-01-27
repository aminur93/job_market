<?php

namespace App\Http\Controllers\admin;

use App\AdPricing;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AdPricingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ads_pricing-list|ads_pricing-create|ads_pricing-edit|ads_pricing-delete', ['only' => ['index','store']]);
        $this->middleware('permission:ads_pricing-create', ['only' => ['create','store']]);
        $this->middleware('permission:ads_pricing-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:ads_pricing-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('admin.ads_pricing.index');
    }

    public function getData()
    {
        $ads_price = AdPricing::latest()->get();

        return DataTables::of($ads_price)
        ->addIndexColumn()
        ->addColumn('status',function ($ads_price){
            if($ads_price->status == 0)
            {

                return '<div>
                        <label class="switch patch">
                            <input type="checkbox" class="status_toggle" data-value="'.$ads_price->id.'" id="status_change" value="'.$ads_price->id.'">
                            <span class="slider"></span>
                        </label>
                      </div>';
            }else{
                return '<div>
                    <label class="switch patch">
                        <input type="checkbox" id="status_change"  class="status_toggle" data-value="'.$ads_price->id.'"  value="'.$ads_price->id.'" checked>
                        <span class="slider"></span>
                    </label>
                  </div>';
            }

        })
        ->editColumn('action', function ($ads_price) {
            $return = "<div class=\"btn-group\">";
            if (!empty($ads_price->id))
            {
                $return .= "
                        <a href=\"/ads_price/edit/$ads_price->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                        ||
                        <a rel=\"$ads_price->id\" rel1=\"ads_price/destroy\" href=\"javascript:\" style='margin-left: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
                            ";
            }
            $return .= "</div>";
            return $return;
        })
        ->rawColumns([
            'action','status'
        ])
        ->make(true);
    }

    public function create()
    {
        return view('admin.ads_pricing.create');
    }

    public function store(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $ads_price = new AdPricing();

                $ads_price->start_price = $request->start_price;
                $ads_price->end_price = $request->end_price;
                $ads_price->single_month = $request->single_month;
                $ads_price->title = $request->title;
                $ads_price->description = $request->description;
                $ads_price->ads_total = $request->ads_total;

                $ads_price->save();

                DB::commit();

                return response()->json([
                    'message' => 'Ads price store successful'
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
        $ads_price = AdPricing::findOrFail($id);

        return view('admin.ads_pricing.edit', compact('ads_price'));
    }

    public function update(Request $request, $id)
    {
        if($request->_method == 'PUT')
        {
            DB::beginTransaction();

            try{

                $ads_price = AdPricing::findOrFail($id);

                $ads_price->start_price = $request->start_price;
                $ads_price->end_price = $request->end_price;
                $ads_price->single_month = $request->single_month;
                $ads_price->title = $request->title;
                $ads_price->description = $request->description;
                $ads_price->ads_total = $request->ads_total;

                $ads_price->save();

                DB::commit();

                return response()->json([
                    'message' => 'Ads updated successful'
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
        $ads_price = AdPricing::findOrFail($id);
        $ads_price->delete();

        return response()->json([
            'message' => 'Ads price deleted successful'
        ],Response::HTTP_OK);
    }

    public function statusChange($id)
    {
        $ads_price = AdPricing::findOrFail($id);

        if ($ads_price->status == 0)
        {
            $ads_price->update(['status' => 1]);

            return response()->json([
                'message' => 'Ads Pricing is active',
                'status_code' => 200
            ], 200);
        }else{
            $ads_price->update(['status' => 0]);

            return response()->json([
                'message' => 'Ads Pricing is inactive',
                'status_code' => 200
            ], 200);
        }
    }
}
