<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        return view('admin.user_management.user.index');
    }

    public function getData()
    {
        $user = DB::table('users')
            ->select(
                'users.id as id',
                'users.name as name',
                'users.email as email',
                'users.phone as phone',
                'users.status as status',
                'roles.name as role_name'
            )
            ->leftJoin('model_has_roles','users.id','=','model_has_roles.model_id')
            ->leftJoin('roles','model_has_roles.role_id','=','roles.id')
            ->where('users.id','!=',Auth::id())
            ->orderBy('users.id','desc')
            ->get();

        return DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('status',function ($user){
                if($user->status == 0)
                {

                    return '<div>
                            <label class="switch patch">
                                <input type="checkbox" class="status_toggle" data-value="'.$user->id.'" id="status_change" value="'.$user->id.'">
                                <span class="slider"></span>
                            </label>
                          </div>';
                }else{
                    return '<div>
                        <label class="switch patch">
                            <input type="checkbox" id="status_change"  class="status_toggle" data-value="'.$user->id.'"  value="'.$user->id.'" checked>
                            <span class="slider"></span>
                        </label>
                      </div>';
                }

            })
            ->editColumn('action', function ($user) {
                $return = "<div class=\"btn-group\">";
                if (!empty($user->name))
                {
                    $return .= "
                      <div class=\"btn-group\">
                            <a href=\"/user/edit/$user->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                            ||
                            <a rel=\"$user->id\" rel1=\"user/destroy\" href=\"javascript:\" style='margin-right: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
                      </div>


                             ";
                }
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'action','status'
            ])
            ->make(true);
    }

    public function create()
    {
        $roles = Role::latest()->get();
        return view('admin.user_management.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        if($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                $user = new User();

                $user->name = $request->name;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->password = bcrypt($request->password);

                $user->assignRole($request->role);

                $user->save();

                DB::commit();

                return response()->json([
                    'message' => 'User store successful'
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
        $user = DB::table('users')
                ->select(
                    'users.id',
                    'users.name as name',
                    'users.email as email',
                    'users.phone as phone',
                    'model_has_roles.role_id'
                )
                ->leftJoin('model_has_roles','users.id','=','model_has_roles.model_id')
                ->leftJoin('roles','model_has_roles.role_id','=','roles.id')
                ->where('users.id',$id)
                ->first();

        $roles = Role::get();

        return view('admin.user_management.user.edit', compact('user','roles'));
    }

    public function update(Request $request, $id)
    {
        if($request->_method == 'PUT')
        {
            DB::beginTransaction();

            try{

                $user = User::findOrFail($id);

                $user->name = $request->name;
                $user->email = $request->email;
                $user->phone = $request->phone;

                if ($request->get('password') == '') {
                    $user->update($request->except('password'));
                }else{
                    $user->password = bcrypt($request->password);
                }

                $user->update();

                DB::table('model_has_roles')->where('model_id',$id)->delete();

                $user->assignRole($request->role);

                DB::commit();

                return \response()->json([
                    'message' => 'User updated successful'
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
        $user = User::findOrFail($id);

        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->delete();

        return response()->json([
            'message' => 'user destroy successful'
        ],Response::HTTP_OK);
    }

    public function statusChange($id)
    {
        $user = User::findOrFail($id);

        if($user->status == 0)
        {
            $user->update(['status' => 1]);

            return response()->json([
                'message' => 'User is active'
            ],Response::HTTP_OK);
        }else{
            $user->update(['status' => 0]);

            return response()->json([
                'message' => 'User is Inactive'
            ],Response::HTTP_OK);
        }
    }

}
