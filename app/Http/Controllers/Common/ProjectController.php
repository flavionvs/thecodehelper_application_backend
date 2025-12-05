<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Models\Application;
use App\Models\Category;
use App\Models\Project;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{    
    protected $model;
    public function __construct(){
        $this->model = new Project;
        $this->middleware('permission:view project',   ['only' => ['show', 'index']]);
        $this->middleware('permission:create project', ['only' => ['create','store']]);
        $this->middleware('permission:edit project', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete project',   ['only' => ['destroy']]);             
        
    }
    public function index(Request $request){        
        if($request->ajax()){                    
            return $this->model->datatable();
        }        
        $data['categories'] = Category::get();     
        $data['clients'] = User::where('role','Client')->get();     
       return view('common.project.index', $data);
    }
    public function application(Request $request, $project_id = null){        
        if($request->ajax()){                    
            return $this->model->applicationDatatable($project_id);
        }            
        $users = Application::groupBy('user_id')->get();    
        $projects = Application::groupBy('project_id')->get();    
       return view('common.project.application', compact('users','projects'));
    }

    public function create(){
        $data = new Project;
        $category = Category::get();     
        $clients = User::where('role','Client')->get();     
        return view('common.project.form', compact('data','category','clients'));
    }

    public function store(ProjectRequest $request){   
        DB::BeginTransaction();
        try{   
            $query = $this->model->insertUpdate($request);   
            if($query['status']){
                DB::commit();  
                return response()->json(['status'=>true,'message'=> 'Project created successfully']);
            }else{
                return response()->json(['status'=>false,'message'=> $query['message']]);
            }
        } catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false,'message'=> showError($e)]);
        }        
    }
    
    public function edit($id){
        $data = Project::find($id);
        $category = Category::get();     
        $clients = User::where('role','Client')->get();     
        return view('common.project.form', compact('data','category','clients'));    
    }

    public function update(ProjectRequest $request, $id){ 
        DB::BeginTransaction();
        try{   
            $query = $this->model->insertUpdate($request, $id);                  
            if($query['status']){
                DB::commit();
                return response()->json(['status'=>true,'message'=> 'Project updated successfully']);
            }else{
                return response()->json(['status'=>false,'message'=> $query['message']]);
            }
        } catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false,'message'=> showError($e)]);
        }    
    }

    public function destroy($id){
        DB::BeginTransaction();
        try{        
            $delete = Project::find($id)->delete();
            DB::commit();
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=> showError($e)]);
        }
        return response()->json(['status'=>true,'message'=> 'Project deleted successfully!']);
    }  
}
