<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//auth route api start
Route::post('register','api\v1\auth\RegisterController@store')->name('register');
Route::post('otp/check','api\v1\auth\RegisterController@otpCheck')->name('otp.check');

Route::post('login','api\v1\auth\LoginController@login')->name('login');
Route::post('logout','api\v1\auth\LoginController@logout')->name('logout');
//auth route api end

Route::group(['middleware' => 'auth:api'], function(){

    Route::get('me','api\v1\auth\LoginController@me')->name('me');

    //category route start
    Route::get('category','api\v1\CategoryController@index')->name('category');
    Route::get('all_category','api\v1\CategoryController@allCategory')->name('all_category');
    Route::get('category/product/{id}','api\v1\CategoryController@categoryProduct')->name('category.product');
    Route::post('category/search','api\v1\CategoryController@categorySearch')->name('category.search');
    //category route end

    //ads route start
    Route::get('popular_ads','api\v1\AdsController@popularAds')->name('popular_ads');
    Route::get('all_popular_ads','api\v1\AdsController@allPopularAds')->name('all_popular_ads');
    Route::get('recent_ads','api\v1\AdsController@recentAds')->name('recent_ads');
    Route::get('all_recent_ads','api\v1\AdsController@allRecentAds')->name('all_recent_ads');
    Route::get('ads_details/{id}','api\v1\AdsController@adsDetails')->name('ads_details');
    Route::post('ads_search','api\v1\AdsController@adsSearch')->name('ads_search');

    Route::get('ads','api\v1\AdsController@index')->name('ads');
    Route::post('ads/getSubcategory','api\v1\AdsController@getSubcategory')->name('ads.getSubcategory');
    Route::post('ads/getDistrict','api\v1\AdsController@getDistrict')->name('ads.getDistrict');
    Route::post('ads/store','api\v1\AdsController@store')->name('store');
    Route::get('ads/edit/{id}','api\v1\AdsController@edit')->name('edit');
    Route::post('ads/update/{id}','api\v1\AdsController@update')->name('update');
    Route::delete('ads/destroy/{id}','api\v1\AdsController@destroy')->name('destroy');
    //ads route end

    //banner route start
    Route::get('banner','api\v1\ApiAdsBannerController@index')->name('banner');
    Route::get('banner/getCategory','api\v1\ApiAdsBannerController@getCategory')->name('banner.getCategory');
    Route::post('banner/store','api\v1\ApiAdsBannerController@store')->name('banner.store');
    Route::get('banner/edit/{id}','api\v1\ApiAdsBannerController@edit')->name('banner.edit');
    Route::post('banner/update/{id}','api\v1\ApiAdsBannerController@update')->name('banner.update');
    Route::delete('banner/destroy/{id}','api\v1\ApiAdsBannerController@destroy')->name('banner.destroy');
    //banner route end

    //location route start
    Route::get('division_ads','api\v1\LocationController@adsDivision')->name('division_ads');
    Route::get('all_division','api\v1\LocationController@allDivision')->name('all_division');
    Route::get('all_district/{id}','api\v1\LocationController@allDistrict')->name('all_district');
    Route::get('all_division_ads/{id}','api\v1\LocationController@allDivisionAds')->name('all_division_ads');
    Route::get('all_district_ads/{id}','api\v1\LocationController@allDistrictAds')->name('all_district_ads');
    //location route end

    //pricing route start
    Route::get('all_pricing','api\v1\PricingController@allPricing')->name('all_pricing');
    //pricing route end

    //tvc route start
    Route::get('tvc','api\v1\TvcController@getTvc')->name('tvc');
    Route::get('all_tvc','api\v1\TvcController@getAllTvc')->name('all_tvc');
    Route::get('tvc_details/{id}','api\v1\TvcController@getDetailsTvc')->name('tvc_details');

    Route::get('tvc/all_customer_tvc','api\v1\TvcController@index');
    Route::post('tvc/store','api\v1\TvcController@store');
    Route::get('tvc/edit/{id}','api\v1\TvcController@edit');
    Route::post('tvc/update/{id}','api\v1\TvcController@update');
    Route::delete('tvc/destroy/{id}','api\v1\TvcController@destroy');
    //tvc route end

    //job route start
    Route::get('job_category','api\v1\JobController@jobCategory')->name('job_category');
    Route::get('job_category/job/{id}','api\v1\JobController@categoryJobList')->name('job_category.job');
    Route::get('all_job','api\v1\JobController@allJobList')->name('all_job');
    Route::get('job_details/{id}','api\v1\JobController@jobDetails')->name('job_details');

    Route::get('job','api\v1\JobController@index')->name('job');
    Route::post('job/store','api\v1\JobController@store')->name('job.store');
    Route::get('job/edit/{id}','api\v1\JobController@edit')->name('job.edit');
    Route::post('job/update/{id}','api\v1\JobController@update')->name('job.update');
    Route::delete('job/destroy/{id}','api\v1\JobController@destroy')->name('job.destroy');
    //job route end

    //cv upload route start
    Route::get('cv_upload','api\v1\ApiCvUploadController@index');
    Route::get('cv_upload/view/{id}','api\v1\ApiCvUploadController@view');
    Route::post('cv_upload/store','api\v1\ApiCvUploadController@store');
    Route::delete('cv_upload/destroy/{id}','api\v1\ApiCvUploadController@destroy');
    //cv upload route end
});
