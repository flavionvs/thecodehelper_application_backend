@if (isset($dropdown))
    <div class="actions">
        <div> Action <i class="fa fa-caret-down"></i></div>
        <ul>
            @foreach ($action as $item)
                <li>
                    <a @if (!isset($item['link'])) data-toggle="modal" 
                        @if ($item['name'] == 'delete')
                            data-target="#delete-modal"
                        @elseif($item['name'] == 'View Service')
                            data-target="#serviceModal"
                        @elseif(isset($item['modal']) && $item['modal'] == 'large')
                            data-target="#myModal-lg" 
                        @elseif(isset($item['modal']) && $item['modal'] == 'extra large')                                        
                            data-target="#myModal-xl"                                          
                        @else
                            data-target="#myModal" @endif
                        data-backdrop="static" data-keyboard="false" @endif

                        @if ($item['name'] == 'disburse') onclick="$('#disburse').attr('data-id', {{ $data->id }})" @endif
                        class=" dropdown-item                   
                    @if ($item['name'] == 'delete') delete-btn
                    @elseif($item['name'] == 'Change Status')
                    change-status
                    edit-btn
                    @elseif($item['name'] == 'View Service')
                    view-service
                    @else
                    @if (!isset($item['link']))
                        edit-btn @endif
                    @endif
                    "

                        @if (isset($item['header'])) data-header="{{ $item['header'] }}" @endif

                        data-url={{ $item['url'] }}
                        data-id="{{ isset($data) ? $data->id : '' }}"
                        @if (isset($item['link'])) href="{{ $item['url'] }}"
                    @else
                        href="javascript::void(0)" @endif
                        >
                        @if (isset($item['icon']))
                            {!! $item['icon'] !!}
                            {{$item['name']}}
                        @else
                            @if ($item['name'] == 'edit')
                                <i class="fa fa-edit"></i>
                                Edit
                            @elseif($item['name'] == 'delete')
                                <i class="fa fa-trash"></i>
                                Delete
                            @elseif($item['name'] == 'show')
                                <i class="fa fa-eye"></i>
                                Show
                            @elseif($item['name'] == 'Upload')
                                <i class="fa fa-upload"></i>
                                Upload Document
                            @elseif($item['name'] == 'Change Status')
                                <i class="fa fa-retweet"></i>
                                Change Status
                            @elseif($item['name'] == 'View Service')
                                <i class="fa fa-eye"></i>
                                View Service
                            @else
                                <i class="fa fa-circle"></i>
                                {{ $item['name'] }}
                            @endif
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@else
    <ul class="d-flex">
        @foreach ($action as $item)
            <li>
                <a @if (!isset($item['link'])) data-toggle="modal" 
                    @if ($item['name'] == 'delete')
                        data-target="#delete-modal"
                    @elseif($item['name'] == 'View Service')
                        data-target="#serviceModal"
                    @elseif(isset($item['modal']) && $item['modal'] == 'large')
                        data-target="#myModal-lg" 
                    @elseif(isset($item['modal']) && $item['modal'] == 'extra large')                                        
                        data-target="#myModal-xl"                                          
                    @else
                        data-target="#myModal" @endif
                    data-backdrop="static" data-keyboard="false" @endif

                    @if ($item['name'] == 'disburse') onclick="$('#disburse').attr('data-id', {{ $data->id }})" @endif
                    class="    
                    action-btn               
                @if ($item['name'] == 'delete') delete-btn
                @elseif($item['name'] == 'Change Status')
                change-status
                edit-btn
                @elseif($item['name'] == 'View Service')
                view-service
                @else
                @if (!isset($item['link']))
                    edit-btn @endif
                @endif
                "

                    @if (isset($item['header'])) data-header="{{ $item['header'] }}" @endif

                    data-url={{ $item['url'] }}
                    data-id="{{ isset($data) ? $data->id : '' }}"
                    @if (isset($item['link'])) href="{{ $item['url'] }}"
                @else
                    href="javascript::void(0)" @endif
                    >
                    {{-- closing anchor tag --}}
                    @if (isset($item['icon']))
                    {!! $item['icon'] !!}
                    {{-- {{$item['name']}} --}}
                    @else
                        @if ($item['name'] == 'edit')
                            <i class="fa fa-edit"></i>
                            {{-- Edit --}}
                        @elseif($item['name'] == 'delete')
                            <i class="fa fa-trash"></i>
                            {{-- Delete --}}
                        @elseif($item['name'] == 'show')
                            <i class="fa fa-eye"></i>
                            {{-- Show --}}                        
                        @elseif($item['name'] == 'View Service')
                            <i class="fa fa-eye"></i>
                        @else
                            <i class="fa fa-circle"></i>
                            {{ $item['name'] }}
                        @endif
                    @endif

                </a>
            </li>
        @endforeach
    </ul>
@endif
