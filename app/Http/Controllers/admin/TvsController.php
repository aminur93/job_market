<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Tvs;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TvsController extends Controller
{
    public function index()
    {
        return view('admin.tvc.index');
    }

    public function getData()
    {
        $admin = User::role('admin')->first();

        if($admin->id == Auth::id())
        {
            $tvc = Tvs::select('tvs.*', 'users.name as user_name')
            ->leftJoin('users', function($join){
                $join->on('tvs.user_id','=','users.id');
            })
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
                ->addColumn('approve',function ($tvc){
                    if($tvc->approve == 0)
                    {

                        return '<div>
                                <label class="switch patch">
                                    <input type="checkbox" class="approve_toggle" data-value="'.$tvc->id.'" id="approve_change" value="'.$tvc->id.'">
                                    <span class="slider"></span>
                                </label>
                            </div>';
                    }else{
                        return '<div>
                            <label class="switch patch">
                                <input type="checkbox" id="approve_change"  class="approve_toggle" data-value="'.$tvc->id.'"  value="'.$tvc->id.'" checked>
                                <span class="slider"></span>
                            </label>
                        </div>';
                    }

                })
                ->editColumn('action', function ($tvc) {
                    $return = "<div class=\"btn-group\">";
                    if (!empty($tvc->id))
                    {
                        $return .= "
                                <a href=\"/tvc/edit/$tvc->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                                ||
                                <a rel=\"$tvc->id\" rel1=\"tvc/destroy\" href=\"javascript:\" style='margin-left: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
                                    ";
                    }
                    $return .= "</div>";
                    return $return;
                })
                ->rawColumns([
                    'action','approve','video'
                ])
                ->make(true);
        }else{
            $tvc = Tvs::select('tvs.*', 'users.name as user_name','users.id as user_id')
                ->leftJoin('users', function($join){
                    $join->on('tvs.user_id','=','users.id');
                })
                ->leftJoin('model_has_roles', function($join){
                    $join->on('users.id','=','model_has_roles.model_id');
                })
                ->leftJoin('roles', function($join){
                    $join->on('model_has_roles.role_id','=','roles.id');
                })
                ->where('users.id','=',Auth::id())
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
                ->addColumn('approve',function ($tvc){
                    if($tvc->approve == 0)
                    {

                        return '<div>
                                <label class="switch patch">
                                    <input type="checkbox" class="approve_toggle" data-value="'.$tvc->id.'" id="approve_change" value="'.$tvc->id.'">
                                    <span class="slider"></span>
                                </label>
                            </div>';
                    }else{
                        return '<div>
                            <label class="switch patch">
                                <input type="checkbox" id="approve_change"  class="approve_toggle" data-value="'.$tvc->id.'"  value="'.$tvc->id.'" checked>
                                <span class="slider"></span>
                            </label>
                        </div>';
                    }

                })
                ->editColumn('action', function ($tvc) {
                    $return = "<div class=\"btn-group\">";
                    if (!empty($tvc->id))
                    {
                        $return .= "
                                <a href=\"/tvc/edit/$tvc->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                                ||
                                <a rel=\"$tvc->id\" rel1=\"tvc/destroy\" href=\"javascript:\" style='margin-left: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
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
    }

    public function create()
    {
        return view('admin.tvc.create');
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            
            DB::beginTransaction();

            try {
                //code...

                $tvc = new Tvs();

                $tvc->user_id = Auth::id();
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
                ],Response::HTTP_CREATED);

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

        return view('admin.tvc.edit', compact('tvc'));
    }

    public function update(Request $request, $id)
    {
        if ($request->_method == 'PUT') {
            
            DB::beginTransaction();

            try{

                $tvc = Tvs::findOrFail($id);

                $tvc->user_id = Auth::id();
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

    public function approve($id)
    {
        $tvc = Tvs::findOrFail($id);

        if($tvc->approve == 0)
        {
            $tvc->update(['approve' => 1]);

            return response()->json([
                'message' => 'Tvc is approved'
            ],Response::HTTP_OK);
        }else{
            $tvc->update(['approve' => 0]);

            return response()->json([
                'message' => 'Tvc approve cancel'
            ],Response::HTTP_OK);
        }
    }
}
