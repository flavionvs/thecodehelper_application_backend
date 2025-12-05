<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use yajra\Datatables\DataTables;
use Storage;
use DB;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{    
    protected $guarded = [];
    public function insertUpdate($request, $id = null){      
        if(!empty($id)){           
            $create = Category::withoutGlobalScope(new ActiveScope)->find($id);
        }else{         
            $create = new Category;
        }               
        $create->name = $request->name;            
        $create->slug = str_replace(' ','-',strtolower($request->slug));            
        $create->status = $request->status;                    
        if(request()->image){
            $create->image = fileSave(request()->image, 'upload/category', $create->image);
        }
        $create->save();
        return ['status' => true];       
    }    
    // public function productCategory(){
    //     return $this->hasMany(ProductCategory::class);
    // }
    public function datatable(){
        $data = Category::query();
       return DataTables::of($data)
                ->addIndexColumn() 
                ->editColumn('image', '{!!$image ? fetchImage($image, "100px", "") : ""!!}')                                
                ->addColumn('action', function($data){
                    $action = [];                      
                    if(request()->user()->can('edit category')){
                        $action[] = array('name' => 'edit', 'modal' => 'large', 'url' => route(guardName().".category.edit", $data->id), 'header' => 'Edit category');
                    }
                    if(request()->user()->can('delete category')){
                        $action[] = array('name' => 'delete', 'url' => route(guardName().'.category.destroy', [$data->id]), 'modalId' => 'delete-modal', 'header' => 'Delete');                     
                    }                    
                    return view('admin.layout.action', compact('action'));                     
                })                
                ->rawColumns(['action', 'image'])
                ->make(true);
    }

}
