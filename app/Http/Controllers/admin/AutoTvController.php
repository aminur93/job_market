<?php

namespace App\Http\Controllers\admin;

use App\AutoTv;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AutoTvController extends Controller
{
    public function index()
    {
        return view('admin.auto_tv.index');
    }

    public function getData()
    {
        $auto_tv = AutoTv::select('auto_tvs.*','users.name as user_name')
                    ->leftJoin('users', function($join){
                        $join->on('auto_tvs.user_id', '=', 'users.id');
                    })
                    ->get();
        
        return DataTables::of($auto_tv)
        ->addIndexColumn()
        ->addColumn('video',function ($auto_tv){
            $url=asset("assets/admin/uploads/auto_tv/$auto_tv->video");
            return '
                    <video width="320" height="240" controls>
                        <source src='.$url.' type="video/mp4">
                    </video>
            ';
        })
        ->addColumn('approve',function ($auto_tv){
            if($auto_tv->approve == 0)
            {

                return '<div>
                        <label class="switch patch">
                            <input type="checkbox" class="approve_toggle" data-value="'.$auto_tv->id.'" id="approve_change" value="'.$auto_tv->id.'">
                            <span class="slider"></span>
                        </label>
                      </div>';
            }else{
                return '<div>
                    <label class="switch patch">
                        <input type="checkbox" id="approve_change"  class="approve_toggle" data-value="'.$auto_tv->id.'"  value="'.$auto_tv->id.'" checked>
                        <span class="slider"></span>
                    </label>
                  </div>';
            }

        })
        ->editColumn('action', function ($auto_tv) {
            $return = "<div class=\"btn-group\">";
            if (!empty($auto_tv->id))
            {
                $return .= "
                        <a href=\"/auto_tv/edit/$auto_tv->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                        ||
                        <a rel=\"$auto_tv->id\" rel1=\"auto_tv/destroy\" href=\"javascript:\" style='margin-left: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
                            ";
            }
            $return .= "</div>";
            return $return;
        })
        ->rawColumns([
            'action','approve','video'
        ])
        ->make(true);
    }

    public function create()
    {
        
        return view('admin.auto_tv.create');
    }

    public function store(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try {
                //code...

                $auto_tv = new AutoTv();

                $auto_tv->user_id = Auth::id();
                $videoName = time().'.'.$request->video->getClientOriginalExtension();
                $request->video->move(public_path().'/assets/admin/uploads/auto_tv/', $videoName);

                $auto_tv->video = $videoName;

                $auto_tv->save();

                DB::commit();

                return response()->json([
                    'message' => 'Auto tv store successful'
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
        $auto_tv = AutoTv::findOrFail($id);
        return view('admin.auto_tv.edit', compact('auto_tv'));
    }

    public function update(Request $request, $id)
    {
        if($request->_method == 'PUT')
        {
            DB::beginTransaction();

            try {
                //code...

                $auto_tv = AutoTv::findOrFail($id);

                $auto_tv->user_id = Auth::id();

                if($request->hasFile('video'))
                {
                    $video_tmp = $request->file('video');

                    if($auto_tv->video == null)
                    {
                        $video_name = time().'.'.$video_tmp->getClientOriginalExtension();

                        $video_tmp->move(public_path().'/assets/admin/uploads/auto_tv/', $video_name);

                        $auto_tv->video = $video_name;
                    }else{
                        if (file_exists(public_path().'/assets/admin/uploads/auto_tv/'.$auto_tv->video)) {
                            unlink(public_path().'/assets/admin/uploads/auto_tv/'.$auto_tv->video);
                        }

                        $video_name = time().'.'.$video_tmp->getClientOriginalExtension();

                        $video_tmp->move(public_path().'/assets/admin/uploads/auto_tv/', $video_name);

                        $auto_tv->video = $video_name;
                    }
                }

                $auto_tv->save();

                DB::commit();

                return response()->json([
                    'message' => 'Auto tv updated successful'
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

    public function destroy($id)
    {
        $auto_tv = AutoTv::findOrFail($id);

        if($auto_tv->video != null)
        {
            $video_path = public_path().'/assets/admin/uploads/auto_tv/'.$auto_tv->video;

            unlink($video_path);

            $auto_tv->delete();
        }else{
            $auto_tv->delete();
        }

        return response()->json([
            'message' => 'Auto tv deleted successful'
        ],Response::HTTP_OK);
    }

    public function approve($id)
    {
        $auto_tv = AutoTv::findOrFail($id);

        if($auto_tv->appove == 0)
        {
            $auto_tv->update(['approve' => 1]);

            return response()->json([
                'message' => 'Auto tv is approve'
            ],Response::HTTP_OK);
        }else{
            $auto_tv->update(['approve' => 0]);
            return response()->json([
                'message' => 'Auto tv approve is cancel'
            ],Response::HTTP_OK);
        }
    }
}
