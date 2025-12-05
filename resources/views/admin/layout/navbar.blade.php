	<!-- HEADER -->
  <div class="header app-header">
    <div class="container-fluid">
      <div class="d-flex">
         <a class="header-brand" href="{{url(guardName().'/dashboard')}}">          
          <h2 class="pt-3 m-auto text-white">{{config('constant.app_name')}}</h2>
        </a><!-- LOGO -->
        <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a>
        <div class="d-flex order-lg-2 ml-auto header-right-icons header-search-icon">
            <a href="#" data-toggle="search" class="nav-link nav-link-lg d-md-none navsearch"><i class="fa fa-search"></i></a>
          <div class="" hidden>
            <form class="form-inline">
              <div class="search-element">
                <input type="search" class="form-control header-search" placeholder="Search…" aria-label="Search" tabindex="1">
                <button class="btn btn-primary-color" type="submit"><i class="fa fa-search"></i></button>
              </div>
            </form>
          </div><!-- SEARCH -->
          <div class="dropdown d-md-flex" hidden>
            <a class="nav-link icon full-screen-link nav-link-bg" id="fullscreen-button">
              <i class="fe fe-maximize-2" ></i>
            </a>
          </div><!-- FULL-SCREEN -->
          <div class="dropdown d-md-flex notifications" style="display: none!important">
            <a class="nav-link icon" data-toggle="dropdown">
              <i class="fe fe-bell"></i>
              <span class="pulse bg-warning"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
              <div class="drop-heading">
                <div class="d-flex">
                  <h5 class="mb-0 text-dark">Notifications</h5>
                  <span class="badge badge-danger ml-auto  brround">4</span>
                </div>
              </div>
              <div class="dropdown-divider mt-0"></div>
                <a href="#" class="dropdown-item mt-2 d-flex pb-3">
                <div class="notifyimg bg-success-transparent">
                  <i class="fa fa-thumbs-o-up text-success"></i>
                </div>
                <div>
                  <strong>Someone likes our posts.</strong>
                  <div class="small text-muted">3 hours ago</div>
                </div>
              </a>
              <a href="#" class="dropdown-item d-flex pb-3">
                <div class="notifyimg bg-primary-transparent">
                  <i class="fa fa-exclamation-triangle text-primary"></i>
                </div>
                <div>
                  <strong> Issues Fixed</strong>
                  <div class="small text-muted">30 mins ago</div>
                </div>
              </a>
              <a href="#" class="dropdown-item d-flex pb-3">
                <div class="notifyimg bg-warning-transparent">
                  <i class="fa fa-commenting-o text-warning"></i>
                </div>
                <div>
                  <strong> 3 New Comments</strong>
                  <div class="small text-muted">5  hour ago</div>
                </div>
              </a>
              <a href="#" class="dropdown-item d-flex pb-3">
                <div class="notifyimg bg-danger-transparent">
                  <i class="fa fa-cogs text-danger"></i>
                </div>
                <div>
                  <strong> Server Rebooted.</strong>
                  <div class="small text-muted">45 mintues ago</div>
                </div>
              </a>
              <div class="dropdown-divider mb-0"></div>
              <div class=" text-center p-2">
                <a href="#" class="text-dark pt-0">View All Notifications</a>
              </div>
            </div>
          </div><!-- NOTIFICATIONS -->
          <div class="dropdown d-md-flex message" style="display: none!important">
            <a class="nav-link icon text-center" data-toggle="dropdown">
              <i class="fe fe-mail "></i>
              <span class="badge badge-danger">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
              <div class="drop-heading">
                <div class="d-flex">
                  <h5 class="mb-0 text-dark">Messages</h5>
                  <span class="badge badge-danger ml-auto  brround">3</span>
                </div>
              </div>
              <div class="dropdown-divider mt-0"></div>
              <a href="#" class="dropdown-item d-flex mt-2 pb-3">
                <div class="avatar avatar-md brround mr-3 d-block cover-image" data-image-src="{{asset('theme/assets/images/users/male/41.jpg')}}">
                  <span class="avatar-status bg-green"></span>
                </div>
                <div>
                  <strong>Madeleine</strong>
                  <p class="mb-0 fs-13 text-muted ">Hey! there I' am available</p>
                  <div class="small text-muted">3 hours ago</div>
                </div>
              </a>
              <a href="#" class="dropdown-item d-flex pb-3">
                <div class="avatar avatar-md brround mr-3 d-block cover-image" data-image-src="{{asset('theme/assets/images/users/female/1.jpg')}}">
                  <span class="avatar-status bg-red"></span>
                </div>
                <div>
                  <strong>Anthony</strong>
                  <p class="mb-0 fs-13 text-muted ">New product Launching</p>
                  <div class="small text-muted">5  hour ago</div>
                </div>
              </a>
              <a href="#" class="dropdown-item d-flex pb-3">
                <div class="avatar avatar-md brround mr-3 d-block cover-image" data-image-src="{{asset('theme/assets/images/users/female/18.jpg')}}">
                  <span class="avatar-status bg-yellow"></span>
                </div>
                <div>
                  <strong>Olivia</strong>
                  <p class="mb-0 fs-13 text-muted ">New Schedule Realease</p>
                  <div class="small text-muted">45 mintues ago</div>
                </div>
              </a>
              <div class="dropdown-divider mb-0"></div>
              <div class=" text-center p-2">
                <a href="#" class="text-dark pt-0">View All Messages</a>
              </div>
            </div>
          </div><!-- MESSAGE-BOX -->
          <div class="dropdown d-md-flex header-settings">
            <a href="#" class="nav-link " data-toggle="dropdown">
              <span><img src="{{asset(viewImage(authUser()->image))}}" alt="profile-user" class="avatar brround cover-image mb-0 ml-0"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
              {{-- <div class="drop-heading  text-center border-bottom pb-3">
                <h5 class="text-dark mb-1">{{authUser()->name}}</h5>
                <small class="text-muted">{{authUser()->first_name}} {{authUser()->last_name}} <br> ( {{authUser()->myRole ? authUser()->myRole->role->name : ''}} )</small>
              </div> --}}
              <a class="dropdown-item" href="{{url(guardName().'/my-profile')}}"><i class="mdi mdi-account-outline mr-2"></i> <span>My profile</span></a>              
              <a class="dropdown-item" href=""
              onclick="event.preventDefault();$(this).next('form').submit()"
              ><i class="mdi  mdi-logout-variant mr-2"></i> <span>Logout</span></a>
              <form action="{{url(guardName().'/logout')}}" method="post" hidden>
              @csrf
              </form>
            </div>
          </div><!-- SIDE-MENU -->
          <div class="sidebar-link" hidden>
            <a href="#" class="nav-link icon" data-toggle="sidebar-right" data-target=".sidebar-right">
              <i class="fe fe-align-right" ></i>
            </a>
          </div><!-- FULL-SCREEN -->
        </div>
      </div>
    </div>
  </div>
  <!-- HEADER END -->