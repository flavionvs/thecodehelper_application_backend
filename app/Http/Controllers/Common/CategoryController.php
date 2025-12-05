<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{    
    protected $model;
    public function __construct(){
        $this->model = new Category;
        $this->middleware('permission:view category',   ['only' => ['show', 'index']]);
        $this->middleware('permission:create category', ['only' => ['create','store']]);
        $this->middleware('permission:edit category', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete category',   ['only' => ['destroy']]);             
    }
    public function index(Request $request){        
        if($request->ajax()){                    
            return $this->model->datatable();
        }
       return view('common.category.index');
    }

    public function create(){
        $data = new Category;     
        return view('common.category.form', compact('data'));
    }

    public function store(CategoryRequest $request){   
        DB::BeginTransaction();
        try{      
            $query = $this->model->insertUpdate($request);                  
            if($query['status']){
                DB::commit();
                return response()->json(['status'=>true,'message'=> 'Category updated successfully']);
            }else{
                return response()->json(['status'=>true,'message'=> $query['message']]);
            }
        } catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false,'message'=> showError($e)]);
        }        
    }
    
    public function edit($id){
        $data = Category::find($id);
        return view('common.category.form', compact('data'));
    }

    public function update(CategoryRequest $request, $id){ 
        DB::BeginTransaction();
        try{   
            $query = $this->model->insertUpdate($request, $id);                  
            if($query['status']){
                DB::commit();
                return response()->json(['status'=>true,'message'=> 'Category updated successfully']);
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
            $delete = Category::find($id)->delete();
            DB::commit();
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=> showError($e)]);
        }
        return response()->json(['status'=>true,'message'=> 'Category deleted successfully!']);
    }
}
