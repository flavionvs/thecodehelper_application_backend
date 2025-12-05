<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use yajra\Datatables\DataTables;
use Storage;
use DB;


class Technology extends Model
{    
    protected $guarded = [];
    public function insertUpdate($request, $id = null){      
        $req = request()->except('_token', '_method');
        if(!empty($id)){           
            Technology::find($id)->update($req);
        }else{         
            Technology::create($req);
        }                   
        return ['status' => true];       
    }    
    
    public function datatable(){
        $data = Technology::query();                      
       return DataTables::of($data)
                ->addIndexColumn() 
                ->addColumn('action', function($data){
                    $action = [];                      
                    if(request()->user()->can('edit technology')){
                        $action[] = array('name' => 'edit', 'modal' => 'large', 'url' => route(guardName().".technology.edit", $data->id), 'header' => 'Edit technology');
                    }
                    if(request()->user()->can('delete technology')){
                        $action[] = array('name' => 'delete', 'url' => route(guardName().'.technology.destroy', [$data->id]), 'modalId' => 'delete-modal');                     
                    }                    
                    return view('admin.layout.action', compact('action'));                     
                })                
                ->rawColumns(['action', 'image'])
                ->make(true);
    }
}
