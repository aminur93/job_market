<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Job;
use App\JobCategory;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;
use Yajra\DataTables\Facades\DataTables;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:job_bank-list|job_bank-create|job_bank-edit|job_bank-delete|job_bank-approve', ['only' => ['index','store']]);
        $this->middleware('permission:job_bank-create', ['only' => ['create','store']]);
        $this->middleware('permission:job_bank-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:job_bank-delete', ['only' => ['destroy']]);
        $this->middleware('permission:job_bank-approve', ['only' => ['approve']]);
    }

    public function index()
    {
        return view('admin.job.index');
    }

    public function getData()
    {
        $admin = User::role('admin')->first();

        if($admin['id'] == Auth::id()){

            $job = Job::select('jobs.*','users.name as user_name','job_categories.name as category_name')
                    ->leftJoin('users', function($join){
                        $join->on('jobs.user_id','=','users.id');
                    })
                    ->leftJoin('job_categories', function($join){
                        $join->on('jobs.category_id','=','job_categories.id');
                    })
                    ->get();

            return DataTables::of($job)
            ->addIndexColumn()
            ->addColumn('image',function ($job){
                $url=asset("assets/admin/uploads/job/medium/$job->image");
                return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />';
            })
            ->addColumn('approve',function ($job){
                $admin = User::role('admin')->first();
               
                if($job->approve == 0 && $admin->can('approve job_bank'))
                {
                    
                    return '<div>
                            <label class="switch patch">
                                <input type="checkbox" class="approve_toggle" data-value="'.$job->id.'" id="approve_change" value="'.$job->id.'">
                                <span class="slider"></span>
                            </label>
                        </div>';
                }else{
                    return '<div>
                        <label class="switch patch">
                            <input type="checkbox" id="approve_change"  class="approve_toggle" data-value="'.$job->id.'"  value="'.$job->id.'" checked>
                            <span class="slider"></span>
                        </label>
                    </div>';
                }
                
    
            })
            ->editColumn('action', function ($job) {
                $return = "<div class=\"btn-group\">";
                if (!empty($job->id))
                {
                    $return .= "
                            <a href=\"/job/edit/$job->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                            ||
                            <a href=\"/job/details/$job->id\" style='margin-left: 5px' class=\"btn btn-sm btn-info\"><i class='fa fa-eye'></i></a>
                            ||
                            <a rel=\"$job->id\" rel1=\"job/destroy\" href=\"javascript:\" style='margin-left: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
                                  ";
                }
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'image','action','approve'
            ])
            ->make(true);

        }else{

            $jobs = Job::select('jobs.*','users.name as user_name','job_categories.name as category_name','users.id as user_id')
                ->leftJoin('users', function($join){
                    $join->on('jobs.user_id','=','users.id');
                })
                ->leftJoin('job_categories', function($join){
                    $join->on('jobs.category_id','=','job_categories.id');
                })
                ->leftJoin('model_has_roles', function($join){
                    $join->on('users.id','=','model_has_roles.model_id');
                })
                ->leftJoin('roles', function($join){
                    $join->on('model_has_roles.role_id','=','roles.id');
                })
                ->where('users.id','=',Auth::id())
                ->get();
            
            //dd($jobs);

            return DataTables::of($jobs)
            ->addIndexColumn()
            ->addColumn('image',function ($jobs){
                $url=asset("assets/admin/uploads/job/medium/$jobs->image");
                return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />';
            })
            ->addColumn('approve',function ($jobs){
               
                if($jobs->approve == 0)
                {
                    
                    return '<div>
                            <label class="switch patch">
                                <input type="checkbox" class="approve_toggle" data-value="'.$jobs->id.'" id="approve_change" value="'.$jobs->id.'">
                                <span class="slider"></span>
                            </label>
                        </div>';
                }else{
                    return '<div>
                        <label class="switch patch">
                            <input type="checkbox" id="approve_change"  class="approve_toggle" data-value="'.$jobs->id.'"  value="'.$jobs->id.'" checked>
                            <span class="slider"></span>
                        </label>
                    </div>';
                }
                
    
            })
            ->editColumn('action', function ($jobs) {
                $return = "<div class=\"btn-group\">";
                if (!empty($jobs->id))
                {
                    $return .= "
                            <a href=\"/job/edit/$jobs->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                            ||
                            <a href=\"/job/details/$jobs->id\" style='margin-left: 5px' class=\"btn btn-sm btn-info\"><i class='fa fa-eye'></i></a>
                            ||
                            <a rel=\"$jobs->id\" rel1=\"job/destroy\" href=\"javascript:\" style='margin-left: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
                                  ";
                }
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'image','action','approve'
            ])
            ->make(true);
        }
    }

    public function create()
    {
        $job_categories = JobCategory::latest()->get(); 
        return view('admin.job.create', compact('job_categories'));
    }

    public function store(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try {
                //code...

                $job = new Job();

                $job->user_id = Auth::id();
                $job->category_id = $request->category_id;
                $job->publish_date = $request->publish_date;
                $job->expire_date = $request->expire_date;
                $job->company_name = $request->company_name;
                $job->position = $request->position;
                $job->vacancy = $request->vacancy;
                $job->qualification = $request->qualification;
                $job->location = $request->location;
                $job->employement_status = $request->employement_status;
                $job->work_place = $request->work_place;
                $job->salary = $request->salary;
                $job->experience = $request->experience;
                $job->company_description = $request->company_description;
                $job->job_description = $request->job_description;
                $job->responsibility_description = $request->responsibility_description;
                $job->additional_description = $request->additional_description;
                $job->other_benefits = $request->other_benefits;

                if($request->fresher_status == 0)
                {
                    $job->fresher_status = 0;
                }else{
                    $job->fresher_status = 1;
                }

                if($request->hasFile('image')){

                    $image_tmp = $request->file('image');

                    if($image_tmp->isValid()){

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/job/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/job/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/job/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/job/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);


                        $job->image = $image_name;
                    }
                }

                $job->save();

                DB::commit();

                return response()->json([
                    'message' => 'Job store successful'
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
        $job_categories = JobCategory::latest()->get(); 
        $job = Job::findOrFail($id);
        return view('admin.job.edit', compact('job_categories','job'));
    }

    public function update(Request $request, $id)
    {
        if($request->_method == 'PUT')
        {
            DB::beginTransaction();

            try {
                //code...

                $job = Job::findOrFail($id);

                $job->user_id = Auth::id();
                $job->category_id = $request->category_id;
                $job->publish_date = $request->publish_date;
                $job->expire_date = $request->expire_date;
                $job->company_name = $request->company_name;
                $job->position = $request->position;
                $job->vacancy = $request->vacancy;
                $job->qualification = $request->qualification;
                $job->location = $request->location;
                $job->employement_status = $request->employement_status;
                $job->work_place = $request->work_place;
                $job->salary = $request->salary;
                $job->experience = $request->experience;
                $job->company_description = $request->company_description;
                $job->job_description = $request->job_description;
                $job->responsibility_description = $request->responsibility_description;
                $job->additional_description = $request->additional_description;
                $job->other_benefits = $request->other_benefits;

                if($request->fresher_status == 0)
                {
                    $job->fresher_status = 0;
                }else{
                    $job->fresher_status = 1;
                }

                if($request->hasFile('image')){

                    $image_tmp = $request->file('image');

                    if($job->image == null){
                        // delete old images

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/job/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/job/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/job/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/job/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                        $job->image = $image_name;


                    }else{
                        if (file_exists(public_path().'/assets/admin/uploads/job/original/'.$job->image)) {
                            unlink(public_path().'/assets/admin/uploads/job/original/'.$job->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/job/large/'.$job->image)) {
                            unlink(public_path().'/assets/admin/uploads/job/large/'.$job->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/job/medium/'.$job->image)) {
                            unlink(public_path().'/assets/admin/uploads/job/medium/'.$job->image);
                        }
                        if (file_exists(public_path().'/assets/admin/uploads/job/small/'.$job->image)) {
                            unlink(public_path().'/assets/admin/uploads/job/small/'.$job->image);
                        }

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/job/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/job/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/job/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/job/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                        $job->image = $image_name;
                    }
                }

                $job->save();

                DB::commit();

                return response()->json([
                    'message' => 'Job updated successful'
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
        $job = Job::findOrFail($id);

        if($job->image != null)
        {
            $original_image_path = public_path().'/assets/admin/uploads/job/original/'.$job->image;
            $large_image_path = public_path().'/assets/admin/uploads/job/large/'.$job->image;
            $medium_image_path = public_path().'/assets/admin/uploads/job/medium/'.$job->image;
            $small_image_path = public_path().'/assets/admin/uploads/job/small/'.$job->image;

            unlink($original_image_path);
            unlink($large_image_path);
            unlink($medium_image_path);
            unlink($small_image_path);

            $job->delete();
        }else{
            $job->delete();
        }

        return response()->json([
            'message' => 'Job deleted successful'
        ],Response::HTTP_OK);
    }

    public function approve($id)
    {
        $job = Job::findOrFail($id);

        if($job->approve == 0)
        {
            $job->update(['approve' => 1]);

            return response()->json([
                'message' => 'Job is approve'
            ],Response::HTTP_ACCEPTED);
        }else{
            $job->update(['approve' => 0]);

            return response()->json([
                'message' => 'Job approve cancel'
            ],Response::HTTP_ACCEPTED);
        }
    }

    public function details($id)
    {
        $job = Job::findOrFail($id);

        return view('admin.job.details', compact('job'));
    }
}
