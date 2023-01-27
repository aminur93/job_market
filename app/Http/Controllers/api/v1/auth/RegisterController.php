<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Customer;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SendOtp;
use Illuminate\Http\Response;
use Image;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|unqiue:customers',
            'password' => 'required|confirmed'
        ]);

        if($request->isMethod('post'))
        {
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

            $otp_code = rand(1111,9999);

            if($otp_code != null && $request->phone != null){

                SendOtp::sendCode($otp_code, $request->phone);
                $customer->save();
            }

            $customer_id =  DB::getPdo()->lastInsertId();

            DB::table('customer_otp')->insert([
                'customer_id' => $customer_id,
                'otp_code' => $otp_code,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            return response()->json([
                'message' => "Customer Store successful",
                'phone' => $request->phone
            ],Response::HTTP_OK);
        }
    }

    public function otpCheck(Request $request)
    {
        $phone = $request->phone;

        $customer = Customer::where('phone', $phone)->first();

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
}
