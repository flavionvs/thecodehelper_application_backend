<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use yajra\Datatables\DataTables;
use Storage;
use DB;


class SubCategory extends Model
{    
    /**
     * Production DB primary key is my_row_id (AUTO_INCREMENT, INVISIBLE).
     */
    protected $primaryKey = 'my_row_id';
    public $incrementing = true;
    protected $keyType = 'int';

    public function insertUpdate($request, $id = null){      
        if(!empty($id)){           
            $create = SubCategory::find($id);
        }else{         
            $create = new SubCategory;
        }              
        $create->category_id = $request->category_id;            
        $create->name = $request->name;            
        $create->slug = str_replace(' ','-',strtolower($request->slug));            
        $create->status = $request->status;            
        $create->meta_tag = $request->meta_tag;            
        $create->meta_description = $request->meta_description;            
        if($request->image){
            $create->image = fileSave($request->image, 'images/sub-category');            
        }
        return $create->save();       
    }    
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function datatable(){
        $data = SubCategory::join('categories', 'categories.id', 'sub_categories.category_id')                        
                        ->select('sub_categories.*', 'categories.name as category');                      
       return DataTables::of($data)
                ->addIndexColumn() 
                ->editColumn('category_id', '{!!$category!!}')                
                ->editColumn('image', '{!!$image ? fetchImage($image) : ""!!}')                
                ->addColumn('action', function($data){
                    $action = [];                      
                    if(request()->user()->can('edit category')){
                        $action[] = array('name' => 'edit', 'modal' => 'large', 'url' => route(guardName().".sub-category.edit", $data->id), 'header' => 'Edit Sub category');
                    }
                    if(request()->user()->can('delete category')){
                        $action[] = array('name' => 'delete', 'url' => route(guardName().'.sub-category.destroy', [$data->id]), 'modalId' => 'delete-modal');                     
                    }                    
                    return view('admin.layout.action', compact('action'));                     
                })                
                ->rawColumns(['action', 'image'])
                ->make(true);
    }
}
