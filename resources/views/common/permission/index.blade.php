@extends('admin.layout.default', ['title' => 'Permission'])
@section('content')
    <div class="app-content">
        <form action="{{ url(guardName() . '/assign-role') }}" method="post" id="permission-form">
            @csrf
            <x-header header="Permission" link1="Permission" />
            <x-card header="Role" collapse="yes">
                <div class="row">
                    <div class="col-md-4">
                        <label for="">Role</label>
                    </div>
                    <div class="col-md-4">
                        <select name="role_id" id="role_id" class="form-control chosen">
                            @foreach ($role as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </x-card>
            <div id="permission-data"></div>
    </div>
    </form>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#role_id').change(function() {
                getPermission();
            });
            getPermission();

            function getPermission() {
                let role_id = $('#role_id').val();
                $.ajax({
                    url: '{{ url(guardName() . '/get-permissions') }}/' + role_id,
                    success: function(res) {
                        $('#permission-data').html(res)
                        bulkSelect();
                        $('input[type=checkbox]').click(function() {
                            checkUncheck();
                        });                        
                        checkUncheck();
                    }
                })
            }
            bulkSelect();

            function bulkSelect() {
                $('.main').click(function() {
                    let cls = $(this).data('class');
                    if ($(this).prop('checked') == true) {
                        $('.' + cls).prop('checked', true);
                    } else {
                        $('.' + cls).prop('checked', false);
                    }
                });
            }

            function checkUncheck() {             
                // Target the checkboxes by their values
                const checkbox1 = $("input[type='checkbox'][value='view all lead']");
                const checkbox2 = $("input[type='checkbox'][value='view only my lead']");

                // Click event handler for checkbox1
                checkbox1.click(function() {
                    if (checkbox1.prop('checked')) {
                    checkbox2.prop('checked', false);
                    }
                });

                // Click event handler for checkbox2
                checkbox2.click(function() {
                    if (checkbox2.prop('checked')) {
                    checkbox1.prop('checked', false);
                    }
                });
            }
            $('#permission-form').on('submit', function(e) {
                e.preventDefault();
                let data = new FormData(this);
                let url = $(this).attr('action');
                $.ajax({
                    url: url,
                    type: 'post',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == true) {
                            toastr.success(res.message);
                        } else {
                            toastr.error(res.message);
                        }
                    }
                })
            })
        });
    </script>
@endpush
