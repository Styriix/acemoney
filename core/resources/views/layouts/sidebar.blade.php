<div id="sidebar" class="sidebar">
      <div data-scrollbar="true" data-height="100%">
        <ul class="nav text-center">
          <li class="nav-profile">
            <div class="info">
              <a href="{{route('home')}}" style="text-decoration: none; font-size: 15px; color: #ddd;">{{Auth::user()->name}}</a>
              
              <small>{{Auth::user()->username}}</small>
            </div>
          </li>
        </ul>
        <ul class="nav" style="text-transform: uppercase;">
          <li class="@if(request()->path() == 'home') active @endif"><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
           <li class="@if(request()->path() == 'home/all-address') active @endif">
                <a href="{{route('addresses')}}"><i class="fa fa-bars" aria-hidden="true"></i> <span>All Addresses</span></a>
            </li>
            <li class="@if(request()->path() == 'home/transactions') active @endif">
                <a href="{{route('transactions')}}"><i class="fa fa-exchange" aria-hidden="true"></i> <span>Transactions</span></a>
            </li> 
     
            <li class="@if(request()->path() == 'home/change/password') active @endif">
                <a href="{{route('changepass')}}"><i class="fa fa-lock" aria-hidden="true"></i> <span>Password</span></a>
            </li> 
            <li class="@if(request()->path() == 'home/g2fa') active @endif">
              <a href="{{route('go2fa')}}"><i class="fa fa-shield" aria-hidden="true"></i> <span>Security</span></a>
            </li>

            <li>
              <a href="{{ route('logout') }}"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i>
              <span>SIGN OUT</span>
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
          </form>
          </li>
                 
              <!-- begin sidebar minify button -->
          <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
              <!-- end sidebar minify button -->
        </ul>
        <!-- end sidebar nav -->
      </div>
      <!-- end sidebar scrollbar -->
    </div>
    <div class="sidebar-bg"></div>
    <!-- end #sidebar -->