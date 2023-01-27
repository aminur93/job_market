<?php

namespace App\Http\Controllers\social_auth;

use App\Customer;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
    
            $user =  Socialite::driver('facebook')->user();
     
            $finduser = Customer::where('provider_id', $user->id)->where('deleted_at','=',0)->first();

            if($finduser){
     
                Auth::guard('customer')->login($finduser);
                return redirect('/customer_dashboard');
                
            }else{
                $new_user = Customer::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'provider_id'=> $user->id,
                    'status' => 1,
                ]);
    
                Auth::guard('customer')->login($new_user);
                return redirect('/customer_dashboard');
                
            }
    
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
