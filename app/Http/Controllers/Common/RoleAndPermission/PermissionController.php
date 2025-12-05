<?php

namespace App\Http\Controllers\Common\RoleAndPermission;

use App\Http\Controllers\Controller;
use App\Models\ModelHasRole;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\RoleHasPermission;
use App\Models\User;
use yajra\Datatables\DataTables;
use Validator;
use Hash;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{    

    public function __construct(){        
        $this->middleware('permission:view permission',   ['only' => ['show', 'index']]);        
        $this->middleware('permission:edit permission', ['only' => ['assignRole']]);                        
    }
    public function index(Request $request){
       $role = Role::where('status', 'Active')->where('id', '!=', 1)->get();
       return view('common.permission.index', compact('role'));
    }

   public function getPermissions($role_id){        
        return view('common.permission.permissions', compact('role_id'));        
   }

   public function assignRole(Request $request){        
        DB::BeginTransaction();
        try{
            $role = Role::find($request->role_id);   
            if($role){
                RoleHasPermission::where('role_id', $request->role_id)->delete();        
                if($request->permission){
                    foreach($request->permission as $item){                                                
                        $permission = Permission::whereName($item)->where('guard_name', $role->guard_name)->first();                                              
                        if($permission){
                            $permission->assignRole($role);                    
                        }
                    }
                }
            }
            $users = ModelHasRole::where('role_id', $request->role_id)->get(['model_id']);
            $user = User::whereIn('id', $users)->update(['logout' => '1']);
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Role has assigned to the permission!']);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['status' => false, 'message' => showError($e)]);
        }       
   }

}
