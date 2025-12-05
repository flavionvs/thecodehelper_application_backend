@extends('admin.layout.default', ['title' => 'Payment'])
@section('content')

<div class="app-content">
  <x-header header="Payment" link1="Payment" />
  <x-card header="Filter" collapse="yes">
        <div class="row">                       
            <div class="col-md-4">
                <label for="">Client</label>
                <select id="client" class="form-control chosen">
                    <option value="">All</option>
                    @foreach ($clients as $item)                                            
                        <option value="{{ $item->user_id }}">{{ $item->user->first_name }}</option>                                            
                    @endforeach
                </select>
            </div>                                                                                   
        </div>
    </x-card>
   <x-table title="Payment">
    <thead>
            <tr>
                <th class="wd-15p">S.No.</th>                                                                                    
                <th class="wd-20p">Client</th>                                                                                                                                       
                <th class="wd-20p">Amount</th>                                                                                                                                       
                <th class="wd-20p">Status</th>                                                                                                                                       
                <th class="wd-20p">DateTime</th>                                                                                                    
            </tr>
        </thead>                                  
   </x-table>
</div>  
@endsection
@push('scripts')
<script>
        var table;
        $(document).ready(function () {    
            table = $('#myTable').DataTable({                
                lengthMenu: [10, 20, 50, 100, 200, 500, 1000, 3000, 5000, 10000, 20000, 50000, 100000],                                
                ajax: {
                    "url" : "{{request()->fullUrl()}}",
                    "data" : function(d){
                        d.client = $('#client').val();
                        d.category = $('#category').val();                        
                    }
                },             
                columns: [         
                    { data: 'DT_RowIndex', orderable:false, searchable:false},                                                                        
                    { data: "user_id", name:'users.first_name'},                                                                                                                                                                                                                     
                    { data: "amount"},                                                                                                                                                                                                                     
                    { data: "paymentStatus"},                                                                                                                                                                                                                                         
                    { data: "created_at"},                                                                                                                                                                                                                     
                    ],
            });
            $('#client, #category').change(function(){
                table.ajax.reload();
            });
        });

        datas();
        function datas(){            
  
        }
       
    </script>
@endpush
