<?php

namespace App\Http\Controllers\Common\RoleAndPermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\BankDetail;
use yajra\Datatables\DataTables;
use Illuminate\Support\Facades\Validator;
use Hash;

class RoleController extends Controller
{    
    public function __construct(){
        $this->middleware('permission:view role',   ['only' => ['show', 'index']]);
        $this->middleware('permission:create role', ['only' => ['create', 'role']]);
        $this->middleware('permission:edit role', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete role',   ['only' => ['destroy']]);
        
    }
    public function index(Request $request){
        
        if($request->ajax()){                    
            $data = Role::where('id', '!=', 1)->get();                                             
            return DataTables::of($data)
                ->addIndexColumn()   
                ->editColumn('guard_name', function($data){
                    $output = $data->guard_name;
                    $output .='<br><small>Login Url : <b><a href="'.url($data->guard_name.'/login').'" target="_blank">'.url($data->guard_name.'/login').'</a></b></small>';
                    return $output;
                })                                         
                ->addColumn('action', function($data){
                    $action = [];      
                    if($data->name != 'Superadmin'){
                          if(request()->user()->can('edit role')){
                              $action[] = array('name' => 'edit', 'url' => route(guardName().".role.edit", $data->id), 'header' => 'Edit Role');
                          } 
                          if(request()->user()->can('delete role')){
                              $action[] = array('name' => 'delete', 'url' => route(guardName().'.role.destroy', [$data->id]), 'modalId' => 'delete-modal');                     
                          }                    
                          return view('admin.layout.action', compact('action'));
                    }else{
                        return '<span class="color-red">Can not edit or delete</span>';
                    }
                })                
                ->rawColumns(['action', 'guard_name'])
                ->make(true);
            }
       return view('common.role.index');
    }

    public function create(){
        $data = new Role;
        return view('common.role.form', compact('data'));
    }

    public function store(Request $request){    
        $validator = Validator::make($request->all(), $this->createRule());
        if ($validator->fails()) {            
          return response()->json(array('status'=>'Validator Failed', 'errors' => $validator->getMessageBag()->toArray()));
        }       
        if($this->insertUpdate($request)){
            return response()->json(['status'=>true,'message'=> 'Role created successfully']);
        }else{
            return response()->json(['status'=>false,'message'=> 'Something went wron!']);
        }
    }
    
    public function edit($id){
        $data = Role::find($id);
        return view('common.role.form', compact('data'));
    }

    public function update(Request $request, $id){              
        if($this->insertUpdate($request, $id)){
            return response()->json(['status'=>true,'message'=> 'Role updated successfully']);
        }else{
            return response()->json(['status'=>false,'message'=> 'Something went wron!']);
        }
    }

    public function destroy($id){
        $delete = Role::find($id)->delete();
        return response()->json(['status'=>true,'message'=> 'Role deleted successfully!']);
    }
    public function insertUpdate($request, $id = null){      
        if(!empty($id)){           
            $create = Role::find($id);
        }else{         
            $create = new Role;
        }               
        $create->name = $request->name;            
        $create->guard_name = $request->guard_name;            
        $create->status = $request->status;         
        return $create->save();       
    }    
    
    public function createRule(){
     return ['name'=>'required|unique:roles',
             'status'=>'required',
             'guard_name'=>'required||in:employee,channelpartner,mentor',
            ];
    }
    public function updateRule($id){
       return [
        'name'=>'required|unique:roles,name,'.$id,
        'status'=>'required', 
        'guard_name'=>'required||in:employee,channelpartner,mentor',                        
        ];
    }
    // static function boot(){
    //     parent::boot();        
    //     static::addGlobalScope('not_superadmin', function(Builder $builder){
    //         if(auth()->guard(guardName())->user()->myRole->role_id != 1){
    //             $builder->where('name', '!=', 'SuperAdmin');
    //         }
    //     });
    // }

}
