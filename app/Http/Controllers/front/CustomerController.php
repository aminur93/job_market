<?php

namespace App\Http\Controllers\front;

use App\Ads;
use App\AdsCategory;
use App\ApplyJob;
use App\Customer;
use App\CustomerCV;
use App\CustomerEducation;
use App\CustomerSkills;
use App\CustomerWorkExperience;
use App\District;
use App\Division;
use App\Http\Controllers\Controller;
use App\Job;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Image;
use PhpParser\Node\Stmt\Catch_;

class CustomerController extends Controller
{
    public function index()
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $id = Auth::guard('customer')->id();

        $customer = Customer::select('customers.*','divisions.name as division_name','districts.name as district_name')
                    ->leftJoin('divisions', function($join){
                        $join->on('customers.division_id','=','divisions.id');
                    })
                    ->leftJoin('districts', function($join){
                        $join->on('customers.district_id','=','districts.id');
                    })
                    ->where('customers.id', $id)
                    ->first();

        return view('customer_dashboard', compact('all_category','ads_count','customer'));
    }

    public function profileSetting()
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $id = Auth::guard('customer')->id();

        $customer = Customer::findOrFail($id);

        $divisions = Division::latest()->get();

        $district = District::latest()->get();

        return view('customer_profile_setting', compact('customer','all_category','ads_count','divisions','district'));
    }

    public function customerGetDistrict(Request $request)
    {
        if (isset($_POST['division_id']))
        {
            $division_id = $_POST['division_id'];
        
            $option = '';
        
            $query =  DB::table('districts')
                ->select(
                    'districts.id as id',
                    'districts.division_id as division_id',
                    'districts.name as district_name'
                )
                ->join('divisions','districts.division_id','=','divisions.id')
                ->where('districts.division_id',$division_id)
                ->get();
        
            $option .= "<option value=''>Select District</option>";
        
            foreach ($query as $value) {
            
                $id = $value->id;
            
                $country_name = $value->district_name;
            
                $option .= " <option value=" . $id . ">" . $country_name . "</option>";
            }
        
            echo $option;
        }
    }

    public function customerProfileUpdate(Request $request)
    {

        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{
                $id = Auth::guard('customer')->id();

                $customer = Customer::findOrFail($id);

                $customer->name = $request->name;
                $customer->email = $request->email;
                $customer->phone = $request->phone;
                $customer->address = $request->address;
                $customer->division_id = $request->division_id;
                $customer->district_id = $request->district_id;
                
                if($request->hasFile('image')){

                    $image_tmp = $request->file('image');

                    if($customer->image == null)
                    {
                        if($image_tmp->isValid()){
    
                            $image_name=time().'.'.$image_tmp->getClientOriginalExtension();
        
                            $image_path = public_path().'/assets/frontend/upload/customer/'.$image_name;
        
                            //Resize Image
                            Image::make($image_tmp)->save($image_path);
        
                            $customer->image = $image_name;
                        }
                    }else{
                        if (file_exists(public_path().'/assets/admin/upload/customer/'.$customer->image)) {
                            unlink(public_path().'/assets/admin/upload/customer/'.$customer->image);
                        }

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();
        
                        $image_path = public_path().'/assets/frontend/upload/customer/'.$image_name;
    
                        //Resize Image
                        Image::make($image_tmp)->save($image_path);
    
                        $customer->image = $image_name;
                    }
                }

                $customer->save();

                DB::commit();

                return response()->json([
                    'message' => 'Customer Profile update successful'
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

    public function customerPasswordUpdate(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);

        if($request->_method == 'PUT')
        {
            DB::beginTransaction();

            try{

                $id = Auth::guard('customer')->id();

                $customer = Customer::where('id',$id)->first();

                //dd($customer);

                if(!Hash::check($request->old_password, $customer->password))
                {
                    return response()->json([
                        'error' => 'old password did not match'
                    ],Response::HTTP_INTERNAL_SERVER_ERROR);
                }else{
                    
                }

                $customer->password = bcrypt($request->password);

                $customer->save();

                DB::commit();

                return response()->json([
                    'message' => 'Password update successful'
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

    public function professonal()
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $id = Auth::guard('customer')->id();

        $customer = Customer::select('customers.*','divisions.name as division_name','districts.name as district_name')
                    ->leftJoin('divisions', function($join){
                        $join->on('customers.division_id','=','divisions.id');
                    })
                    ->leftJoin('districts', function($join){
                        $join->on('customers.district_id','=','districts.id');
                    })
                    ->where('customers.id', $id)
                    ->first();

        $customer_professon = DB::table('customer_informations')->where('customer_id', $id)->first();
        $customer_language = DB::table('customer_language')->where('customer_id', $id)->get();
        $customer_skills = DB::table('customer_skills')->where('customer_id', $id)->get();
        $customer_profile_link = DB::table('customer_profile_link')->where('customer_id', $id)->get();
        $customer_work_exp = DB::table('customer_work_experiences')->where('customer_id', $id)->get();
        $customer_edu = DB::table('customer_education')->where('customer_id', $id)->get();
        $customer_certi = DB::table('customer_certifications')->where('customer_id', $id)->get();

        $customer_av = DB::table('customer_available')->where('customer_id', $id)->first();

        //dd($customer_av);

        return view('customer_professonal', compact('customer','all_category','ads_count','customer_professon','customer_language','customer_skills','customer_profile_link','customer_work_exp','customer_edu','customer_certi','customer_av'));
    }

    public function create()
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $id = Auth::guard('customer')->id();

        $customer = Customer::findOrFail($id);

        $customer_professon = DB::table('customer_informations')->where('customer_id', $id)->first();
        $customer_cv = DB::table('customer_c_v_s')->where('customer_id', $id)->first();
        $customer_language = DB::table('customer_language')->where('customer_id', $id)->get();
        $customer_skills = DB::table('customer_skills')->where('customer_id', $id)->get();
        $customer_profile_link = DB::table('customer_profile_link')->where('customer_id', $id)->get();
        $customer_work_exp = DB::table('customer_work_experiences')->where('customer_id', $id)->get();
        $customer_edu = DB::table('customer_education')->where('customer_id', $id)->get();
        $customer_certi = DB::table('customer_certifications')->where('customer_id', $id)->get();

        

        return view('customer_professonal_create', compact('customer','all_category','ads_count','customer_professon','customer_language','customer_skills','customer_profile_link','customer_work_exp','customer_edu','customer_certi','customer_cv'));
    }

    public function store(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $customer_id = Auth::guard('customer')->id();

               
                DB::table('customer_informations')->insert([
                    'customer_id' => $customer_id,
                    'title' => $request->title,
                    'degree' => $request->degree,
                    'profile_image' => null,
                    'details' => $request->details,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                

                $skill_name = count($request->skills_name);
                for ($i=0; $i<$skill_name; $i++){
                    DB::table('customer_skills')->insert([
                        'customer_id' => $customer_id,
                        'skills_name' => $request->skills_name[$i],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }

              
                $language_name_total = count($request->language_name);
                for ($i=0; $i<$language_name_total; $i++){
                    DB::table('customer_language')->insert([
                        'customer_id' => $customer_id,
                        'language_name' => $request->language_name[$i],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
                
                $profile_name_total = count($request->profile_link);
                for ($i=0; $i<$profile_name_total; $i++){
                    DB::table('customer_profile_link')->insert([
                        'customer_id' => $customer_id,
                        'profile_link' => $request->profile_link[$i],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
                
                $workplace_name_total = count($request->workplace_name);
                for($i = 0; $i < $workplace_name_total; $i++)
                {
                    DB::table('customer_work_experiences')->insert([
                        'customer_id' => $customer_id,
                        'workplace_name' => $request->workplace_name[$i],
                        'position' => $request->position[$i],
                        'description_role' => $request->description_role[$i],
                        'join_date' => $request->join_date[$i],
                        'leave_date' => $request->leave_date[$i],
                        // 'currently_working' => $request->currently_working[$i],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
                
                $institution_name = count($request->institution_name);
                for($i = 0; $i <  $institution_name; $i++)
                {
                    DB::table('customer_education')->insert([
                        'customer_id' => $customer_id,
                        'institution_name' => $request->institution_name[$i],
                        'institution_certificate' => $request->institution_certificate[$i],
                        'passing_year' => $request->passing_year[$i],
                        'result' => $request->result[$i],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
                
                $organization_name = count($request->organization_name);
                for($i=0; $i<$organization_name; $i++)
                {
                    DB::table('customer_certifications')->insert([
                        'customer_id' => $customer_id,
                        'organization_name' => $request->organization_name[$i],
                        'certificate_name' => $request->certificate_name[$i],
                        'certificate_area' => $request->certificate_area[$i],
                        'certificate_date' => $request->certificate_date[$i],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
                

                if($request->file('cv'))
                {
                    $file = $request->file('cv');

                    $request->cv->move(public_path().'/assets/admin/uploads/cv/',$file->getClientOriginalName());
    
                    DB::table('customer_c_v_s')->insert([
                        'customer_id' => $customer_id,
                        'cv' => $file->getClientOriginalName(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }

                DB::commit();

                return response()->json([
                    'message' => 'Customer information Store successful'
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

    public function profileUpdate(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $customer_id = Auth::guard('customer')->id();

                DB::table('customer_informations')->where('customer_id', $customer_id)->update([
                    'customer_id' => $customer_id,
                    'title' => $request->title,
                    'degree' => $request->degree,
                    'profile_image' => null,
                    'details' => $request->details,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                if($request->language_name)
                {
                    $language_name_total = count($request->language_name);
                    for ($i=0; $i<$language_name_total; $i++){
                        DB::table('customer_language')->insert([
                            'customer_id' => $customer_id,
                            'language_name' => $request->language_name[$i],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                }

                DB::commit();

                return response()->json([
                    'message' => 'Customer profile update successful'
                ],Response::HTTP_OK);

            }catch(QueryException $e)
            {
                DB::rollBack();

                $error = $e->getMessage();

                return response()->json([
                    'error' => $error
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function skillUpdate(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $customer_id = Auth::guard('customer')->id();

                $skill_name = count($request->skills_name);
                for ($i=0; $i<$skill_name; $i++){
                    DB::table('customer_skills')->insert([
                        'customer_id' => $customer_id,
                        'skills_name' => $request->skills_name[$i],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }

                DB::commit();

                return response()->json([
                    'message' => 'Customer Skills Updated successful'
                ],Response::HTTP_OK);

            }catch(QueryException $e)
            {
                DB::rollBack();

                $error = $e->getMessage();

                return response()->json([
                    'error' => $error
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function experienceUpdate(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $customer_id = Auth::guard('customer')->id();

                $experience_id = explode(',', $request->input('new_experience_id'));
                $workplace_name = explode(',', $request->input('new_work'));
                $position = explode(',', $request->input('new_position'));
                $description_role = explode(',', $request->input('new_description'));
                $join_date = explode(',', $request->input('new_join_date'));
                $leave_date = explode(',', $request->input('new_leave_date'));

                $experience = array_map(null, $experience_id,  $workplace_name, $position,  $description_role, $join_date,  $leave_date);

                foreach( $experience as $key => $e)
                {
                    DB::table('customer_work_experiences')->where('id', $e[0])->update([
                        'customer_id' => $customer_id,
                        'workplace_name' => $e[1],
                        'position' => $e[2],
                        'description_role' => $e[3],
                        'join_date' => $e[4],
                        'leave_date' => $e[5],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }


                if($request->input('get_workplace_name') || $request->input('get_position') || $request->input('get_description_role') ||  $request->input('get_join_date') || $request->input('get_leave_date'))
                {
                    $workplace_name = explode(',', $request->input('get_workplace_name'));
                    $position = explode(',', $request->input('get_position'));
                    $description_role = explode(',', $request->input('get_description_role'));
                    $join_date = explode(',', $request->input('get_join_date'));
                    $leave_date = explode(',', $request->input('get_leave_date'));

                    $cus_experience = array_map(null, $workplace_name,  $position, $description_role, $join_date,  $leave_date);

                    //dd($cus_experience);

                    foreach ($cus_experience as $key => $ce){
    
                        DB::table('customer_work_experiences')->insert([
                            'customer_id' => $customer_id,
                            'workplace_name' => $ce[0],
                            'position' => $ce[1],
                            'description_role' => $ce[2],
                            'join_date' => $ce[3],
                            'leave_date' => $ce[4],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                }


                DB::commit();

                return response()->json([
                    'message' => 'Customer Experience Updated successful'
                ],Response::HTTP_OK);

            }catch(QueryException $e)
            {
                DB::rollBack();

                $error = $e->getMessage();

                return response()->json([
                    'error' => $error
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function educationUpdate(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $customer_id = Auth::guard('customer')->id();

                $education_id = explode(',', $request->input('new_education_id'));
                $institution_name = explode(',', $request->input('new_institution_name'));
                $institution_certificate = explode(',', $request->input('new_institution_certificate'));
                $passing_year = explode(',', $request->input('new_passing_year'));
                $result = explode(',', $request->input('new_result'));

                $education = array_map(null, $education_id,  $institution_name, $institution_certificate,  $passing_year, $result);

                foreach( $education as $key => $e)
                {
                    DB::table('customer_education')->where('id', $e[0])->update([
                        'customer_id' => $customer_id,
                        'institution_name' => $e[1],
                        'institution_certificate' => $e[2],
                        'passing_year' => $e[3],
                        'result' => $e[4],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }

                if($request->input('get_institution_name') || $request->input('get_institution_certificate') || $request->input('get_passing_year') ||  $request->input('get_result'))
                {
                    $institution_name = explode(',', $request->input('get_institution_name'));
                    $institution_certificate = explode(',', $request->input('get_institution_certificate'));
                    $passing_year = explode(',', $request->input('get_passing_year'));
                    $result = explode(',', $request->input('get_result'));

                    $cus_education = array_map(null, $institution_name,  $institution_certificate, $passing_year, $result);

                    //dd($cus_experience);

                    foreach ($cus_education as $key => $ce){
    
                        DB::table('customer_education')->insert([
                            'customer_id' => $customer_id,
                            'institution_name' => $ce[0],
                            'institution_certificate' => $ce[1],
                            'passing_year' => $ce[2],
                            'result' => $ce[3],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                }


                DB::commit();

                return response()->json([
                    'message' => 'Customer Education Updated successful'
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

    public function certificateUpdate(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $customer_id = Auth::guard('customer')->id();

                $certification_id = explode(',', $request->input('new_certification_id'));
                $organization_name = explode(',', $request->input('new_organization_name'));
                $certificate_name = explode(',', $request->input('new_certificate_name'));
                $certificate_area = explode(',', $request->input('new_certificate_area'));
                $certificate_date = explode(',', $request->input('new_certificate_date'));

                $certification = array_map(null, $certification_id,  $organization_name, $certificate_name,  $certificate_area, $certificate_date);

                foreach( $certification as $key => $c)
                {
                    DB::table('customer_certifications')->where('id', $c[0])->update([
                        'customer_id' => $customer_id,
                        'organization_name' => $c[1],
                        'certificate_name' => $c[2],
                        'certificate_area' => $c[3],
                        'certificate_date' => $c[4],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }

                if($request->input('get_organization_name') || $request->input('get_certificate_name') || $request->input('get_certificate_area') ||  $request->input('get_certificate_date'))
                {
                    $organization_name = explode(',', $request->input('get_organization_name'));
                    $certificate_name = explode(',', $request->input('get_certificate_name'));
                    $certificate_area = explode(',', $request->input('get_certificate_area'));
                    $certificate_date = explode(',', $request->input('get_certificate_date'));

                    $cus_certification = array_map(null, $organization_name,  $certificate_name, $certificate_area, $certificate_date);

                    //dd($cus_experience);

                    foreach ($cus_certification as $key => $cc){
    
                        DB::table('customer_certifications')->insert([
                            'customer_id' => $customer_id,
                            'organization_name' => $cc[0],
                            'certificate_name' => $cc[1],
                            'certificate_area' => $cc[2],
                            'certificate_date' => $cc[3],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                }


                DB::commit();

                return response()->json([
                    'message' => 'Customer Certification Updated successful'
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

    public function linkUpdate(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $customer_id = Auth::guard('customer')->id();


                $profile_link_name = explode(',', $request->input('new_profile'));
                $profile_link_id = explode(',', $request->input('new_link_id'));

                $profile = array_map(null, $profile_link_id, $profile_link_name);

                foreach($profile as $key => $p)
                {
                    DB::table('customer_profile_link')->where('id', $p[0])->update([
                        'customer_id' => $customer_id,
                        'profile_link' => $p[1],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }

                if($request->input('get_proifle_link'))
                {
                    $profile_link = explode(',', $request->input('get_proifle_link'));

                    foreach ($profile_link as $key => $pr){
    
                        DB::table('customer_profile_link')->insert([
                            'customer_id' => $customer_id,
                            'profile_link' => $pr,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                }

                DB::commit();

                return response()->json([
                    'message' => 'Customer profile link updated successful'
                ],Response::HTTP_OK);

            }Catch(QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return response()->json([
                    'error' => $error,
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function cvUpdate(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $customer_id = Auth::guard('customer')->id();
                $cv_id = $request->customer_cv_id;

                if($request->file('cv'))
                {
                    $file = $request->file('cv');

                    $request->cv->move(public_path().'/assets/admin/uploads/cv/',$file->getClientOriginalName());
    
                    DB::table('customer_c_v_s')->where('id', $cv_id)->where('customer_id', $customer_id)->update([
                        'customer_id' => $customer_id,
                        'cv' => $file->getClientOriginalName(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }

                DB::commit();

                return response()->json([
                    'message' => 'Customer Cv updated successful'
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

    public function available()
    {
        $customer_id = Auth::guard('customer')->id();

        $customer_available = DB::table('customer_available')->where('customer_id', $customer_id)->first();

        if(empty($customer_available))
        {
            DB::table('customer_available')->insert([
                'customer_id' => $customer_id,
                'available' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            return response()->json([
                'message' => 'Customer is avaiable'
            ],Response::HTTP_OK);

        }else{

            if($customer_available->available == 0)
            {
                DB::table('customer_available')->where('customer_id', $customer_id)->update([
                    'customer_id' => $customer_id,
                    'available' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                return response()->json([
                    'message' => 'Customer is avaiable'
                ],Response::HTTP_OK);

            }else{
                DB::table('customer_available')->where('customer_id', $customer_id)->update([
                    'customer_id' => $customer_id,
                    'available' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                return response()->json([
                    'message' => 'Customer is not avaiable'
                ],Response::HTTP_OK);

            }
            
        }
    }

    public function skillDelete($id)
    {
        DB::table('customer_skills')->where('id', $id)->delete();

        return response()->json([
            'message' => 'skills delete successful'
        ],Response::HTTP_OK);
    }

    public function deleteAccount()
    {
        $customer_id = Auth::guard('customer')->id();

        Customer::where('id', $customer_id)->update(['deleted_at' => 1]);

        auth('customer')->logout();

        return redirect('/');
    }

    public function customerAds()
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $id = Auth::guard('customer')->id();

        $customer = Customer::findOrFail($id);

        return view('customer_ads', compact('all_category','ads_count','customer'));
    }

    public function applyJob($id)
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $customer_id = Auth::guard('customer')->id();

        $customer = Customer::where('id', $customer_id)->first();

        $job = Job::findOrFail($id);

        return view('apply_job', compact('all_category','ads_count','customer','job'));
    }

    public function applyJobStore(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $job = ApplyJob::where('customer_id', $request->customer_id)->where('job_id', $request->job_id)->count();

                if($job > 0)
                {
                    return response()->json([
                        'error' => 'you are already apply in this job'
                    ], Response::HTTP_BAD_REQUEST);
                }else{
                    $apply_job = new ApplyJob();

                    $apply_job->customer_id = $request->customer_id;
                    $apply_job->job_id = $request->job_id;
                    $apply_job->email = $request->email;
                    $apply_job->phone = $request->phone;
                    $apply_job->expacted_salary = $request->expacted_salary;
    
                    $apply_job->save();
    
                    DB::commit();
    
                    return response()->json([
                        'message' => 'Apply Job successful'
                    ],Response::HTTP_OK);
                }

            }catch(QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return response()->json([
                    'error' => $error
                ],Response::HTTP_BAD_REQUEST);
            }
        }
    }
}
