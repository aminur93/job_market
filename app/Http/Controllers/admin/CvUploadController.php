<?php

namespace App\Http\Controllers\admin;

use App\CvUpload;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class CvUploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cv_upload-list|cv_upload-create|cv_upload-delete', ['only' => ['index','store']]);
        $this->middleware('permission:cv_upload-create', ['only' => ['create','store']]);
        $this->middleware('permission:cv_upload-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $cv = CvUpload::where('user_id', Auth::id())->latest()->get();

        return view('admin.cv_upload.index', compact('cv'));
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

                $cv_upload->user_id = Auth::id();

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
