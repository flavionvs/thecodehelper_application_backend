<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use yajra\Datatables\DataTables;


class Order extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function practitioner(){
        return $this->belongsTo(User::class, 'practitioner_id');
    }
    public function layout(){
        return $this->belongsTo(PropertyLayout::class);
    }
    public function orderInstallment(){
        return $this->hasMany(OrderInstallment::class);
    }
    public function service(){
        return $this->hasMany(OrderService::class, 'order_id', 'id');
    }
    public function document(){
        return $this->hasMany(OrderDocument::class, 'order_id', 'id');
    }         
    public function datatable(){
        $practitioner_id = request('practitioner_id', null);
        $from_date = request('from_date', null);
        $to_date = request('to_date', null);
        $status = request('status', null);
        
        $data = Order::join('users', 'users.id', 'orders.user_id')                 
                    ->select('orders.*', 'users.email');   
        if($status){            
            $data->where('orders.status', $status);               
        }
    
        
        if($practitioner_id){
            $data->where('practitioner_id', $practitioner_id);   
        }
        if($from_date){
            $data->whereDate('orders.created_at', '>=', date('Y-m-d', strtotime($from_date)));   
        }
        if($to_date){
            $data->whereDate('orders.created_at', '<=', date('Y-m-d', strtotime($to_date)));   
        }        
        return DataTables::of($data)
                ->addIndexColumn()                             
                ->editColumn('user_id', '{{$email}}')
                ->editColumn('practitioner_id', function($data){
                    return $data->practitioner ? $data->practitioner->first_name : '';
                })
                ->editColumn('created_at', '{{dateFormat($created_at)}}')                   
                ->addColumn('document', function($data){
                    $output = '';
                    if($data->document->count() > 0){
                        foreach($data->document as $item){
                            $output .='<a href="'.asset($item->file).'"><i class="fa fa-file mr-2"></i></a>';
                        }
                    }
                    return $output;
                })
           
                // ->addColumn('assign_date', '{{$assign_date ? timeFormat($assign_date) : ""}}')                
                // ->addColumn('completion_date', '{{$completion_date ? timeFormat($completion_date) : ""}}')                
                ->editColumn('status', function($data){
                    if($data->status == 'Pending'){
                    return '<span class="badge bg-danger text-white">Pending</span>';
                    }elseif($data->status == 'Assigned'){
                    return '<span class="badge bg-primary text-white">Assigned</span>';
                    }elseif($data->status == 'Accepted'){
                    return '<span class="badge bg-secondary text-white">Accepted</span>';
                    }elseif($data->status == 'Completed'){
                    return '<span class="badge bg-success text-white">Completed</span>';
                    }
                })
          
 
                ->addColumn('action', function($data){
                    return '<a data-toggle="modal" 
                            data-target="#serviceModal" 
                            data-backdrop="static" 
                            data-keyboard="false" 
                            class="btn btn-primary btn-sm edit-btn"
                            data-header="View Services" 
                            data-url="'.url(guardName().'/order/view-service', $data->id).'" 
                            data-id="'.$data->id.'" 
                            href="javascript::void(0)">
                            <i class="fa fa-eye"></i>
                            View Service
                            </a>';
                    $action = [];      
                    if(authId() == 1){
                        if($data->status != 'Completed'){
                            // $action[] = array('name' => 'Assign', 'modal' => 'medium', 'url' => url(guardName()."/order/assign", $data->id), 'header' => 'Assign To Practitioner');
                        }
                    }else{
                        // $action[] = array('name' => 'show', 'modal' => 'extra large', 'url' => route(guardName().".order.show", $data->id), 'header' => 'Details');
                        // $check = OrderAssign::whereOrderServiceId($data->id)->whereUserId(authId())->first();                        
                        // if($check){
                        //     // checking for accepted
                        //     $accpet = OrderAssign::whereOrderId($data->id)->whereStatus('Accepted')->first();
                        //     if(!$accpet){
                        //         if($check->status == 'Under Review'){
                        //             $action[] = array('name' => 'Accept', 'link' => true, 'url' => url(guardName()."/order/accept", $data->id));                                        
                        //             $action[] = array('name' => 'Reject', 'link' => true, 'url' => url(guardName()."/order/reject", $data->id));                                                                                        
                        //         }elseif($check->status == 'Assigned'){
                        //             $action[] = array('name' => 'Under Review', 'link' => true, 'url' => url(guardName()."/order/under-review", $data->id));                                        
                        //             $action[] = array('name' => 'Accept', 'link' => true, 'url' => url(guardName()."/order/accept", $data->id));                                        
                        //             $action[] = array('name' => 'Reject', 'link' => true, 'url' => url(guardName()."/order/reject", $data->id));                                                                
                        //         }
                        //     }
                        // }                        
                        // $action[] = array('name' => 'delete', 'url' => route(guardName().'.order.destroy', [$data->id]), 'modalId' => 'delete-modal');                     
                    }
                    $action[] = array('name' => 'View Service', 'modal' => 'extra large', 'url' => url(guardName()."/order/view-service", $data->id), 'header' => 'View Services');                                        
                    return view('admin.layout.action', compact('action', 'data'));                     
                })                
                ->rawColumns(['action', 'status', 'document','assigned_practitioner', 'practitioner_status', 'uploaded_document'])
                ->make(true);
    }
    public function orderServiceDatatable(){
        $from_date = request('from_date', null);
        $to_date = request('to_date', null);
        $status = request('status', null);
        
        $data = OrderAssign::join('users', 'users.id', 'order_assign.user_id')                 
                            ->join('order_services', 'order_services.id', 'order_assign.order_service_id')                 
                            ->join('orders', 'orders.id','=','order_services.order_id')
                            ->where('order_assign.user_id', authId())
                            ->select('order_assign.*', 'users.email', 'order_services.order_id', 'order_services.service_type as st', 'order_services.service as s', 'order_services.status as sts');   
        if($status){            
            $data->where('order_assign.status', $status);               
        }

        if($from_date){
            $data->whereDate('order_assign.created_at', '>=', date('Y-m-d', strtotime($from_date)));   
        }
        if($to_date){
            $data->whereDate('order_assign.created_at', '<=', date('Y-m-d', strtotime($to_date)));   
        }        
        return DataTables::of($data)
                ->addIndexColumn()                             
                ->editColumn('user_id', '{{$email}}')
                ->addColumn('service_type', '{{$st}}')
                ->addColumn('service', '{{$s}}')
                ->editColumn('practitioner_id', function($data){
                    return $data->practitioner ? $data->practitioner->first_name : '';
                })
                ->editColumn('created_at', '{{timeFormat($created_at)}}')                             
                // ->addColumn('assign_date', '{{$assign_date ? timeFormat($assign_date) : ""}}')                
                // ->addColumn('completion_date', '{{$completion_date ? timeFormat($completion_date) : ""}}')                
                ->editColumn('status', function($data){
                    if($data->status == 'Pending'){
                    return '<span class="badge bg-danger text-white">Pending</span>';
                    }elseif($data->status == 'Assigned'){
                    return '<span class="badge bg-primary text-white">Assigned</span>';
                    }elseif($data->status == 'Accepted'){
                    return '<span class="badge bg-secondary text-white">Accepted</span>';
                    }elseif($data->status == 'Rejected'){
                    return '<span class="badge bg-danger text-white">Rejected</span>';
                    }elseif($data->status == 'Under Review'){
                    return '<span class="badge bg-info text-white">Under Review</span>';
                    }elseif($data->status == 'Completed'){
                    return '<span class="badge bg-success text-white">Completed</span>';
                    }
                })
        
                ->addColumn('action', function($data){
                    $action = [];                     
                        $check = OrderAssign::whereId($data->id)->whereUserId(authId())->first();                        
                        if($check){
                            // checking for accepted
                            $accpet = OrderAssign::where('order_service_id',$data->order_service_id)->where(function($q){
                                            $q->whereStatus('Accepted')->orWhere('status','Accepted');
                                        })->first();                            
                            if(!$accpet){
                                if($check->status == 'Under Review'){
                                    $action[] = array('name' => 'Accept', 'link' => true, 'url' => url(guardName()."/order/accept", $data->id));                                        
                                    $action[] = array('name' => 'Reject', 'link' => true, 'url' => url(guardName()."/order/reject", $data->id));                                                                                        
                                }elseif($check->status == 'Assigned'){
                                    $action[] = array('name' => 'Under Review', 'link' => true, 'url' => url(guardName()."/order/under-review", $data->id));                                        
                                    $action[] = array('name' => 'Accept', 'link' => true, 'url' => url(guardName()."/order/accept", $data->id));                                        
                                    $action[] = array('name' => 'Reject', 'link' => true, 'url' => url(guardName()."/order/reject", $data->id));                                                                
                                }
                            }
                        }                        
                        // $action[] = array('name' => 'delete', 'url' => route(guardName().'.order.destroy', [$data->id]), 'modalId' => 'delete-modal');                     
                    $action[] = array('name' => 'View Service', 'modal' => 'extra large', 'url' => url(guardName()."/practitioner-order/show", $data->id), 'header' => 'View Services');                                        
                    return view('admin.layout.action', compact('action', 'data'));                     
                })                
                ->rawColumns(['action', 'status', 'document','assigned_practitioner', 'practitioner_status', 'uploaded_document'])
                ->make(true);
    }
}
