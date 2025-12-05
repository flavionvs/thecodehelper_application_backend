<!-- SIDE-BAR -->
<div class="sidebar sidebar-right sidebar-animate">
    <div class="p-3">
        <a href="#" class="text-right float-right" data-toggle="sidebar-right" data-target=".sidebar-right"><i class="fe fe-x"></i></a>
    </div>
    <div class="tab-menu-heading siderbar-tabs border-0">
        <div class="tabs-menu ">
            <!-- Tabs -->
            <ul class="nav panel-tabs">
                <li class=""><a href="#tab" class="active show" data-toggle="tab">Profile</a></li>
                <li class=""><a href="#tab1" data-toggle="tab" class="">Friends</a></li>
                <li><a href="#tab2" data-toggle="tab" class="">Activity</a></li>
                <li><a href="#tab3" data-toggle="tab" class="">Todo</a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body tabs-menu-body side-tab-body p-0 border-0 ">
        <div class="tab-content border-top">
            <div class="tab-pane active" id="tab">
                <div class="card-body p-0">
                    <div class="header-user text-center mt-4 pb-4">
                        <span class="avatar avatar-xxl brround"><img src="{{asset('theme/assets/images/users/male/32.jpg')}}" alt="Profile-img" class="avatar avatar-xxl brround"></span>
                        <div class="dropdown-item text-center font-weight-semibold user h3 mb-0">Jonathan Mills</div>
                        <small>App Developer</small>
                        <div class="card-body">
                            <div class="form-group ">
                                <label class="form-label  text-left">Offline/Online</label>
                                <select class="form-control select2 " data-placeholder="Choose one select2">
                                    <option label="Choose one">
                                    </option>
                                    <option value="1">Online</option>
                                    <option value="2">Offline</option>
                                </select>
                            </div>
                            <div class="form-group ">
                                <label class="form-label text-left">Website</label>
                                <select class="form-control select2 " data-placeholder="Choose one select2">
                                    <option label="Choose one">
                                    </option>
                                    <option value="1">Spruko.com</option>
                                    <option value="2">sprukosoft.com</option>
                                    <option value="3">sprukotechnologies.com</option>
                                    <option value="4">sprukoinfo.com</option>
                                    <option value="5">sprukotech.com</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <a class="dropdown-item  border-top" href="#">
                        <i class="dropdown-icon mdi mdi-account-edit"></i> Edit Profile
                    </a>
                    <a class="dropdown-item  border-top" href="#">
                        <i class="dropdown-icon mdi mdi-account-outline"></i> Spruko technologies
                    </a>
                    <a class="dropdown-item border-top" href="#">
                        <i class="dropdown-icon  mdi mdi-account-plus"></i> Add Another Account
                    </a>
                    <a class="dropdown-item  border-top" href="#">
                        <i class="dropdown-icon mdi mdi-comment-check-outline"></i> Message
                    </a>
                    <a class="dropdown-item  border-top" href="#">
                        <i class="dropdown-icon mdi mdi-compass-outline"></i> Need Help??
                    </a>
                    <div class="card-body border-top border-bottom">
                        <h4>Gallery</h4>
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="avatar-list">
                                    <span class="avatar avatar-lg cover-image"  data-image-src="{{asset('theme/assets/images/users/female/17.jpg')}}"></span>
                                    <span class="avatar avatar-lg cover-image"  data-image-src="{{asset('theme/assets/images/photos/2.jpg')}}"></span>
                                    <span class="avatar avatar-lg cover-image"  data-image-src="{{asset('theme/assets/images/photos/3.jpg')}}"></span>
                                    <span class="avatar avatar-lg cover-image"  data-image-src="{{asset('theme/assets/images/photos/5.jpg')}}"></span>
                                    <span class="avatar avatar-lg cover-image"  data-image-src="{{asset('theme/assets/images/users/male/3.jpg')}}"></span>
                                    <span class="avatar avatar-lg cover-image"  data-image-src="{{asset('theme/assets/images/photos/15.jpg')}}"></span>
                                    <span class="avatar avatar-lg cover-image"  data-image-src="{{asset('theme/assets/images/photos/16.jpg')}}"></span>
                                    <span class="avatar avatar-lg cover-image"  >+48</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-top border-bottom">
                        <div class="row">
                            <div class="col-4 text-center">
                                <a class="" href=""><i class="dropdown-icon mdi  mdi-message-outline fs-30 m-0 leading-tight"></i></a>
                                <div>Inbox</div>
                            </div>
                            <div class="col-4 text-center">
                                <a class="" href=""><i class="dropdown-icon mdi mdi-tune fs-30 m-0 leading-tight"></i></a>
                                <div>Settings</div>
                            </div>
                            <div class="col-4 text-center">
                                <a class="" href=""><i class="dropdown-icon mdi mdi-logout-variant fs-30 m-0 leading-tight"></i></a>
                                <div>Sign out</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab1">
                <div class="chat">
                    <div class="contacts_card">
                        <div class="input-group p-3">
                            <input type="text" placeholder="Search..." class="form-control search">
                            <div class="input-group-prepend">
                                <span class="input-group-text search_btn "><i class="fa fa-search text-white"></i></span>
                            </div>
                        </div>
                        <div class="contacts mb-0">
                            <div class="list-group list-group-flush ">
                                <div class="list-group-item d-flex  align-items-center">
                                    <div class="mr-2">
                                        <span class="avatar  brround avatar-md cover-image" data-image-src="{{asset('theme/assets/images/users/female/1.jpg')}}"><span class="avatar-status bg-green"></span></span>
                                    </div>
                                    <div class="">
                                        <div class="font-weight-semibold">Darlena Torian</div>
                                    </div>
                                    <div class="ml-auto">
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-phone fs-10"></i></a>
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-comment fs-10"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div class="mr-2">
                                        <span class="avatar brround avatar-md cover-image" data-image-src="{{asset('theme/assets/images/users/male/2.jpg')}}" style="background: url(&quot;{{asset('theme/assets/images/users/male/2.jpg')}}&quot;) center center;"></span>
                                    </div>
                                    <div class="">
                                        <div class="font-weight-semibold">Richie Verrill</div>
                                    </div>
                                    <div class="ml-auto">
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-phone fs-10"></i></a>
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-comment fs-10"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div class="mr-2">
                                        <span class="avatar brround avatar-md cover-image" data-image-src="{{asset('theme/assets/images/users/female/3.jpg')}}" style="background: url(&quot;{{asset('theme/assets/images/users/female/3.jpg')}}&quot;) center center;"><span class="avatar-status bg-green"></span></span>
                                    </div>
                                    <div class="">
                                        <div class="font-weight-semibold">Cheree Morgan</div>
                                    </div>
                                    <div class="ml-auto">
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-phone fs-10"></i></a>
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-comment fs-10"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div class="mr-2">
                                        <span class="avatar brround avatar-md cover-image" data-image-src="{{asset('theme/assets/images/users/female/4.jpg')}}" style="background: url(&quot;{{asset('theme/assets/images/users/female/4.jpg')}}&quot;) center center;"><span class="avatar-status bg-green"></span></span>
                                    </div>
                                    <div class="">
                                        <div class="font-weight-semibold">Katerine Coit</div>
                                    </div>
                                    <div class="ml-auto">
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-phone fs-10"></i></a>
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-comment fs-10"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div class="mr-2">
                                        <span class="avatar  brround avatar-md cover-image" data-image-src="{{asset('theme/assets/images/users/male/5.jpg')}}" style="background: url(&quot;{{asset('theme/assets/images/users/male/5.jpg')}}&quot;) center center;"><span class="avatar-status bg-green"></span></span>
                                    </div>
                                    <div class="">
                                        <div class="font-weight-semibold">Hai Indelicato</div>
                                    </div>
                                    <div class="ml-auto">
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-phone fs-10"></i></a>
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-comment fs-10"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div class="mr-2">
                                        <span class="avatar brround avatar-md cover-image" data-image-src="{{asset('theme/assets/images/users/female/6.jpg')}}" style="background: url(&quot;{{asset('theme/assets/images/users/female/6.jpg')}}&quot;) center center;"></span>
                                    </div>
                                    <div class="">
                                        <div class="font-weight-semibold">Cecilia Kerfoot</div>
                                    </div>
                                    <div class="ml-auto">
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-phone fs-10"></i></a>
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-comment fs-10"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div class="mr-2">
                                        <span class="avatar brround avatar-md cover-image" data-image-src="{{asset('theme/assets/images/users/male/7.jpg')}}" style="background: url(&quot;{{asset('theme/assets/images/users/male/7.jpg')}}&quot;) center center;"><span class="avatar-status bg-green"></span></span>
                                    </div>
                                    <div class="">
                                        <div class="font-weight-semibold">Ronald Zirbel</div>
                                    </div>
                                    <div class="ml-auto">
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-phone fs-10"></i></a>
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-comment fs-10"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div class="mr-2">
                                        <span class="avatar brround avatar-md cover-image" data-image-src="{{asset('theme/assets/images/users/male/8.jpg')}}" style="background: url(&quot;{{asset('theme/assets/images/users/male/8.jpg')}}&quot;) center center;"><span class="avatar-status bg-green"></span></span>
                                    </div>
                                    <div class="">
                                        <div class="font-weight-semibold">Darren Niemann</div>
                                    </div>
                                    <div class="ml-auto">
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-phone fs-10"></i></a>
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-comment fs-10"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div class="mr-2">
                                        <span class="avatar  brround avatar-md cover-image" data-image-src="{{asset('theme/assets/images/users/female/9.jpg')}}" style="background: url(&quot;{{asset('theme/assets/images/users/female/9.jpg')}}&quot;) center center;"><span class="avatar-status bg-green"></span></span>
                                    </div>
                                    <div class="">
                                        <div class="font-weight-semibold">Sibyl Cogley</div>
                                    </div>
                                    <div class="ml-auto">
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-phone fs-10"></i></a>
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-comment fs-10"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div class="mr-2">
                                        <span class="avatar brround avatar-md cover-image" data-image-src="{{asset('theme/assets/images/users/male/10.jpg')}}" style="background: url(&quot;{{asset('theme/assets/images/users/male/10.jpg')}}&quot;) center center;"></span>
                                    </div>
                                    <div class="">
                                        <div class="font-weight-semibold">Jess Hildebrandt</div>
                                    </div>
                                    <div class="ml-auto">
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-phone fs-10"></i></a>
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-comment fs-10"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div class="mr-2">
                                        <span class="avatar brround avatar-md cover-image" data-image-src="{{asset('theme/assets/images/users/female/11.jpg')}}" style="background: url(&quot;{{asset('theme/assets/images/users/female/11.jpg')}}&quot;) center center;"><span class="avatar-status bg-green"></span></span>
                                    </div>
                                    <div class="">
                                        <div class="font-weight-semibold">Wanita Sheppard</div>
                                    </div>
                                    <div class="ml-auto">
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-phone fs-10"></i></a>
                                        <a href="#" class="btn btn-sm btn-default-light btn-icon"><i class="fa fa-comment fs-10"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab2">
                <div class="list d-flex align-items-center border-bottom p-4">
                    <div class="">
                        <span class="avatar bg-primary brround avatar-md">CH</span>
                    </div>
                    <div class="wrapper w-100 ml-3">
                        <p class="mb-0 d-flex">
                            <b>New Websites is Created</b>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-clock text-muted mr-1"></i>
                                <small class="text-muted ml-auto">30 mins ago</small>
                                <p class="mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list d-flex align-items-center border-bottom p-4">
                    <div class="">
                        <span class="avatar bg-danger brround avatar-md">N</span>
                    </div>
                    <div class="wrapper w-100 ml-3">
                        <p class="mb-0 d-flex">
                            <b>Prepare For the Next Project</b>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-clock text-muted mr-1"></i>
                                <small class="text-muted ml-auto">2 hours ago</small>
                                <p class="mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list d-flex align-items-center border-bottom p-4">
                    <div class="">
                        <span class="avatar bg-info brround avatar-md">S</span>
                    </div>
                    <div class="wrapper w-100 ml-3">
                        <p class="mb-0 d-flex">
                            <b>Decide the live Discussion Time</b>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-clock text-muted mr-1"></i>
                                <small class="text-muted ml-auto">3 hours ago</small>
                                <p class="mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list d-flex align-items-center border-bottom p-4">
                    <div class="">
                        <span class="avatar bg-warning brround avatar-md">K</span>
                    </div>
                    <div class="wrapper w-100 ml-3">
                        <p class="mb-0 d-flex">
                            <b>Team Review meeting at yesterday at 3:00 pm</b>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-clock text-muted mr-1"></i>
                                <small class="text-muted ml-auto">4 hours ago</small>
                                <p class="mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list d-flex align-items-center border-bottom p-4">
                    <div class="">
                        <span class="avatar bg-success brround avatar-md">R</span>
                    </div>
                    <div class="wrapper w-100 ml-3">
                        <p class="mb-0 d-flex">
                            <b>Prepare for Presentation</b>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-clock text-muted mr-1"></i>
                                <small class="text-muted ml-auto">1 days ago</small>
                                <p class="mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list d-flex align-items-center  border-bottom p-4">
                    <div class="">
                        <span class="avatar bg-pink brround avatar-md">MS</span>
                    </div>
                    <div class="wrapper w-100 ml-3">
                        <p class="mb-0 d-flex">
                            <b>Prepare for Presentation</b>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-clock text-muted mr-1"></i>
                                <small class="text-muted ml-auto">1 days ago</small>
                                <p class="mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list d-flex align-items-center border-bottom p-4">
                    <div class="">
                        <span class="avatar bg-purple brround avatar-md">L</span>
                    </div>
                    <div class="wrapper w-100 ml-3">
                        <p class="mb-0 d-flex">
                            <b>Prepare for Presentation</b>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-clock text-muted mr-1"></i>
                                <small class="text-muted ml-auto">45 mintues ago</small>
                                <p class="mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list d-flex align-items-center p-4">
                    <div class="">
                        <span class="avatar bg-blue brround avatar-md">U</span>
                    </div>
                    <div class="wrapper w-100 ml-3">
                        <p class="mb-0 d-flex">
                            <b>Prepare for Presentation</b>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-clock text-muted mr-1"></i>
                                <small class="text-muted ml-auto">2 days ago</small>
                                <p class="mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab3">
                <div class="">
                    <div class="d-flex p-3">
                        <label class="custom-control custom-checkbox mb-0">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked="">
                            <span class="custom-control-label">Do Even More..</span>
                        </label>
                        <span class="ml-auto">
                            <i class="si si-pencil text-primary mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Edit"></i>
                            <i class="si si-trash text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
                        </span>
                    </div>
                    <div class="d-flex p-3 border-top">
                        <label class="custom-control custom-checkbox mb-0">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2" checked="">
                            <span class="custom-control-label">Find an idea.</span>
                        </label>
                        <span class="ml-auto">
                            <i class="si si-pencil text-primary mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Edit"></i>
                            <i class="si si-trash text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
                        </span>
                    </div>
                    <div class="d-flex p-3 border-top">
                        <label class="custom-control custom-checkbox mb-0">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox3" value="option3" checked="">
                            <span class="custom-control-label">Hangout with friends</span>
                        </label>
                        <span class="ml-auto">
                            <i class="si si-pencil text-primary mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Edit"></i>
                            <i class="si si-trash text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
                        </span>
                    </div>
                    <div class="d-flex p-3 border-top">
                        <label class="custom-control custom-checkbox mb-0">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox4" value="option4">
                            <span class="custom-control-label">Do Something else</span>
                        </label>
                        <span class="ml-auto">
                            <i class="si si-pencil text-primary mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Edit"></i>
                            <i class="si si-trash text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
                        </span>
                    </div>
                    <div class="d-flex p-3 border-top">
                        <label class="custom-control custom-checkbox mb-0">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox5" value="option5">
                            <span class="custom-control-label">Eat healthy, Eat Fresh..</span>
                        </label>
                        <span class="ml-auto">
                            <i class="si si-pencil text-primary mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Edit"></i>
                            <i class="si si-trash text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
                        </span>
                    </div>
                    <div class="d-flex p-3 border-top">
                        <label class="custom-control custom-checkbox mb-0">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox6" value="option6" checked="">
                            <span class="custom-control-label">Finsh something more..</span>
                        </label>
                        <span class="ml-auto">
                            <i class="si si-pencil text-primary mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Edit"></i>
                            <i class="si si-trash text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
                        </span>
                    </div>
                    <div class="d-flex p-3 border-top">
                        <label class="custom-control custom-checkbox mb-0">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox7" value="option7" checked="">
                            <span class="custom-control-label">Do something more</span>
                        </label>
                        <span class="ml-auto">
                            <i class="si si-pencil text-primary mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Edit"></i>
                            <i class="si si-trash text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
                        </span>
                    </div>
                    <div class="d-flex p-3 border-top">
                        <label class="custom-control custom-checkbox mb-0">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox8" value="option8">
                            <span class="custom-control-label">Updated more files</span>
                        </label>
                        <span class="ml-auto">
                            <i class="si si-pencil text-primary mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Edit"></i>
                            <i class="si si-trash text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
                        </span>
                    </div>
                    <div class="d-flex p-3 border-top">
                        <label class="custom-control custom-checkbox mb-0">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox9" value="option9">
                            <span class="custom-control-label">System updated</span>
                        </label>
                        <span class="ml-auto">
                            <i class="si si-pencil text-primary mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Edit"></i>
                            <i class="si si-trash text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
                        </span>
                    </div>
                    <div class="d-flex p-3 border-top border-bottom">
                        <label class="custom-control custom-checkbox mb-0">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox10" value="option10">
                            <span class="custom-control-label">Settings Changings...</span>
                        </label>
                        <span class="ml-auto">
                            <i class="si si-pencil text-primary mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Edit"></i>
                            <i class="si si-trash text-danger mr-2" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete"></i>
                        </span>
                    </div>
                    <div class="text-center pt-5">
                        <a href="#" class="btn btn-primary">Add more</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>