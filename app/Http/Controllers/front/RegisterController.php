<?php

namespace App\Http\Controllers\front;

use App\Customer;
use App\Division;
use App\Ads;
use App\AdsCategory;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Image;
use App\SendOtp;

class RegisterController extends Controller
{
    public function index()
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $division = Division::latest()->get();

        return view('custome_register', compact('division','all_category','ads_count'));
    }

    public function getCustomerDistrict()
    {
        if (isset($_POST['division_id']))
        {
            $division_id = $_POST['division_id'];
        
            $option = '';
        
            $query = DB::table('districts')
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

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'terms_conditions' => 'required',
            'password' => 'required|confirmed'
        ]);

        if($request->isMethod('post'))
        {

            //check customer phone exists or not
            $customer_phone = Customer::where('phone', $request->phone)->first();
            
            if($customer_phone != '')
            {
                return response()->json([
                    'errors' => 'Phone number already exists'
                ], Response::HTTP_BAD_REQUEST);
            }else{

                //check customer email already exists or not
                $customer_email = Customer::where('email', $request->email)->first();

                if($customer_email > 0)
                {
                    return response()->json([
                        'errors' => 'Email number already exists'
                    ], Response::HTTP_BAD_REQUEST);
                }else{
                    $customer = new Customer();

                    $customer->name = $request->name;
                    $customer->email = $request->email;
                    $customer->phone = $request->phone;
                    $customer->address = $request->address;
                    $customer->division_id = $request->division_id;
                    $customer->district_id = $request->district_id;
                    $customer->password = bcrypt($request->password);
        
                    if($request->terms_conditions == false){
                        $customer->terms_conditions = 0;
                    }else{
                        $customer->terms_conditions = 1;
                    }
        
                    if($request->hasFile('image')){
        
                        $image_tmp = $request->file('image');
        
                        if($image_tmp->isValid()){
        
                            $image_name=time().'.'.$image_tmp->getClientOriginalExtension();
        
                            $image_path = public_path().'/assets/frontend/upload/customer/'.$image_name;
        
                            //Resize Image
                            Image::make($image_tmp)->save($image_path);
        
                            $customer->image = $image_name;
                        }
                    }
        
                    $customer->save();
        
                    $otp_code = rand(1111,9999);
        
                    DB::table('customer_otp')->insert([
                        'customer_id' => $customer->id,
                        'otp_code' => $otp_code,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
        
                    SendOtp::sendCode($otp_code, $request->phone);
        
                    return response()->json([
                        'message' => "Customer Store successful",
                        'phone' => $request->phone
                    ],Response::HTTP_OK);
                }
            }
            
           
        }
    }

    public function otp($phone)
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $customer = Customer::where('phone', $phone)->first();

        return view('otp', compact('customer','all_category','ads_count'));
    }

    public function check(Request $request)
    {
        $customer = Customer::where('id', $request->customer_id)->first();

        $customer_code = DB::table('customer_otp')->where('customer_id', $customer->id)->first();

        if($customer_code->otp_code == $request->otp_code)
        {
            DB::table('customer_otp')->where('customer_id', $customer->id)->update(['otp_code' => null]);
            
            $customer->update(['status' => 1]);

            return response()->json([
                'message' => 'Account is verified now'
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'Code is invalid'
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function resend(Request $request)
    {
        $phone = $_POST['phone'];

        $customer_id = $_POST['customer_id'];

        $customer_code = DB::table('customer_otp')->where('customer_id', $customer_id)->first();

        //dd($customer_code);

        if($customer_code->otp_code != null)
        {
            DB::table('customer_otp')->where('customer_id', $customer_id)->delete();

            $otp_code = rand(1111,9999);
        
            DB::table('customer_otp')->insert([
                'customer_id' => $customer_id,
                'otp_code' => $otp_code,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            SendOtp::sendCode($otp_code, $phone);

            return response()->json([
                'message' => 'Otp Code Resend'
            ],Response::HTTP_OK);
        }

        
    }
}
