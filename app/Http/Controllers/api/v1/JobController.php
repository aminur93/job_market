<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Job;
use App\JobCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;

class JobController extends Controller
{

    public function index()
    {
        $customer_id = auth('api')->id();

        $jobs = Job::where('customer_id', $customer_id)->paginate(10);

        if(empty($jobs))
        {
            return response()->json([
                'message' => 'No Data Found'
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'jobs' => $jobs
            ],Response::HTTP_OK);
        }
    }

    public function store(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try {
                //code...

                $job = new Job();

                $job->customer_id = auth('api')->id();
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

                if($request->fresher_status == false)
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


            } catch (Exception $e) {
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
        $customer_id = auth('api')->id();

        $job = Job::where('id', $id)->where('customer_id', $customer_id)->first();

        if(empty($job))
        {
            return response()->json([
                'message' => 'No Data Found'
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'job' => $job
            ],Response::HTTP_OK);
        }
    }

    public function update(Request $request, $id)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try {
                //code...

                $job = Job::findOrFail($id);

                $job->customer_id = auth('api')->id();
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


            } catch (Exception $e) {
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


    public function jobCategory()
    {
        $job_category = JobCategory::latest()->get();

        $job = Job::selectRaw('jobs.*, count(jobs.category_id) AS category_count')
                    ->leftJoin('job_categories', function($join){
                        $join->on('jobs.category_id','=','job_categories.id');
                    })
                    ->groupBy('jobs.category_id')
                    ->where('jobs.approve','=',1)
                    ->get();

        $total_cat_job = [];

        foreach($job_category as $jc){
            $total_cat_job[$jc->name] = array("id" => $jc->id, "image" => $jc->image, "total" => 0);

            foreach($job as $j){
                if($jc->id == $j->category_id){
                    $total_cat_job[$jc->name] = array("id" => $jc->id, "image" => $jc->image, "total" => $j->category_count);
                }
            }
        }

        return response()->json([
            'job_category' => $total_cat_job
        ],Response::HTTP_OK);
    }

    public function categoryJobList($id)
    {
        $jobs = Job::where('approve','=',1)->where('category_id', $id)->paginate(6);

        return response()->json([
            'jobs' => $jobs
        ],Response::HTTP_OK);
    }

    public function allJobList()
    {
        $all_jobs = Job::where('approve','=',1)->latest()->paginate(6);

        return response()->json([
            'all_job' => $all_jobs
        ],Response::HTTP_OK);
    }

    public function jobDetails($id)
    {
        $job = Job::where('id', $id)->first();

        if($job != null)
        {
            return response()->json([
                'job_details' => $job
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'No Data Found'
            ],Response::HTTP_OK);
        }

       
    }
}
