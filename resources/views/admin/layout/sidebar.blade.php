<aside class="app-sidebar left-menu2">
  <ul class="side-menu">    
    <li class="@if(Request::url() == url(guardName().'/dashboard')) active @endif">
      <a class="side-menu__item" href="{{url(guardName().'/dashboard')}}"><i class="side-menu__icon  fe fe-circle"></i><span class="side-menu__label">Dashboard</span></a>
    </li>        
    <li class="@if(Request::url() == url(guardName().'/freelancer')) active @endif">
      <a class="side-menu__item" href="{{url(guardName().'/freelancer')}}"><i class="side-menu__icon  fe fe-circle"></i><span class="side-menu__label">Freelancer</span></a>
    </li>               
    <li class="@if(Request::url() == url(guardName().'/client')) active @endif">
      <a class="side-menu__item" href="{{url(guardName().'/client')}}"><i class="side-menu__icon  fe fe-circle"></i><span class="side-menu__label">Client</span></a>
    </li>               
    <li class="@if(Request::url() == url(guardName().'/category')) active @endif">
      <a class="side-menu__item" href="{{url(guardName().'/category')}}"><i class="side-menu__icon  fe fe-circle"></i><span class="side-menu__label">Project Category</span></a>
    </li>               
    <li class="@if(Request::url() == url(guardName().'/project')) active @endif">
      <a class="side-menu__item" href="{{url(guardName().'/project')}}"><i class="side-menu__icon  fe fe-circle"></i><span class="side-menu__label">Project</span></a>
    </li>               
    <li class="@if(Request::url() == url(guardName().'/application')) active @endif">
      <a class="side-menu__item" href="{{url(guardName().'/application')}}"><i class="side-menu__icon  fe fe-circle"></i><span class="side-menu__label">Application</span></a>
    </li>               
    <li class="@if(Request::url() == url(guardName().'/cancellation-requests')) active @endif">
      <a class="side-menu__item" href="{{url(guardName().'/cancellation-requests')}}"><i class="side-menu__icon  fe fe-circle"></i><span class="side-menu__label">Cancellation Requests</span></a>
    </li>               
    <li class="@if(Request::url() == url(guardName().'/payment-history')) active @endif">
      <a class="side-menu__item" href="{{url(guardName().'/payment-history')}}"><i class="side-menu__icon  fe fe-circle"></i><span class="side-menu__label">Payment History</span></a>
    </li>               
    <li class="@if(Request::url() == url(guardName().'/technology')) active @endif">
      <a class="side-menu__item" href="{{url(guardName().'/technology')}}"><i class="side-menu__icon  fe fe-circle"></i><span class="side-menu__label">Core Technology</span></a>
    </li>               
    <li class="@if(Request::url() == url(guardName().'/language')) active @endif">
      <a class="side-menu__item" href="{{url(guardName().'/language')}}"><i class="side-menu__icon  fe fe-circle"></i><span class="side-menu__label">Programming Language</span></a>
    </li>               
    <li class="@if(Request::url() == url(guardName().'/lang')) active @endif">
      <a class="side-menu__item" href="{{url(guardName().'/lang')}}"><i class="side-menu__icon  fe fe-circle"></i><span class="side-menu__label">Language Spoken</span></a>
    </li>               
    
    <!-- <li class="@if(Request::url() == url(guardName().'/user')) active @endif">
      <a class="side-menu__item" href="{{url(guardName().'/user')}}"><i class="side-menu__icon  fe fe-circle"></i><span class="side-menu__label">User</span></a>
    </li>               
    <li class="@if(Request::url() == url(guardName().'/role')) active @endif">
      <a class="side-menu__item" href="{{url(guardName().'/role')}}"><i class="side-menu__icon  fe fe-circle"></i><span class="side-menu__label">role</span></a>
    </li>               
    <li class="@if(Request::url() == url(guardName().'/permission')) active @endif">
      <a class="side-menu__item" href="{{url(guardName().'/permission')}}"><i class="side-menu__icon  fe fe-circle"></i><span class="side-menu__label">permission</span></a>
    </li>                -->
  
  </ul>
</aside>
<style>
  .side-menu li.active{
    background:#564ec1;
  }
</style>