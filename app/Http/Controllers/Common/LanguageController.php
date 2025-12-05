<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use App\Models\Type;
use Illuminate\Support\Facades\DB;

class LanguageController extends Controller
{    
    protected $model;
    public function __construct(){
        $this->model = new Language;
        $this->middleware('permission:view language',   ['only' => ['show', 'index']]);
        $this->middleware('permission:create language', ['only' => ['create','store']]);
        $this->middleware('permission:edit language', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete language',   ['only' => ['destroy']]);             
    }
    public function index(Request $request){        
        if($request->ajax()){                    
            return $this->model->datatable();
        }
       return view('common.language.index');
    }

    public function create(){
        $data = new Language;     
        return view('common.language.form', compact('data'));
    }

    public function store(LanguageRequest $request){   
        DB::BeginTransaction();
        try{      
            $query = $this->model->insertUpdate($request);                  
            if($query['status']){
                DB::commit();
                return response()->json(['status'=>true,'message'=> 'Language updated successfully']);
            }else{
                return response()->json(['status'=>true,'message'=> $query['message']]);
            }
        } catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false,'message'=> showError($e)]);
        }        
    }
    
    public function edit($id){
        $data = Language::find($id);
        return view('common.language.form', compact('data'));
    }

    public function update(LanguageRequest $request, $id){ 
        DB::BeginTransaction();
        try{   
            $query = $this->model->insertUpdate($request, $id);                  
            if($query['status']){
                DB::commit();
                return response()->json(['status'=>true,'message'=> 'Language updated successfully']);
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
            $delete = Language::find($id)->delete();
            DB::commit();
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=> showError($e)]);
        }
        return response()->json(['status'=>true,'message'=> 'Language deleted successfully!']);
    }
}
