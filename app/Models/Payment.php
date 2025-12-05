<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function datatable(){
        $data = DB::table('payments')
                    ->join('users','users.id','payments.user_id')                    
                    ->select(
                        'payments.*',
                        'users.first_name as username',                       
                    );
      
        if(request()->client){
            $data->where('payments.user_id',request()->client);
        }

       return DataTables::of($data)
                ->addIndexColumn()                 
                ->addColumn('created_at','{{dateFormat($created_at)}}')                
                ->addColumn('user_id','{{$username}}')                            
                ->rawColumns(['action', 'application'])
                ->make(true);
    }  
}
