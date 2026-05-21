<div class="d-flex align-items-stretch">
    <nav id="sidebar" style="background-color: white;">
      <div class="sidebar-header d-flex align-items-center">
        <div class="title">
          <h1 class="h5" style="color: black; padding-bottom: 10px;">{{ Auth()->user()->email }}</h1>
          <p style="color: white; background-color: #10b2a6; border-radius: 10px; padding: 5px 10px; font-size: 12px; display: inline-block; font-weight: bold;">FYP Coordinator</p>
        </div>
      </div>
      <span class="heading">Main</span>
      <ul class="list-unstyled">

        @php
          $navActive = 'background-color: rgba(16,178,166,0.12); border-left: 3px solid #10b2a6; font-weight: 600;';
          $linkActive = 'color: #10b2a6 !important;';
        @endphp

        <li style="{{ request()->routeIs('home') ? $navActive : '' }}">
          <a href="{{ route('home') }}" style="{{ request()->routeIs('home') ? $linkActive : '' }}">
            <i class="icon-home"></i>Home
          </a>
        </li>

        <li style="{{ request()->routeIs('fypstudentList') || request()->routeIs('fyplecturerList') ? $navActive : '' }}">
          <a href="#registerDropdown" aria-expanded="{{ request()->routeIs('fypstudentList') || request()->routeIs('fyplecturerList') ? 'true' : 'false' }}" data-toggle="collapse"
             style="{{ request()->routeIs('fypstudentList') || request()->routeIs('fyplecturerList') ? $linkActive : '' }}">
            <i class="icon-windows"></i>Register User
          </a>
          <ul id="registerDropdown" class="collapse list-unstyled {{ request()->routeIs('fypstudentList') || request()->routeIs('fyplecturerList') ? 'show' : '' }}">
            <li style="{{ request()->routeIs('fypstudentList') ? $navActive : '' }}">
              <a href="{{ route('fypstudentList') }}" style="{{ request()->routeIs('fypstudentList') ? $linkActive : '' }}">
                <i class="icon-user-1"></i>Student
              </a>
            </li>
            <li style="{{ request()->routeIs('fyplecturerList') ? $navActive : '' }}">
              <a href="{{ route('fyplecturerList') }}" style="{{ request()->routeIs('fyplecturerList') ? $linkActive : '' }}">
                <i class="icon-user-1"></i>Lecturer
              </a>
            </li>
          </ul>
        </li>

        <li style="{{ request()->routeIs('uploadUser') ? $navActive : '' }}">
          <a href="{{ route('uploadUser') }}" style="{{ request()->routeIs('uploadUser') ? $linkActive : '' }}">
            <i class="bi bi-upload"></i>Upload Users
          </a>
        </li>

        <li style="{{ request()->routeIs('manageQuota') || request()->routeIs('updateQuota') ? $navActive : '' }}">
          <a href="{{ route('manageQuota') }}" style="{{ request()->routeIs('manageQuota') || request()->routeIs('updateQuota') ? $linkActive : '' }}">
            <i class="fa fa-bar-chart"></i>Quota
          </a>
        </li>

        <li style="{{ request()->routeIs('manageTimeFrame') ? $navActive : '' }}">
          <a href="{{ route('manageTimeFrame') }}" style="{{ request()->routeIs('manageTimeFrame') ? $linkActive : '' }}">
            <i class="bi bi-calendar3-week"></i>Time Frame
          </a>
        </li>

        <li style="{{ request()->routeIs('userList') ? $navActive : '' }}">
          <a href="{{ route('userList') }}" style="{{ request()->routeIs('userList') ? $linkActive : '' }}">
            <i class="bi bi-people"></i>User List
          </a>
        </li>

        <li style="{{ request()->routeIs('notifications') ? $navActive : '' }}">
          <a href="{{ route('notifications') }}" style="{{ request()->routeIs('notifications') ? $linkActive : '' }}">
            <i class="bi bi-bell"></i>Notifications
          </a>
        </li>

      </ul>
    </nav>
    <!-- Sidebar Navigation end-->
