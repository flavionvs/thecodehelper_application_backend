<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use yajra\Datatables\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{    
    protected $user_model;
    public function __construct(){     
        $this->user_model = new User;   
        $this->middleware('permission:view user',   ['only' => ['show', 'index']]);
        $this->middleware('permission:create user', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete user',   ['only' => ['destroy']]);
    }
    public function index(Request $request){     
        if($request->ajax()){                 
            return $this->user_model->datatable();
        }
       return view('common.user.index');
    }
    public function freelancer(){
        if(request()->ajax()){                 
            return $this->user_model->datatable('Freelancer');
        }
        return view('common.user.index');
    }
    public function client(){
        if(request()->ajax()){                 
            return $this->user_model->datatable('Client');
        }
        return view('common.user.index');
    }

    public function create(){
        $data = new User;     
        $programming_language = DB::table('programming_languages')->where('status', 'Active')->get();  
        $lang = DB::table('langs')->where('status', 'Active')->get();  
        return view('common.user.form', compact('data','programming_language','lang'));
    }

    public function store(UserRequest $request){
        DB::BeginTransaction();
        try{      
            if($this->user_model->insertUpdate($request)){
                DB::commit();  
                return response()->json(['status'=>true,'message'=> 'User created successfully']);
            }
        } catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false,'message'=> showError($e)]);
        }   
    }
    
    public function edit($id){
        $data = User::find($id);        
        $programming_language = DB::table('programming_languages')->where('status', 'Active')->get();  
        $lang = DB::table('langs')->where('status', 'Active')->get();  
        return view('common.user.form', compact('data','programming_language','lang'));
    }

    public function update(UserRequest $request, $id){
        DB::BeginTransaction();
        try{        
            
            if($this->user_model->insertUpdate($request, $id)){
                DB::commit();  
                return response()->json(['status'=>true,'message'=> 'User updated successfully']);
            }
        } catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false,'message'=> showError($e)]);
        }   
    }

    public function destroy($id){
        DB::BeginTransaction();
        try{        
            $delete = User::find($id)->delete();
            DB::commit();
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=> $e->getMessage()]);
        }
        return response()->json(['status'=>true,'message'=> 'Record deleted successfully!']);
    }
    public function editProfile(){
        return view('superadmin.setting.update-profile');
    }

    public function updateProfile(ProfileRequest $request){            
        $update = User::find(authId());
        $update->email = $request->email;
        if(isset($request->old_password)){
            if(Hash::check($request->old_password, $update->password)){
                $update->password = $request->password;
            }else{                
                return response()->json(['status'=>false,'message'=> 'Old Password does not match']);
            }
        }
        $update->save();            
        return response()->json(['status'=>true,'message'=> 'Profile updated successfully']);

    }
}
