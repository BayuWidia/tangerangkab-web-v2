<a href="{{ url('')}}" class="logo">
  <!-- mini logo for sidebar mini 50x50 pixels -->
  <span class="logo-mini"><b>AD</b></span>
  <!-- logo for regular state and mobile devices -->
  @if(Auth::user()->level=="1")
    <span class="logo-lg" style="font-size:18px;"><b>Admin</b> Web Terpadu</span>
  @else
    <span class="logo-lg" style="font-size:18px;"><b>Admin</b> {{Auth::user()->masterskpd->singkatan}}</span>
  @endif
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- User Account: style can be found in dropdown.less -->
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          @if(Auth::user()->url_foto=="")
            <img src="{{ url('images') }}/user-not-found.png" class="user-image" alt="User Image">
          @else
            <img src="{{ url('images') }}/{{Auth::user()->url_foto}}" class="user-image" alt="User Image">
          @endif
          <span class="hidden-xs">
            @if(Auth::user()->name=="")
              {{Auth::user()->email}}
            @else
              {{Auth::user()->name}}
            @endif
          </span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            @if(Auth::user()->url_foto=="")
              <img src="{{ url('images') }}/user-not-found.png" class="img-circle" alt="User Image">
            @else
              <img src="{{ url('images') }}/{{Auth::user()->url_foto}}" class="img-circle" alt="User Image">
            @endif

            <p>
              @if(Auth::user()->name=="")
                {{Auth::user()->email}}
              @else
                {{Auth::user()->name}}
              @endif
              <small>
                Terdaftar tahun
                <?php
                  $tanggal = Auth::user()->created_at;
                  $potong = substr($tanggal, 0, 4);
                  echo $potong;
                 ?>
              </small>
            </p>
          </li>

          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
              <a href="{{route('profile.index')}}" class="btn btn-default btn-flat">Profile</a>
            </div>
            <div class="pull-right">
              <a href="{{route('logout')}}" class="btn btn-default btn-flat">Sign out</a>
            </div>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
