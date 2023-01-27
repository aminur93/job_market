<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.profile.profile');
    }

    public function profileUpdate(Request $request)
    {
        if($request->_method == 'PUT')
        {
            DB::beginTransaction();

            try{

                $user_id = Auth::id();

                $user = User::findOrFail($user_id);

                $user->name = $request->name;
                $user->email = $request->email;

                if($request->hasFile('profile_image')){

                    $image_tmp = $request->file('profile_image');

                    if($image_tmp->isValid()){

                        $image_name=time().'.'.$image_tmp->getClientOriginalExtension();

                        $original_image_path = public_path().'/assets/admin/uploads/user/original/'.$image_name;
                        $large_image_path = public_path().'/assets/admin/uploads/user/large/'.$image_name;
                        $medium_image_path = public_path().'/assets/admin/uploads/user/medium/'.$image_name;
                        $small_image_path = public_path().'/assets/admin/uploads/user/small/'.$image_name;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                    }
                }else{
                    
                    $image_name = $request->current_image;
                    
                }

                $user->profile_image = $image_name;

                $user->save();

                DB::commit();

                return response()->json([
                    'message' => 'User updated successful'
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

    public function changePassword()
    {
        return view('admin.profile.change_password');
    }

    public function changePasswordUpdate(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);

        if($request->_method == 'PUT')
        {
            DB::beginTransaction();

            try{

                $user_id = Auth::id();

                $user = User::findOrFail($user_id);

                $user->password = bcrypt($request->password);

                $user->save();

                DB::commit();

                return response()->json([
                    'message' => 'Password change successful'
                ],Response::HTTP_OK);

            }catch(QueryException $e){

                DB::rollBack();

                $error = $e->getMessage();

                return response()->json([
                    'error' => $error
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
