<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $loginField = request()->input('email');

        $credentials = null;

        if ($loginField !== null) {
            $loginType = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

            request()->merge([$loginType => $loginField]);

            $customer = Customer::where('email', $loginField)->orwhere('phone', $loginField)->first();

            $customer_otp = DB::table('customer_otp')->where('customer_id', $customer->id)->first();

            if ($customer_otp->otp_code == null) {
                $credentials = request([$loginType, 'password']);
            } else {
                return response()->json(['errors' => ['result' => 'Your account is not active']], 401);
            }
        }else {
            return response()->json(['errors' => ['result' => 'Something went wrong']], 401);
        }

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['result' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Logout successful'
        ], Response::HTTP_OK);
    }

    public function me()
    {
        $customer_id = auth('api')->id();
        
        $customer = Customer::select('id','name','email','phone','address','created_at','updated_at')->where('id',$customer_id)->first();

        return response()->json([
            'user' => $customer
        ],Response::HTTP_OK);
    }

    public function respondWithToken($token)
    {
        $customer_id = auth('api')->id();

        $customer = Customer::select('id','name','email','phone','address','created_at','updated_at')->where('id',$customer_id)->first();

        return response()->json([
            'user' => $customer,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
