<?php

namespace App\Http\Controllers\api\v1;

use App\AdPricing;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PricingController extends Controller
{
    public function allPricing()
    {
        $all_pricing = AdPricing::where('status','=',1)->latest()->get();

        return response()->json([
            'all_pricing' => $all_pricing
        ],Response::HTTP_OK);
    }
}
