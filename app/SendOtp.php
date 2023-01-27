<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class SendOtp extends Model{

    public static function sendCode($otp_code, $phone){

        $new_phone = "88".$phone;

        $postData = array(
            'Access-Control-Allow-Origin' => "*",
            'Access-Control-Allow-Headers' => "Content-Type, application/x-www-form-urlencoded",
            'Access-Control-Allow-Methods' => "POST, GET, OPTIONS"
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://www.bangladeshsms.com/smsapi?api_key=C2009207622092624e3bb2.98441482&type=text&contacts=$new_phone&senderid=PMARKET.COM&msg=Your%20one%20time%20login%20otp%20is $otp_code",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 100,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HEADER => $postData,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_FOLLOWLOCATION => true
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        if ($err){
            echo $err;
        }

        //echo $response;

        return $otp_code;
    }

}