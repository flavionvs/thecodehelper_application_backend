<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use yajra\Datatables\DataTables;
use Storage;
use DB;


class Vertical extends Model
{
    /**
     * NOTE: Table has INVISIBLE my_row_id, but 'id' is used in foreign keys.
     */
    protected $guarded = [];
    public function insertUpdate($request, $id = null){      
        $request = $request->except('_token', '_method');        
        if(!empty($id)){           
            Vertical::where('id', $id)->update($request);
        }else{         
            Vertical::create($request);
        }                       
        return true;       
    }    
    
    public function datatable(){
        $data = Vertical::query();                      
       return DataTables::of($data)
                ->addIndexColumn() 
                ->addColumn('action', function($data){
                    $action = [];                      
                    if(request()->user()->can('edit vertical')){
                        $action[] = array('name' => 'edit', 'modal' => 'medium', 'url' => route(guardName().".vertical.edit", $data->id), 'header' => 'Edit vertical');
                    }
                    if(request()->user()->can('delete vertical')){
                        $action[] = array('name' => 'delete', 'url' => route(guardName().'.vertical.destroy', [$data->id]), 'modalId' => 'delete-modal');                     
                    }                    
                    return view('admin.layout.action', compact('action'));                     
                })                
                ->rawColumns(['action', 'image'])
                ->make(true);
    }
    public function service(){
        return $this->hasMany(Service::class);
    }
}
