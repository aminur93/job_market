<?php

namespace App\Http\Controllers\front;

use App\Ads;
use App\AdsCategory;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Tvs;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CustomerTvcController extends Controller
{
    public function index()
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $id =  Auth::guard('customer')->id();

        $customer =  Customer::findOrFail($id);

        return view('customer.tvc.index', compact('all_category','ads_count','customer'));
    }

    public function getData()
    {
        
            $tvc =  Tvs::select('tvs.*', 'customers.name as customer_name')
            ->leftJoin('customers', function($join){
                $join->on('tvs.customer_id','=','customers.id');
            })
            ->where('tvs.customer_id', Auth::guard('customer')->id())
            ->get();

            return DataTables::of($tvc)
                ->addIndexColumn()
                ->addColumn('video',function ($tvc){
                    $url=asset("assets/admin/uploads/tvc/$tvc->video");
                    return '
                            <video width="220" height="140" controls>
                                <source src='.$url.' type="video/mp4">
                            </video>
                    ';
                })
                
                ->editColumn('action', function ($tvc) {
                    $return = "<div class=\"btn-group\">";
                    if (!empty($tvc->id))
                    {
                        $return .= "
                                <a href=\"/customer_tvc/edit/$tvc->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                                ||
                                <a rel=\"$tvc->id\" rel1=\"customer_tvc/destroy\" href=\"javascript:\" style='margin-left: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
                                    ";
                    }
                    $return .= "</div>";
                    return $return;
                })
                ->rawColumns([
                    'action','video'
                ])
                ->make(true);
    }

    public function create()
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $id =  Auth::guard('customer')->id();

        $customer =  Customer::findOrFail($id);

        return view('customer.tvc.create', compact('all_category','ads_count','customer'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'video' => 'max:10240'
        ]);

        if ($request->isMethod('post')) {
            
            DB::beginTransaction();

            try {
                //code...

                $tvc = new Tvs();

                $tvc->customer_id = Auth::guard('customer')->id();
                $tvc->company_name = $request->company_name;
                $tvc->tvc_title = $request->title;
                $tvc->description = $request->description;

                $videoName = time().'.'.$request->video->getClientOriginalExtension();
                $request->video->move(public_path().'/assets/admin/uploads/tvc/', $videoName);

                $tvc->video = $videoName;
                $tvc->date = $request->date;

                $tvc->save();

                DB::commit();

                return response()->json([
                    'message' => 'Tvc store successful'
                ], Response::HTTP_CREATED);

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
        $tvc = Tvs::findOrFail($id);

        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $id =  Auth::guard('customer')->id();

        $customer =  Customer::findOrFail($id);

        return view('customer.tvc.edit', compact('tvc','all_category','ads_count','customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'video' => 'max:10240'
        ]);

        
        if ($request->_method == 'PUT') {
            
            DB::beginTransaction();

            try{

                $tvc = Tvs::findOrFail($id);

                $tvc->customer_id = Auth::guard('customer')->id();
                $tvc->company_name = $request->company_name;
                $tvc->tvc_title = $request->title;
                $tvc->description = $request->description;

                if($request->hasFile('video'))
                {
                    $video_tmp = $request->file('video');

                    if($tvc->video == null)
                    {
                        $video_name = time().'.'.$video_tmp->getClientOriginalExtension();

                        $video_tmp->move(public_path().'/assets/admin/uploads/tvc/', $video_name);

                        $tvc->video = $video_name;
                    }else{
                        if (file_exists(public_path().'/assets/admin/uploads/tvc/'.$tvc->video)) {
                            unlink(public_path().'/assets/admin/uploads/tvc/'.$tvc->video);
                        }

                        $video_name = time().'.'.$video_tmp->getClientOriginalExtension();

                        $video_tmp->move(public_path().'/assets/admin/uploads/tvc/', $video_name);

                        $tvc->video = $video_name;
                    }
                }

                $tvc->date = $request->date;

                $tvc->save();

                DB::commit();

                return response()->json([
                    'message' => 'Tvc updated successful'
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
        $tvc = Tvs::findOrFail($id);

        if ($tvc->video != null) {
            $video_path = public_path().'/assets/admin/uploads/tvc/'.$tvc->video;

            unlink($video_path);

            $tvc->delete();
        }else{
            $tvc->delete();
        }

        return response()->json([
            'message' => 'tvc deleted successful'
        ],Response::HTTP_OK);
    }
}
