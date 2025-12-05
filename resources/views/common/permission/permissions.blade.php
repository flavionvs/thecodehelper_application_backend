    <x-card header="Permissions" collapse="no" role="edit permission" submit="Submit">
        <div class="table-responsive">
            <table id="myTable" class="table table-striped table-bordered text-nowrap w-100">                            
            <tr class="bg-light">
                <th class="wd-5p"></th>
                <th class="wd-15p">Permission</th>
                <th class="wd-20p">View</th>                                    
                <th class="wd-10p">Create</th>
                <th class="wd-25p">Edit</th>
                <th class="wd-25p">Delete</th>
            </tr>            
            @include('common.permission.permission-row', ['permission_name' => 'user', 'column' => 4])
            {{-- 'not_included' => ['edit'] it means it will not include edit checkbox --}}
            {{-- @include('common.permission.permission-row', ['permission_name' => 'communication', 'column' => 4, 'not_included' => ['edit']]) --}}
            {{-- it will show sinle checkbox --}}
            {{-- @include('common.permission.permission-row', ['permission_name' => 'view stream selection', 'column' => 1])                       --}}
        </table>
    </div>          
   </x-card>

