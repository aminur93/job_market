<?php

namespace App\Http\Controllers\front;

use App\Ads;
use App\AdsCategory;
use App\ApplyJob;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Job;
use App\JobCategory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Image;

class CustomerJobController extends Controller
{
    public function index()
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $id = Auth::guard('customer')->id();

        $customer =  Customer::findOrFail($id);

        return view('customer.job.index', compact('all_category','ads_count','customer'));
    }

    public function getData()
    {
       

            $job = Job::select('jobs.*','customers.name as customer_name','job_categories.name as category_name')
                    ->leftJoin('customers', function($join){
                        $join->on('jobs.customer_id','=','customers.id');
                    })
                    ->leftJoin('job_categories', function($join){
                        $join->on('jobs.category_id','=','job_categories.id');
                    })
                    ->where('jobs.customer_id', Auth::guard('customer')->id())
                    ->get();

            return DataTables::of($job)
            ->addIndexColumn()
            ->addColumn('image',function ($job){
                $url=asset("assets/admin/uploads/job/medium/$job->image");
                return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />';
            })
            ->editColumn('action', function ($job) {
                $return = "<div class=\"btn-group\">";
                if (!empty($job->id))
                {
                    $return .= "
                            <a href=\"/customer_job/edit/$job->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                            ||
                            <a rel=\"$job->id\" rel1=\"customer_job/destroy\" href=\"javascript:\" style='margin-left: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
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

    public function create()
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $id = Auth::guard('customer')->id();

        $customer =  Customer::findOrFail($id);

        $job_categories = JobCategory::latest()->get(); 

        return view('customer.job.create', compact('job_categories','all_category','ads_count','customer'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'max:5120'
        ]);

        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try {
                //code...

                $job = new Job();

                $job->customer_id = Auth::guard('customer')->id();
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
                ], Response::HTTP_CREATED);


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
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $customer_id = Auth::guard('customer')->id();

        $customer =  Customer::findOrFail($customer_id);

        $job_categories = JobCategory::latest()->get(); 

        $job = Job::findOrFail($id);

        return view('customer.job.edit', compact('job_categories','job','all_category','ads_count','customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'max:5120'
        ]);
        
        if($request->_method == 'PUT')
        {
            DB::beginTransaction();

            try {
                //code...

                $job = Job::findOrFail($id);

                $job->customer_id = Auth::guard('customer')->id();
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

    public function cvBank()
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $customer_id = Auth::guard('customer')->id();

        $customer =  Customer::findOrFail($customer_id);

        $cv_bank = ApplyJob::select('apply_jobs.*', 'customer_c_v_s.cv as cv')
                    ->leftJoin('customer_c_v_s', function($join){
                        $join->on('apply_jobs.customer_id','=','customer_c_v_s.customer_id');
                    })
                    ->leftJoin('jobs', function($join){
                        $join->on('apply_jobs.job_id','=','jobs.id');
                    })
                    ->where('apply_jobs.customer_id', $customer_id)
                    ->get();

        return view('cv_bank', compact('all_category','ads_count','customer','cv_bank'));
    }

    public function cvBankDownload($id)
    {
        $cv_bank = ApplyJob::select('apply_jobs.*', 'customer_c_v_s.cv as cv')
                    ->leftJoin('customer_c_v_s', function($join){
                        $join->on('apply_jobs.customer_id','=','customer_c_v_s.customer_id');
                    })
                    ->leftJoin('jobs', function($join){
                        $join->on('apply_jobs.job_id','=','jobs.id');
                    })
                    ->where('apply_jobs.id', $id)
                    ->first();
        $pdf_path = public_path().'/assets/admin/uploads/cv/'.$cv_bank->cv;
        return response()->download($pdf_path);
    }
}
