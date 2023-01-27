<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Tvs;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TvcController extends Controller
{

    public function index()
    {
        $customer_id = auth('api')->id();

        $tvc = Tvs::where('customer_id', $customer_id)->paginate(10);

        if(empty($tvc))
        {
            return response()->json([
                'message' => 'No Data Found'
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'tvc' => $tvc
            ],Response::HTTP_OK);
        }
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            
            DB::beginTransaction();

            try {
                //code...

                $tvc = new Tvs();

                $tvc->customer_id = auth('api')->id();
                $tvc->date = $request->date;
                $tvc->company_name = $request->company_name;
                $tvc->tvc_title = $request->title;
                $tvc->description = $request->description;

                $videoName = time().'.'.$request->video->getClientOriginalExtension();
                $request->video->move(public_path().'/assets/admin/uploads/tvc/', $videoName);

                $tvc->video = $videoName;

                $tvc->save();

                DB::commit();

                return response()->json([
                    'message' => 'Tvc store successful'
                ], Response::HTTP_CREATED);

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

    public function edit($id)
    {
        $customer_id = auth('api')->id();

        $tvc = Tvs::where('id',$id)->where('customer_id', $customer_id)->first();

        if(empty($tvc))
        {
            return response()->json([
                'message' => 'No Data Found'
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'tvc' => $tvc
            ],Response::HTTP_OK);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            
            DB::beginTransaction();

            try{

                $tvc = Tvs::findOrFail($id);

                $tvc->customer_id = auth('api')->id();
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

                $tvc->save();

                DB::commit();

                return response()->json([
                    'message' => 'Tvc updated successful'
                ],Response::HTTP_OK);

            }catch(Exception $e){
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


    public function getTvc()
    {
        $tvc = Tvs::where('approve','=',1)->take(3)->latest()->get();

        return response()->json([
            'tvc' => $tvc
        ],Response::HTTP_OK);
    }

    public function getAllTvc()
    {
        $all_tvc = Tvs::where('approve','=',1)->latest()->paginate(10);

        return response()->json([
            'all_tvc' => $all_tvc
        ],Response::HTTP_OK);
    }

    public function getDetailsTvc($id)
    {
        $tvc = Tvs::where('id', $id)->first();

        return response()->json([
            'tvc' => $tvc
        ],Response::HTTP_OK);
    }
}
