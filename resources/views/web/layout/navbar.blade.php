<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container-fluid">
        <a href="{{url('/')}}"><img src="{{asset('images/meeting-logo3.png')}}" style="width:60px"></a>
        <button class="navbar-toggler text-center"
            style="padding-left: 5px 8px !important; border:none !important;" data-toggle="collapse"
            onclick=openClose(); data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="menu_open_close">
            <ul class="navbar-nav ml-auto">
                @if(authCheck())
                <li class="nav-item" style="padding: 12px;
                background: rgb(208 181 181 / 20%);
                border-radius: 39px;
                font-weight: bold;"><a href="javascript::void(0)"
                        style="font-family: Raleway;">Welcome, {{authUser()->first_name}}</a></li>
                <li class="nav-item"><a href="{{url('dashboard')}}"
                    class="nav-link hover-underline-animation" style="font-family: Raleway;">History</a></li>
                @endif
                 {{-- <li class="nav-item"><a href="{{url('live-mr')}}"
                        class="nav-link hover-underline-animation" style="font-family: Raleway;">Live M.R
                        Status</a></li>  --}}
                <li class="nav-item"><a 
                @if(Request::url() == url('dashboard'))
                    href="{{url('/')}}" 
                    @else
                    href="#meeting_room" 
                    @endif
                    class="nav-link hover-underline-animation"
                        style="font-family: Raleway;">{{config('constant.app_name')}}</a></li>
                @if(auth()->check())
                    <li class="nav-item cta text-center">
                        <a href="{{url('/logout')}}" onclick="event.preventDefault();$(this).next('form').submit()" class="nav-link ml-3"><span style="color:#fff; display: inline-block;">Logout</span></a>
                        <form action="{{url('/logout')}}" method="post" hidden>
                            @csrf
                        </form>                        
                    </li>
                @else
                            <li class="nav-item cta text-center" data-toggle="modal" data-target="#loginModal"><a href="javascript::void(0)" class="nav-link ml-3"><span
                                        style="color:#fff; display: inline-block;">Login</span></a>
                                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>