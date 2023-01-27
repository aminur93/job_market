<?php

namespace App\Http\Controllers\front;

use App\Ads;
use App\AdsCategory;
use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\SendOtp;
use Illuminate\Database\QueryException;

class LoginController extends Controller
{
    public function index()
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        return view('customer_login', compact('all_category','ads_count'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required'
        ]);

        if($request->isMethod('post'))
        {
            $credentials = [
                'phone' => $request->phone,
                'password' => $request->password
            ];

            $customer = Customer::where('phone', $request->phone)->where('deleted_at','=',0)->first();

            $customer_otp = DB::table('customer_otp')->where('customer_id', $customer->id)->first();

            if($customer_otp->otp_code == null)
            {
                if(!Hash::check($request->password, $customer->password))
                {
                    return response()->json([
                        'errors' => 'Wrong credentials'
                    ],Response::HTTP_INTERNAL_SERVER_ERROR);
                }else{
                    if(Auth::guard('customer')->attempt($credentials))
                    {
                        return response()->json([
                            'message' => 'Login successful'
                        ],Response::HTTP_OK);
                    }
                }
            }else{
                return response()->json([
                    'errors' => 'Account is not verified'
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }

           
        }
    }

    public function loginEmail(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if($request->isMethod('post'))
        {
            $credentials = [
                'email' => $request->email,
                'password' => $request->password
            ];

            $customer = Customer::where('email', $request->email)->where('deleted_at','=',0)->first();

            $customer_otp = DB::table('customer_otp')->where('customer_id', $customer->id)->first();

            if($customer_otp->otp_code == null)
            {
                if(!Hash::check($request->password, $customer->password))
                {
                    return response()->json([
                        'errors' => 'Wrong credentials'
                    ],Response::HTTP_INTERNAL_SERVER_ERROR);
                }else{
                    if(Auth::guard('customer')->attempt($credentials))
                    {
                        return response()->json([
                            'message' => 'Login successful'
                        ],Response::HTTP_OK);
                    }
                }
            }else{
                return response()->json([
                    'errors' => 'Account is not verified'
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }

           
        }
    }

    public function customerForgetPassword()
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        return view('customer_forget_password',  compact('all_category','ads_count'));
    }

    public function customerForgetOtpSend(Request $request)
    {
        $phone = $request->phone;

        $customer = Customer::where('phone', $phone)->first();

        $otp_code = rand(1111,9999);

        SendOtp::sendCode($otp_code, $customer->phone);

        return response()->json([
            'message' => 'Otp send successful in your phone'
        ], Response::HTTP_OK);
    }

    public function customerPassUpdate($phone)
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $customer = Customer::where('phone', $phone)->first();

        return view('customer_update_pass', compact('all_category','ads_count','customer'));
    }

    public function customerPassUpdatePhone(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);

        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $customer_id = $request->customer_id;

                $customer = Customer::where('id',$customer_id)->first();

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

    public function customerLogout()
    {
        auth('customer')->logout();

        return redirect('/');
    }
}
