<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use yajra\Datatables\DataTables;
use Storage;
use DB;


class Language extends Model
{
    /**
     * NOTE: Table has INVISIBLE id, but 'id' is used in foreign keys.
     */
    protected $guarded = [];
    protected $table = 'programming_languages';
    public function insertUpdate($request, $id = null){      
        $req = request()->except('_token', '_method');
        if(!empty($id)){           
            Language::find($id)->update($req);
        }else{         
            Language::create($req);
        }                   
        return ['status' => true];       
    }    
    
    public function datatable(){
        $data = Language::query();                      
       return DataTables::of($data)
                ->addIndexColumn() 
                ->addColumn('action', function($data){
                    $action = [];                      
                    if(request()->user()->can('edit language')){
                        $action[] = array('name' => 'edit', 'modal' => 'large', 'url' => route(guardName().".language.edit", $data->id), 'header' => 'Edit language');
                    }
                    if(request()->user()->can('delete language')){
                        $action[] = array('name' => 'delete', 'url' => route(guardName().'.language.destroy', [$data->id]), 'modalId' => 'delete-modal');                     
                    }                    
                    return view('admin.layout.action', compact('action'));                     
                })                
                ->rawColumns(['action', 'image'])
                ->make(true);
    }
}
