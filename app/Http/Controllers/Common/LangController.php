<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LangRequest;
use App\Models\Lang;
use App\Models\Type;
use Illuminate\Support\Facades\DB;

class LangController extends Controller
{    
    protected $model;
    public function __construct(){
        $this->model = new Lang;
        $this->middleware('permission:view lang',   ['only' => ['show', 'index']]);
        $this->middleware('permission:create lang', ['only' => ['create','store']]);
        $this->middleware('permission:edit lang', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete lang',   ['only' => ['destroy']]);             
    }
    public function index(Request $request){        
        if($request->ajax()){                    
            return $this->model->datatable();
        }
       return view('common.lang.index');
    }

    public function create(){
        $data = new Lang;     
        return view('common.lang.form', compact('data'));
    }

    public function store(LangRequest $request){   
        DB::BeginTransaction();
        try{      
            $query = $this->model->insertUpdate($request);                  
            if($query['status']){
                DB::commit();
                return response()->json(['status'=>true,'message'=> 'Lang updated successfully']);
            }else{
                return response()->json(['status'=>true,'message'=> $query['message']]);
            }
        } catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false,'message'=> showError($e)]);
        }        
    }
    
    public function edit($id){
        $data = Lang::find($id);
        return view('common.lang.form', compact('data'));
    }

    public function update(LangRequest $request, $id){ 
        DB::BeginTransaction();
        try{   
            $query = $this->model->insertUpdate($request, $id);                  
            if($query['status']){
                DB::commit();
                return response()->json(['status'=>true,'message'=> 'Lang updated successfully']);
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
            $delete = Lang::find($id)->delete();
            DB::commit();
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=> showError($e)]);
        }
        return response()->json(['status'=>true,'message'=> 'Lang deleted successfully!']);
    }
}
