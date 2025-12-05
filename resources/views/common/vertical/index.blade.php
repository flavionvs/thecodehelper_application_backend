@extends('admin.layout.default', ['title' => 'Vertical'])
@section('content')

<div class="app-content">
  <x-header header="Vertical" link1="Vertical" />
   <x-table title="Vertical" modal="medium" role="create vertical" header="Add Vertical" url='{{route(guardName().".vertical.create")}}'>
    <thead>
            <tr>
                <th class="wd-15p">S.No.</th>
                <th class="wd-20p">Name</th>                                                                    
                @if(request()->user()->can('edit vertical') || request()->user()->can('delete vertical'))
                <th class="wd-25p">Action</th>            
                @endif            
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
            lengthMenu: [10, 20, 50, 100, 200, 500],                                
            ajax: {
                "url" : "{{url(guardName().'/vertical')}}",
                "data" : function(d){
                    d.type = $('input[id="filter-value"]').val();
                }
            },             
            columns: [         
                { data: 'DT_RowIndex', orderable:false, searchable:false},
                { data: "name" , name: "name" },                                                                                                                       
                @if(request()->user()->can('edit vertical') || request()->user()->can('delete vertical'))
                { data: "action" , name: "action" },   
                @endif
                ],
        });
    });
   
</script>
@endpush
