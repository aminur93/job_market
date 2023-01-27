<?php

namespace App\Http\Controllers\front;

use App\Ads;
use App\AdsCategory;
use App\Customer;
use App\CvUpload;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerCvUploadController extends Controller
{
    public function index()
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $id = Auth::guard('customer')->id();

        $customer = Customer::findOrFail($id);

        $cv = CvUpload::where('customer_id', $id)->latest()->get();

        return view('customer.cv_upload.index', compact('all_category','ads_count','customer','cv'));
    }

    public function view($id)
    {
        $cv = CvUpload::findOrFail($id)->toArray();
        $pdf_path = public_path().'/assets/admin/uploads/cv/'.$cv['cv'];
        return response()->download($pdf_path);
    }

    public function create()
    {
        $all_category = AdsCategory::latest()->get();

        $ads_count = Ads::count();

        $id = Auth::guard('customer')->id();

        $customer = Customer::findOrFail($id);

        return view('customer.cv_upload.create', compact('all_category','ads_count','customer'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cv' => 'max:5120'
        ]);

        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $cv_upload = new CvUpload();

                $cv_upload->customer_id = Auth::guard('customer')->id();

                $file = $request->file('cv');

                $request->cv->move(public_path().'/assets/admin/uploads/cv/',$file->getClientOriginalName());

                $cv_upload->cv = $file->getClientOriginalName();

                $cv_upload->save();

                DB::commit();

                return response()->json([
                    'message' => 'Cv store successful',
                    'cv' => $cv_upload
                ],Response::HTTP_CREATED);

            }catch(QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return response()->json([
                    'error' => $error
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function destroy($id)
    {
        $cv_upload = CvUpload::findOrFail($id);

        if($cv_upload->cv != null)
        {
            $pdf_path = public_path().'/assets/admin/uploads/cv/'.$cv_upload->cv;

            unlink($pdf_path);

            $cv_upload->delete();
        }else{
            $cv_upload->delete();
        }

        return response()->json([
            'message' => 'Cv deleted successful'
        ],Response::HTTP_OK);
    }
}
