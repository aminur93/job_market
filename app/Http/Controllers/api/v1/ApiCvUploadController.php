<?php

namespace App\Http\Controllers\api\v1;

use App\CvUpload;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ApiCvUploadController extends Controller
{
    public function index()
    {
        $customer_id = auth('api')->id();

        $cv_upload = CvUpload::where('customer_id', $customer_id)->paginate(10);

        if(empty($cv_upload))
        {
            return response()->json([
                'message' => 'No Data Found'
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'cv_upload' => $cv_upload
            ],Response::HTTP_OK);
        }
    }

    public function view($id)
    {
        $cv = CvUpload::findOrFail($id)->toArray();
        $pdf_path = public_path().'/assets/admin/uploads/cv/'.$cv['cv'];
        return response()->download($pdf_path);
    }

    public function store(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $cv_upload = new CvUpload();

                $cv_upload->customer_id = auth('api')->id();

                $file = $request->file('cv');

                $request->cv->move(public_path().'/assets/admin/uploads/cv/',$file->getClientOriginalName());

                $cv_upload->cv = $file->getClientOriginalName();

                $cv_upload->save();

                DB::commit();

                return response()->json([
                    'message' => 'Cv store successful',
                    'cv' => $cv_upload
                ],Response::HTTP_CREATED);

            }catch(Exception $e){
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
