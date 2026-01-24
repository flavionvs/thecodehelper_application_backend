<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use yajra\Datatables\DataTables;
use Storage;
use DB;


class Source extends Model
{
    /**
     * NOTE: Table has INVISIBLE my_row_id, but 'id' is used in foreign keys.
     */
    protected $guarded = [];
    public function insertUpdate($request, $id = null){      
        $request = $request->except('_token', '_method');
        if(!empty($id)){           
            Source::where('id', $id)->update($request);
        }else{         
            Source::create($request);
        }                       
        return true;       
    }    
    
    public function datatable(){
        $data = Source::join('services', 'services.id', 'sources.service_id')
                    ->join('verticals', 'verticals.id', 'services.vertical_id')
                    ->select('sources.*', 'services.name as service', 'verticals.name as vertical');                      
       return DataTables::of($data)
                ->addIndexColumn() 
                ->editColumn('service_id', '{{$service}}')
                ->addColumn('vertical_id', '{{$vertical}}')
                ->addColumn('action', function($data){
                    $action = [];                      
                    if(request()->user()->can('edit source')){
                        $action[] = array('name' => 'edit', 'modal' => 'medium', 'url' => route(guardName().".source.edit", $data->id), 'header' => 'Edit source');
                    }
                    if(request()->user()->can('delete source')){
                        $action[] = array('name' => 'delete', 'url' => route(guardName().'.source.destroy', [$data->id]), 'modalId' => 'delete-modal');                     
                    }                    
                    return view('admin.layout.action', compact('action'));                     
                })                
                ->rawColumns(['action', 'image'])
                ->make(true);
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }
}
