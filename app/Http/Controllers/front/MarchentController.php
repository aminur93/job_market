<?php

namespace App\Http\Controllers\front;

use App\Ads;
use App\AdsCategory;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Image;
use App\SendOtp;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class MarchentController extends Controller
{
    public function marchentRegister()
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $roles = Role::where('name', '!=', 'admin')->latest()->get();

        return view('marchent_register', compact('roles','all_category','ads_count'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|unique:users',
            'password' => 'required|confirmed'
        ]);

        if ($request->isMethod('post')) {
            
            //check if phone number already exists
            $user_phone = User::where('phone', $request->phone)->count();

            if($user_phone > 0)
            {
                return response()->json([
                    'error' => 'Phone number already exists'
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }else{

                //check if user email already exists
                $user_email = User::where('email', $request->email)->count();

                if($user_email > 0)
                {
                    return response()->json([
                        'error' => 'Email number already exists'
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }else{

                    $user = new User();

                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->phone = $request->phone;
                    $user->password = bcrypt($request->password);

                    $user->assignRole($request->role);

                    if($request->terms_conditions == false){
                        $user->terms_conditions = 0;
                    }else{
                        $user->terms_conditions = 1;
                    }
        
                    if($request->hasFile('image')){
        
                        $image_tmp = $request->file('image');
        
                        if($image_tmp->isValid()){
        
                            $image_name=time().'.'.$image_tmp->getClientOriginalExtension();
        
                            $image_path = public_path().'/assets/frontend/upload/merchant/'.$image_name;
        
                            //Resize Image
                            Image::make($image_tmp)->save($image_path);
        
                            $user->profile_image = $image_name;
                        }
                    }

                    $user->save();

                    $otp_code = rand(1111,9999);

                    DB::table('merchent_otp')->insert([
                        'merchant_id' => $user->id,
                        'otp_code' => $otp_code,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    SendOtp::sendCode($otp_code, $request->phone);

                    return response()->json([
                        'message' => 'Merchant register successful',
                        'phone' => $request->phone,
                    ],Response::HTTP_OK);
                }
            }
        }
    }

    public function verify($phone)
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $user = User::where('phone', $phone)->first();

        return view('marchent_otp', compact('user','all_category','ads_count'));
    }

    public function check(Request $request)
    {
        $user = User::where('id', $request->merchant_id)->first();

        $user_otp_code = DB::table('merchent_otp')->where('merchant_id', $user->id)->first();

        if($user_otp_code->otp_code == $request->otp_code)
        {
            DB::table('merchent_otp')->where('merchant_id', $user->id)->update(['otp_code' => null]);

            $user->update(['status' => 1]);

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
