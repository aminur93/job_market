<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SslCommerzPaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'front\HomeController@index')->name('front');

// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout'])->name('example1');
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

Route::get('details/{id}', 'front\HomeController@details')->name('front.details');
Route::get('add_view_count', 'front\HomeController@addViewCount')->name('front.add_view_count');
Route::get('tvc_view_count', 'front\HomeController@tvcViewCount')->name('front.tvc_view_count');

Route::get('all_ads', 'front\HomeController@allAds')->name('front.all_ads');
Route::get('category_ads/{id}', 'front\HomeController@categoryAds')->name('front.category_ads');
Route::get('sub_category_ads/{id}', 'front\HomeController@subCategoryAds')->name('front.sub_category_ads');
Route::get('all_category', 'front\HomeController@allCategory')->name('front.all_category');

Route::get('all_tvc', 'front\HomeController@allTvc')->name('front.all_tvc');
Route::get('tvc/details/{id}', 'front\HomeController@tvcDetails')->name('front.tvc_details');

Route::get('all_location','front\HomeController@allLocation')->name('front.all_location');
Route::get('all_district/{id}','front\HomeController@allDistrict')->name('front.all_district');
Route::get('division_ads/{id}','front\HomeController@divisionAds')->name('front.division_ads');
Route::get('district_ads/{id}','front\HomeController@districtAds')->name('front.district_ads');

Route::get('job_category_list','front\HomeController@jobCategory')->name('front.job_category_list');
Route::get('job_category_list/job/{id}','front\HomeController@categoryJobList')->name('front.job_list');
Route::get('all_job','front\HomeController@allJob')->name('front.all_job');
Route::get('job_details/{id}','front\HomeController@jobDetails')->name('front.job_details');

Route::get('search','front\HomeController@search')->name('search');


Route::get('category_search','front\HomeController@categorySearch')->name('category_search');
Route::get('price_range','front\HomeController@priceRange')->name('price_range');

//sub category search and price range
Route::get('sub_category_search','front\HomeController@subCategorySearch')->name('sub_category_search');
Route::get('sub_category_price_range','front\HomeController@subCategoryPriceRange')->name('sub_category_price_range');
//sub category search and price range

//ads search and price ranche
Route::get('ads_search','front\HomeController@adsSearch')->name('ads_search');
Route::get('ads_price_range','front\HomeController@adsPriceRange')->name('ads_price_range');
//ads search and price ranche

//job search route
Route::get('job_search','front\HomeController@jobSearch')->name('job_search');
//job search route

Route::get('strategy','front\HomeController@Strategy')->name('front.strategy');
Route::get('about','front\HomeController@about')->name('front.about');
Route::get('mission_vission','front\HomeController@missionVission')->name('front.mission_vission');
Route::get('management','front\HomeController@Management')->name('front.management');
Route::get('selling_tips','front\HomeController@SellingTips')->name('front.selling_tips');
Route::get('buy_sell_quick_tip','front\HomeController@buySellQuick')->name('front.buy_sell_quick_tip');
Route::get('pricing_tips','front\HomeController@pricingTips')->name('front.pricing_tips');
Route::get('banner_ads','front\HomeController@bannerAds')->name('front.banner_ads');
Route::get('promote_ads','front\HomeController@promoteAds')->name('front.promote_ads');
Route::get('contact_us','front\HomeController@contactUs')->name('front.contact_us');
Route::post('contact_us/store','front\HomeController@contactUsStore')->name('contact_us.store');
Route::get('privacy_policy','front\HomeController@privacyPolicy')->name('front.privacy_policy');
Route::get('terms_conditions','front\HomeController@termsConditions')->name('front.terms_conditions');
Route::get('safe','front\HomeController@safe')->name('front.safe');
Route::get('faq','front\HomeController@faq')->name('front.faq');
Route::get('sitemap','front\HomeController@siteMap')->name('front.sitemap');
Route::get('refund_policy','front\HomeController@refund_policy')->name('front.refund_policy');
Route::get('bin_no','front\HomeController@bin_no')->name('front.bin_no');

Route::post('subscribe', 'front\HomeController@subscribe')->name('front.subscribe');


//Register route start
Route::get('customer_register','front\RegisterController@index')->name('customer_register');
Route::post('customer_register/store','front\RegisterController@store')->name('customer_register.store');
Route::post('customer_register/get_customer_district','front\RegisterController@getCustomerDistrict')->name('customer_register.get_customer_district');
Route::get('customer_register/otp/{phone}','front\RegisterController@otp')->name('customer_register.otp');
Route::post('customer_register/otp/check','front\RegisterController@check')->name('customer_register.check');
Route::post('customer_register/otp/resend','front\RegisterController@resend')->name('customer_register.resend');
//Register route end

//login route start
Route::get('customer_login','front\LoginController@index')->name('customer_login');
Route::post('customer_login/store','front\LoginController@store')->name('customer_login.store');
Route::post('customer_login/email_login','front\LoginController@loginEmail')->name('customer_login.email_login');
Route::get('customer_logout','front\LoginController@customerLogout')->name('customer_logout');
Route::get('customer_forget_password','front\LoginController@customerForgetPassword')->name('customer_forget_password');
Route::post('customer_forget_otp_send','front\LoginController@customerForgetOtpSend')->name('customer_forget_otp_send');
Route::get('customer_pass_update/{phone}','front\LoginController@customerPassUpdate')->name('customer_pass_update');
Route::post('customer_pass_update_phone','front\LoginController@customerPassUpdatePhone')->name('customer_pass_update_phone');
//login route end

//social login route start
Route::get('social/google', 'social_auth\GoogleController@redirectToGoogle')->name('social.google');
Route::get('social/google/callback', 'social_auth\GoogleController@handleGoogleCallback');

Route::get('social/facebook', 'social_auth\FacebookController@redirectToFacebook')->name('social.facebook');
Route::get('social/facebook/callback', 'social_auth\FacebookController@handleFacebookCallback');
//social login route end



//customer all route start
Route::group(['middleware' => 'customer', 'namespace' => 'front'], function(){

    //customer delete account
    Route::get('customer_delete_account','CustomerController@deleteAccount')->name('customer_delete_account');
    
    //customer dashboard route start
    Route::get('customer_dashboard','CustomerController@index')->name('customer_dashboard');
    
    Route::get('customer_profile_setting','CustomerController@profileSetting')->name('customer_profile_setting');
    Route::post('customer_profile_setting/getDistrict','CustomerController@customerGetDistrict')->name('customer_profile_setting.getDistrict');
    Route::post('customer_profile_setting/customer_profile_update','CustomerController@customerProfileUpdate')->name('customer_profile_setting.customer_profile_update');
    Route::put('customer_profile_setting/customer_password_update','CustomerController@customerPasswordUpdate')->name('customer_profile_setting.customer_password_update');
    Route::get('customer_professonal','CustomerController@professonal')->name('customer_professonal');
    Route::get('customer_professonal/create','CustomerController@create')->name('customer_professonal.create');
    Route::get('customer_professonal/available','CustomerController@available')->name('customer_professonal.available');


    Route::post('customer_professonal/store','CustomerController@store')->name('customer_professonal.store');
    Route::post('customer_profile_update','CustomerController@profileUpdate')->name('customer_profile_update');
    Route::post('customer_skill_update','CustomerController@skillUpdate')->name('customer_skill_update');
    Route::post('customer_experience_update','CustomerController@experienceUpdate')->name('customer_experience_update');
    Route::post('customer_education_update','CustomerController@educationUpdate')->name('customer_education_update');
    Route::post('customer_certification_update','CustomerController@certificateUpdate')->name('customer_certification_update');
    Route::post('customer_link_update','CustomerController@linkUpdate')->name('customer_link_update');
    Route::post('customer_cv_update','CustomerController@cvUpdate')->name('customer_cv_update');
    Route::delete('customer_professonal/skill_delete/{id}','CustomerController@skillDelete')->name('customer_professonal.skill_delete');
    Route::get('customer_ads','CustomerController@customerAds')->name('customer_ads');
    //customer dashboard route start

    //customer ads route start
    Route::get('customer_ads','CustomerAdsController@index')->name('customer_ads');
    Route::get('customer_ads/getData','CustomerAdsController@getData')->name('customer_ads.getData');
    Route::get('customer_ads/create','CustomerAdsController@create')->name('customer_ads.create');
    Route::post('customer_ads/store','CustomerAdsController@store')->name('customer_ads.store');
    Route::get('customer_ads/edit/{id}','CustomerAdsController@edit')->name('customer_ads.edit');
    Route::put('customer_ads/update/{id}','CustomerAdsController@update')->name('customer_ads.update');
    Route::delete('customer_ads/destroy/{id}','CustomerAdsController@destroy')->name('customer_ads.destroy');
    Route::post('customer_ads/get_district','CustomerAdsController@getDistrict')->name('customer_ads.get_district');
    Route::get('customer_ads/get_category_value', 'CustomerAdsController@getCategoryValue')->name('customer_ads.get_category_value');
    //customer ads route end

    //customer ads banner route start
    Route::get('customer_ads_banner', 'CustomerAdsBannerController@index')->name('customer_ads_banner');
    Route::get('customer_ads_banner/getData', 'CustomerAdsBannerController@getData')->name('customer_ads_banner.getData');
    Route::get('customer_ads_banner/create', 'CustomerAdsBannerController@create')->name('customer_ads_banner.create');
    Route::post('customer_ads_banner/store', 'CustomerAdsBannerController@store')->name('customer_ads_banner.store');
    Route::get('customer_ads_banner/edit/{id}', 'CustomerAdsBannerController@edit')->name('customer_ads_banner.edit');
    Route::put('customer_ads_banner/update/{id}', 'CustomerAdsBannerController@update')->name('customer_ads_banner.update');
    Route::delete('customer_ads_banner/destroy/{id}', 'CustomerAdsBannerController@destroy')->name('customer_ads_banner.destroy');
    //customer ads banner route end

     //customer tvc route start
     Route::get('customer_tvc', 'CustomerTvcController@index')->name('customer_tvc');
     Route::get('customer_tvc/getData', 'CustomerTvcController@getData')->name('customer_tvc.getData');
     Route::get('customer_tvc/create', 'CustomerTvcController@create')->name('customer_tvc.create');
     Route::post('customer_tvc/store', 'CustomerTvcController@store')->name('customer_tvc.store');
     Route::get('customer_tvc/edit/{id}', 'CustomerTvcController@edit')->name('customer_tvc.edit');
     Route::put('customer_tvc/update/{id}', 'CustomerTvcController@update')->name('customer_tvc.update');
     Route::delete('customer_tvc/destroy/{id}', 'CustomerTvcController@destroy')->name('customer_tvc.destroy');
     //customer tvc route end

     //customer tvc route start
     Route::get('customer_job', 'CustomerJobController@index')->name('customer_job');
     Route::get('customer_job/getData', 'CustomerJobController@getData')->name('customer_job.getData');
     Route::get('customer_job/create', 'CustomerJobController@create')->name('customer_job.create');
     Route::post('customer_job/store', 'CustomerJobController@store')->name('customer_job.store');
     Route::get('customer_job/edit/{id}', 'CustomerJobController@edit')->name('customer_job.edit');
     Route::put('customer_job/update/{id}', 'CustomerJobController@update')->name('customer_job.update');
     Route::delete('customer_job/destroy/{id}', 'CustomerJobController@destroy')->name('customer_job.destroy');

     Route::get('customer_job/cv_bank','CustomerJobController@cvBank')->name('customer_job.cv_bank');
     Route::get('customer_job/cv_bank_download/{id}','CustomerJobController@cvBankDownload')->name('customer_job.cv_download');
     //customer tvc route end

     //customer cv upload route start
     Route::get('customer_cv_upload','CustomerCvUploadController@index')->name('customer_cv_upload');
     Route::get('customer_cv_upload/create','CustomerCvUploadController@create')->name('customer_cv_upload.create');
     Route::get('customer_cv_upload/view/{id}','CustomerCvUploadController@view')->name('customer_cv_upload.view');
     Route::post('customer_cv_upload/store','CustomerCvUploadController@store')->name('customer_cv_upload.store');
     Route::delete('customer_cv_upload/destroy/{id}','CustomerCvUploadController@destroy')->name('customer_cv_upload.destroy');
     //customer cv upload route end

    Route::get('apply_job/{id}','CustomerController@applyJob')->name('apply_job');
    Route::post('apply_job/store','CustomerController@applyJobStore')->name('apply_job.store');
});
//customer all route end

//merchent route start
Route::get('merchent_register','front\MarchentController@marchentRegister')->name('marchent_register');
Route::post('merchent_register/store','front\MarchentController@store')->name('marchent_register.store');
Route::get('merchent_register/verify/{phone}','front\MarchentController@verify')->name('marchent_register.verify');
Route::post('merchent_register/verify/check','front\MarchentController@check')->name('marchent_register.check');
//merchent route end

Auth::routes();

Route::group(['middleware' => ['auth'], 'namespace' => 'admin'], function () {

    //admin dashboard routes
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    //subscriber route start
    Route::get('subscriber','SubscribeController@index')->name('subscriber');
    Route::get('subscriber/getData','SubscribeController@getData')->name('subscriber.getData');
    //subscriber route end

    //user management route start
    Route::get('permission','PermissionController@index')->name('permission')->middleware('role:admin');
    Route::get('permission/getData','PermissionController@getData')->name('permission.getData')->middleware('role:admin');
    Route::get('permission/create','PermissionController@create')->name('permission.create')->middleware('role:admin');
    Route::post('permission/store','PermissionController@store')->name('permission.store')->middleware('role:admin');
    Route::get('permission/edit/{id}','PermissionController@edit')->name('permission.edit')->middleware('role:admin');
    Route::put('permission/update/{id}','PermissionController@update')->name('permission.update')->middleware('role:admin');
    Route::delete('permission/destroy/{id}','PermissionController@destroy')->name('permission.destroy')->middleware('role:admin');

    Route::get('role', 'RoleController@index')->name('role')->middleware('role:admin');
    Route::get('role/getData', 'RoleController@getData')->name('role.getData')->middleware('role:admin');
    Route::get('role/create', 'RoleController@create')->name('role.create')->middleware('role:admin');
    Route::post('role/store', 'RoleController@store')->name('role.store')->middleware('role:admin');
    Route::get('role/edit/{id}', 'RoleController@edit')->name('role.edit')->middleware('role:admin');
    Route::put('role/update/{id}', 'RoleController@update')->name('role.update')->middleware('role:admin');
    Route::delete('role/destroy/{id}', 'RoleController@destroy')->name('role.destroy')->middleware('role:admin');

    Route::get('user','UserController@index')->name('user')->middleware('role:admin');
    Route::get('user/getData','UserController@getData')->name('user.getData')->middleware('role:admin');
    Route::get('user/create','UserController@create')->name('user.create')->middleware('role:admin');
    Route::post('user/store','UserController@store')->name('user.store')->middleware('role:admin');
    Route::get('user/edit/{id}','UserController@edit')->name('user.edit')->middleware('role:admin');
    Route::put('user/update/{id}','UserController@update')->name('user.update')->middleware('role:admin');
    Route::delete('user/destroy/{id}','UserController@destroy')->name('user.destroy')->middleware('role:admin');
    Route::get('user/status_change/{id}','UserController@statusChange')->name('user.status_change')->middleware('role:admin');
    //user management route end

    //admin profile routes start
    Route::get('profile','AdminController@index')->name('profile')->middleware('role:admin|marchent');
    Route::put('profile/update','AdminController@profileUpdate')->name('profile.update')->middleware('role:admin|marchent');
    Route::get('change_password','AdminController@changePassword')->name('change_password')->middleware('role:admin|marchent');
    Route::put('change_password/update','AdminController@changePasswordUpdate')->name('change_password.update')->middleware('role:admin|marchent');
    //admin profile routes end

    //ads route start
    Route::get('ads','AdsController@index')->name('ads')->middleware('role:admin|marchent');
    Route::get('ads/getData','AdsController@getData')->name('ads.getData')->middleware('role:admin|marchent');
    Route::get('ads/create','AdsController@create')->name('ads.create')->middleware('role:admin|marchent');
    Route::post('ads/store','AdsController@store')->name('ads.store')->middleware('role:admin|marchent');
    Route::get('ads/edit/{id}','AdsController@edit')->name('ads.edit')->middleware('role:admin|marchent');
    Route::put('ads/update/{id}','AdsController@update')->name('ads.update')->middleware('role:admin|marchent');
    Route::delete('ads/destroy/{id}','AdsController@destroy')->name('ads.destroy')->middleware('role:admin|marchent');
    Route::get('ads/approve/{id}','AdsController@approve')->name('ads.approve')->middleware('role:admin');
    Route::get('ads/details/{id}','AdsController@details')->name('ads.details')->middleware('role:admin|marchent');
    Route::post('ads/get_district','AdsController@getDistrict')->name('ads.get_district')->middleware('role:admin|marchent');
    Route::get('ads/get_category_value', 'AdsController@getCategoryValue')->name('ads.get_category_value');
    //ads route end

    //job route start
    Route::get('job', 'JobController@index')->name('job')->middleware('role:admin|marchent');
    Route::get('job/getData', 'JobController@getData')->name('job.getData')->middleware('role:admin|marchent');
    Route::get('job/create', 'JobController@create')->name('job.create')->middleware('role:admin|marchent');
    Route::post('job/store', 'JobController@store')->name('job.store')->middleware('role:admin|marchent');
    Route::get('job/edit/{id}', 'JobController@edit')->name('job.edit')->middleware('role:admin|marchent');
    Route::put('job/update/{id}', 'JobController@update')->name('job.update')->middleware('role:admin|marchent');
    Route::delete('job/destroy/{id}', 'JobController@destroy')->name('job.destroy')->middleware('role:admin|marchent');
    Route::get('job/approve/{id}', 'JobController@approve')->name('job.approve')->middleware('role:admin');
    Route::get('job/details/{id}', 'JobController@details')->name('job.details')->middleware('role:admin|marchent');
    //job route end

    //cv uploads route start
    Route::get('cv_upload','CvUploadController@index')->name('cv_upload');
    Route::get('cv_upload/view/{id}','CvUploadController@view')->name('cv_upload.view');
    Route::post('cv_upload/store','CvUploadController@store')->name('cv_upload.store');
    Route::delete('cv_upload/destroy/{id}','CvUploadController@destroy')->name('cv_upload.destroy');
    //cv uploads route end

    //job category route start
    Route::get('job_category','JobCategoryController@index')->name('job_category');
    Route::get('job_category/getData','JobCategoryController@getData')->name('job_category.getData');
    Route::get('job_category/create','JobCategoryController@create')->name('job_category.create');
    Route::post('job_category/store','JobCategoryController@store')->name('job_category.store');
    Route::get('job_category/edit/{id}','JobCategoryController@edit')->name('job_category.edit');
    Route::put('job_category/update/{id}','JobCategoryController@update')->name('job_category.update');
    Route::delete('job_category/destroy/{id}','JobCategoryController@destroy')->name('job_category.destroy');
    //job category route end

    //tvctv and auto tv route start
    Route::get('tvc','TvsController@index')->name('tvc');
    Route::get('tvc/getData','TvsController@getData')->name('tvc.getData');
    Route::get('tvc/create','TvsController@create')->name('tvc.create');
    Route::post('tvc/store','TvsController@store')->name('tvc.store');
    Route::get('tvc/edit/{id}','TvsController@edit')->name('tvc.edit');
    Route::put('tvc/update/{id}','TvsController@update')->name('tvc.update');
    Route::delete('tvc/destroy/{id}','TvsController@destroy')->name('tvc.destroy');
    Route::get('tvc/approve/{id}','TvsController@approve')->name('tvc.approve');

    Route::get('auto_tv','AutoTvController@index')->name('auto_tv');
    Route::get('auto_tv/getData','AutoTvController@getData')->name('auto_tv.getData');
    Route::get('auto_tv/create','AutoTvController@create')->name('auto_tv.create');
    Route::post('auto_tv/store','AutoTvController@store')->name('auto_tv.store');
    Route::get('auto_tv/edit/{id}','AutoTvController@edit')->name('auto_tv.edit');
    Route::put('auto_tv/update/{id}','AutoTvController@update')->name('auto_tv.update');
    Route::delete('auto_tv/destroy/{id}','AutoTvController@destroy')->name('auto_tv.destroy');
    Route::get('auto_tv/approve/{id}','AutoTvController@approve')->name('auto_tv.approve');
    //tvc and auto tv route end

    //ads banner route start
    Route::get('ads_banner', 'AdsBannerController@index')->name('ads_banner');
    Route::get('ads_banner/getData', 'AdsBannerController@getData')->name('ads_banner.getData');
    Route::get('ads_banner/create', 'AdsBannerController@create')->name('ads_banner.create');
    Route::post('ads_banner/store', 'AdsBannerController@store')->name('ads_banner.store');
    Route::get('ads_banner/edit/{id}', 'AdsBannerController@edit')->name('ads_banner.edit');
    Route::put('ads_banner/update/{id}', 'AdsBannerController@update')->name('ads_banner.update');
    Route::delete('ads_banner/destroy/{id}', 'AdsBannerController@destroy')->name('ads_banner.destroy');
    Route::get('ads_banner/status_change/{id}', 'AdsBannerController@statusChange')->name('ads_banner.status_change');

    //ads banner route end

    //ads banner  category route start
    Route::get('ads_banner_category','AdsBannerCategoryController@index')->name('ads_banner_category');
    Route::get('ads_banner_category/getData','AdsBannerCategoryController@getData')->name('ads_banner_category.getData');
    Route::get('ads_banner_category/create','AdsBannerCategoryController@create')->name('ads_banner_category.create');
    Route::post('ads_banner_category/store','AdsBannerCategoryController@store')->name('ads_banner_category.store');
    Route::get('ads_banner_category/edit/{id}','AdsBannerCategoryController@edit')->name('ads_banner_category.edit');
    Route::put('ads_banner_category/update/{id}','AdsBannerCategoryController@update')->name('ads_banner_category.update');
    Route::delete('ads_banner_category/destroy/{id}','AdsBannerCategoryController@destroy')->name('ads_banner_category.destroy');
    //ads banner  category route end

    //ads category route start
    Route::get('category','AdsCategoryController@index')->name('category');
    Route::get('category/getData','AdsCategoryController@getData')->name('category.getData');
    Route::get('category/create','AdsCategoryController@create')->name('category.create');
    Route::post('category/store','AdsCategoryController@store')->name('category.store');
    Route::get('category/edit/{id}','AdsCategoryController@edit')->name('category.edit');
    Route::put('category/update/{id}','AdsCategoryController@update')->name('category.update');
    Route::delete('category/destroy/{id}','AdsCategoryController@destroy')->name('category.destroy');
    //ads category route end

    //ads sub category route start
    Route::get('sub_category','AdsSubCategoryController@index')->name('sub_category');
    Route::get('sub_category/getData','AdsSubCategoryController@getData')->name('sub_category.getData');
    Route::get('sub_category/create','AdsSubCategoryController@create')->name('sub_category.create');
    Route::post('sub_category/store','AdsSubCategoryController@store')->name('sub_category.store');
    Route::get('sub_category/edit/{id}','AdsSubCategoryController@edit')->name('sub_category.edit');
    Route::put('sub_category/update/{id}','AdsSubCategoryController@update')->name('sub_category.update');
    Route::delete('sub_category/destroy/{id}','AdsSubCategoryController@destroy')->name('sub_category.destroy');
    //ads sub category route end

    //ads pricing route start
    Route::get('ads_price','AdPricingController@index')->name('ads_price');
    Route::get('ads_price/getData','AdPricingController@getData')->name('ads_price.getData');
    Route::get('ads_price/create','AdPricingController@create')->name('ads_price.create');
    Route::post('ads_price/store','AdPricingController@store')->name('ads_price.store');
    Route::get('ads_price/edit/{id}','AdPricingController@edit')->name('ads_price.edit');
    Route::put('ads_price/update/{id}','AdPricingController@update')->name('ads_price.update');
    Route::delete('ads_price/destroy/{id}','AdPricingController@destroy')->name('ads_price.destroy');
    Route::get('ads_price/status_change/{id}','AdPricingController@statusChange')->name('ads_price.status_change');
    //ads pricing route end

    //Division route start
    Route::get('division', 'DivisionController@index')->name('division');
    Route::get('division/getData', 'DivisionController@getData')->name('division.getData');
    Route::get('division/create', 'DivisionController@create')->name('division.create');
    Route::post('division/store', 'DivisionController@store')->name('division.store');
    Route::get('division/edit/{id}', 'DivisionController@edit')->name('division.edit');
    Route::put('division/update/{id}', 'DivisionController@update')->name('division.update');
    Route::delete('division/destroy/{id}', 'DivisionController@destroy')->name('division.destroy');
    //Division route end

    //District route start
    Route::get('district', 'DistrictController@index')->name('district');
    Route::get('district/getData', 'DistrictController@getData')->name('district.getData');
    Route::get('district/create', 'DistrictController@create')->name('district.create');
    Route::post('district/store', 'DistrictController@store')->name('district.store');
    Route::get('district/edit/{id}', 'DistrictController@edit')->name('district.edit');
    Route::put('district/update/{id}', 'DistrictController@update')->name('district.update');
    Route::delete('district/destroy/{id}', 'DistrictController@destroy')->name('district.destroy');
    //District route end
});


