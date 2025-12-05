<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Type;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use DB;

class SubCategoryController extends Controller
{    
    protected $model;
    public function __construct(){
        $this->model = new SubCategory;
        $this->middleware('permission:view sub category',   ['only' => ['show', 'index']]);
        $this->middleware('permission:create sub category', ['only' => ['create','store']]);
        $this->middleware('permission:edit sub category', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete sub category',   ['only' => ['destroy']]);             
    }
    public function index(Request $request){        
        if($request->ajax()){                    
            return $this->model->datatable();
        }
       return view('common.sub-category.index');
    }

    public function create(){
        $data = new SubCategory;
        $type = Type::get();
        $category = Category::get();
        return view('common.sub-category.form', compact('data', 'type', 'category'));
    }

    public function store(SubCategoryRequest $request){   
        DB::BeginTransaction();
        try{      
            if($this->model->insertUpdate($request)){
                DB::commit();  
                return response()->json(['status'=>true,'message'=> 'Category created successfully']);
            }
        } catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false,'message'=> showError($e)]);
        }        
    }
    
    public function edit($id){
        $data = SubCategory::find($id);
        $type = Type::get();
        $category = Category::get();
        return view('common.sub-category.form', compact('data', 'type', 'category'));
    }

    public function update(SubCategoryRequest $request, $id){ 
        DB::BeginTransaction();
        try{                     
            if($this->model->insertUpdate($request, $id)){
                DB::commit();
                return response()->json(['status'=>true,'message'=> 'Category updated successfully']);
            }
        } catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false,'message'=> showError($e)]);
        }    
    }

    public function destroy($id){
        DB::BeginTransaction();
        try{        
            $delete = SubCategory::find($id)->delete();
            DB::commit();
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=> showError($e)]);
        }
        return response()->json(['status'=>true,'message'=> 'Category deleted successfully!']);
    }

}
