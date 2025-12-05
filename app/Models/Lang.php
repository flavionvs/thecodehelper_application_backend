<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use yajra\Datatables\DataTables;
use Storage;
use DB;


class Lang extends Model
{    
    protected $guarded = [];
    protected $table = 'langs';
    
    public function insertUpdate($request, $id = null){      
        $req = request()->except('_token', '_method');
        if(!empty($id)){           
            Lang::find($id)->update($req);
        }else{         
            Lang::create($req);
        }                   
        return ['status' => true];       
    }    
    
    public function datatable(){
        $data = Lang::query();                      
       return DataTables::of($data)
                ->addIndexColumn() 
                ->addColumn('action', function($data){
                    $action = [];                      
                    if(request()->user()->can('edit lang')){
                        $action[] = array('name' => 'edit', 'modal' => 'large', 'url' => route(guardName().".lang.edit", $data->id), 'header' => 'Edit lang');
                    }
                    if(request()->user()->can('delete lang')){
                        $action[] = array('name' => 'delete', 'url' => route(guardName().'.lang.destroy', [$data->id]), 'modalId' => 'delete-modal');                     
                    }                    
                    return view('admin.layout.action', compact('action'));                     
                })                
                ->rawColumns(['action', 'image'])
                ->make(true);
    }
}
