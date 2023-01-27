<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Facade\Ignition\QueryRecorder\QueryRecorder;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('admin.user_management.role.index');
    }

    public function getData()
    {
        $role = DB::table('roles')
                    ->select(
                        'roles.id',
                        'roles.name as rname',
                        DB::raw('group_concat(permissions.name) as pname')
                    )
                    ->join('role_has_permissions','roles.id','=','role_has_permissions.role_id')
                    ->join('permissions','role_has_permissions.permission_id','=','permissions.id')
                    ->groupBy('role_has_permissions.role_id')
                    ->get();

        return DataTables::of($role)
        ->addIndexColumn()
            ->editColumn('action', function ($role) {
                $return = "<div class=\"btn-group\">";
                if (!empty($role->rname))
                {
                    $return .= "
                            <a href=\"/role/edit/$role->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                            ||
                              <a rel=\"$role->id\" rel1=\"role/destroy\" href=\"javascript:\" style='margin-right: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
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
        $model_array = array();

       $permission =  Permission::select('permissions.*','permission_model.permission_model_name as permission_model_name')
                        ->leftJoin('permission_model', function($join){
                            $join->on('permissions.id','=','permission_model.permission_id');
                        })
                        ->get();

        foreach($permission as $p){
            $model_array[$p->permission_model_name][] = ['name' => $p->name, 'id' => $p->id];
        }

        return view('admin.user_management.role.create', compact('model_array'));
    }

    public function store(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $role = new Role();

                $role->name = $request->name;
                $role->syncPermissions($request->input('permissions'));

                $role->save();

                DB::commit();

                return response()->json([
                    'message' => 'Role store successfil'
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
        $role = Role::findOrFail($id);

        $model_array = array();

        $permission =  Permission::select('permissions.*','permission_model.permission_model_name as permission_model_name')
                         ->leftJoin('permission_model', function($join){
                             $join->on('permissions.id','=','permission_model.permission_id');
                         })
                         ->get();
 
         foreach($permission as $p){
             $model_array[$p->permission_model_name][] = ['name' => $p->name, 'id' => $p->id];
         }

         $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
         ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
         ->all();

        return view('admin.user_management.role.edit', compact('model_array','role','rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        if($request->_method == 'PUT')
        {
            DB::beginTransaction();

            try{

                $role = Role::findOrFail($id);
                $role->name = $request->name;
                $role->update();

                $role->syncPermissions($request->input('permissions'));

                DB::commit();

                return response()->json([
                    'message' => 'Role updated successful'
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
        $role = Role::findOrFail($id);

        DB::table('role_has_permissions')->where('role_id', $id)->delete();

        $role->delete();

        return response()->json([
            'message' => 'Role deleted successful'
        ],Response::HTTP_ACCEPTED);
    }
}
