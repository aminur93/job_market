<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function index()
    {
        return view('admin.user_management.permission.index');
    }

    public function getData()
    {
        $permission = Permission::select('permissions.*','permission_model.permission_model_name as permission_model_name')
                        ->leftJoin('permission_model', function($join){
                            $join->on('permissions.id','=','permission_model.permission_id');
                        })
                        ->get();

        return DataTables::of($permission)
        ->addIndexColumn()
            ->editColumn('action', function ($permission) {
                $return = "<div class=\"btn-group\">";
                if (!empty($permission->name))
                {
                    $return .= "
                            <a href=\"/permission/edit/$permission->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                            ||
                              <a rel=\"$permission->id\" rel1=\"permission/destroy\" href=\"javascript:\" style='margin-right: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
                                  ";
                }
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'action'
            ])
            ->make(true);
    }

    public function create()
    {
        return view('admin.user_management.permission.create');
    }

    public function store(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $permission = new Permission();

                $permission->name = $request->name;

                $permission->save();

                $permission_id = DB::getPdo()->lastInsertId();

                DB::table('permission_model')->insert([
                    'permission_id' => $permission_id,
                    'permission_model_name' => $request->permission_model_name,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();

                return response()->json([
                    'message' => 'Pemission store successful'
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

    public function edit($id)
    {
        $permission = Permission::select('permissions.*','permission_model.permission_model_name as permission_model_name')
                        ->leftJoin('permission_model', function($join){
                            $join->on('permissions.id','=','permission_model.permission_id');
                        })
                        ->where('permissions.id',$id)
                        ->first();
        return view('admin.user_management.permission.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        if($request->_method == 'PUT')
        {
            DB::beginTransaction();

            try{

                $permission = Permission::findOrFail($id);

                $permission->name = $request->name;

                $permission->save();

                DB::table('permission_model')->where('permission_id', $id)->update([
                    'permission_id' => $permission->id,
                    'permission_model_name' => $request->permission_model_name,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                DB::commit();

                return response()->json([
                    'message' => 'Permission update successful'
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

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        DB::table('permission_model')->where('permission_id', $id)->delete();

        $permission->delete();

        return response()->json([
            'message' => 'Permission deleted successful'
        ],Response::HTTP_OK);
    }
}
