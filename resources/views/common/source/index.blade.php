@extends('admin.layout.default', ['title' => 'Source'])
@section('content')

<div class="app-content">
  <x-header header="Source" link1="Source" />
   <x-table title="Source" modal="medium" role="create source" header="Add Source" url='{{route(guardName().".source.create")}}'>
    <thead>
            <tr>
                <th class="wd-15p">S.No.</th>
                <th class="wd-20p">Name</th>                                                                    
                <th class="wd-20p">Service</th>                                                                    
                <th class="wd-20p">Vertical</th>                                                                    
                @if(request()->user()->can('edit source') || request()->user()->can('delete source'))
                <th class="wd-25p">Action</th>            
                @endif            
            </tr>
        </thead>                                  
   </x-table>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var table;
        $(document).ready(function () {    
            table = $('#myTable').DataTable({                
                lengthMenu: [10, 20, 50, 100, 200, 500],                                
                ajax: {
                    "url" : "{{url(guardName().'/source')}}",
                    "data" : function(d){
                        d.type = $('input[id="filter-value"]').val();
                    }
                },             
                columns: [         
                    { data: 'DT_RowIndex', orderable:false, searchable:false},
                    { data: "name" , name: "name" },                                                                                                                       
                    { data: "service_id" , name: "services.name" },                                                                                                                       
                    { data: "vertical_id" , name: "countries.name" },                                                                                                                       
                    @if(request()->user()->can('edit source') || request()->user()->can('delete source'))
                    { data: "action" , name: "action" },   
                    @endif
                    ],
            });
        });
        datas();
        function datas(){
            $('#vertical_id').change(function(){
                getService();
            });
            getService();
            function getService() {
                let vertical_id = $('#vertical_id').val();
                if (vertical_id == '' || vertical_id == undefined) {
                    vertical_id = 0;
                }
                let service_id = $('#vertical_id').data('service-id');
                $.ajax({
                    url: '{{ url(guardName() . '/get-service') }}/' + vertical_id,
                    data: {
                        service_id: service_id
                    },
                    success: function(res) {
                        $('#service').html(res);
                        if ($('.chosen').html() != undefined) {
                            $('.chosen').chosen();
                        }
                    }
                })
            }
        }
       
    </script>
@endsection
