<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TechnologyRequest;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Facades\DB;

class TechnologyController extends Controller
{    
    protected $model;
    public function __construct(){
        $this->model = new Technology;
        $this->middleware('permission:view technology',   ['only' => ['show', 'index']]);
        $this->middleware('permission:create technology', ['only' => ['create','store']]);
        $this->middleware('permission:edit technology', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete technology',   ['only' => ['destroy']]);             
    }
    public function index(Request $request){        
        if($request->ajax()){                    
            return $this->model->datatable();
        }
       return view('common.technology.index');
    }

    public function create(){
        $data = new Technology;     
        return view('common.technology.form', compact('data'));
    }

    public function store(TechnologyRequest $request){   
        DB::BeginTransaction();
        try{      
            $query = $this->model->insertUpdate($request);                  
            if($query['status']){
                DB::commit();
                return response()->json(['status'=>true,'message'=> 'Technology updated successfully']);
            }else{
                return response()->json(['status'=>true,'message'=> $query['message']]);
            }
        } catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false,'message'=> showError($e)]);
        }        
    }
    
    public function edit($id){
        $data = Technology::find($id);
        return view('common.technology.form', compact('data'));
    }

    public function update(TechnologyRequest $request, $id){ 
        DB::BeginTransaction();
        try{   
            $query = $this->model->insertUpdate($request, $id);                  
            if($query['status']){
                DB::commit();
                return response()->json(['status'=>true,'message'=> 'Technology updated successfully']);
            }else{
                return response()->json(['status'=>true,'message'=> $query['message']]);
            }
        } catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false,'message'=> showError($e)]);
        }    
    }

    public function destroy($id){
        DB::BeginTransaction();
        try{        
            $delete = Technology::find($id)->delete();
            DB::commit();
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=> showError($e)]);
        }
        return response()->json(['status'=>true,'message'=> 'Technology deleted successfully!']);
    }
}
