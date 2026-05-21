<div class="d-flex align-items-stretch">
    <nav id="sidebar" class="bg-white">
      <div class="sidebar-header d-flex align-items-center bg-white">
        <div class="title">
          <h1 class="h5" style="color: black; padding-bottom: 10px;">{{ Auth()->user()->email }}</h1>
          <p style="color: white; background-color: #1468b0; border-radius: 10px; padding: 5px 10px; font-size: 12px; display: inline-block; font-weight: bold;">Lecturer</p>
        </div>
      </div>
      <span class="heading text-dark">Main</span>
      <ul class="list-unstyled">

        @php
          $navActive = 'background-color: rgba(20,104,176,0.12); border-left: 3px solid #1468b0; font-weight: 600;';
          $linkActive = 'color: #1468b0 !important;';
        @endphp

        <li style="{{ request()->routeIs('home') ? $navActive : '' }}">
          <a href="{{ route('home') }}" style="{{ request()->routeIs('home') ? $linkActive : '' }}" class="text-dark">
            <i class="icon-home"></i>Home
          </a>
        </li>

        <li style="{{ request()->routeIs('viewProfile') ? $navActive : '' }}">
          <a href="{{ route('viewProfile') }}" style="{{ request()->routeIs('viewProfile') ? $linkActive : '' }}" class="text-dark">
            <i class="icon-user-1"></i>View Profile
          </a>
        </li>

        <li style="{{ request()->routeIs('topicApproval') || request()->routeIs('review') ? $navActive : '' }}">
          <a href="{{ route('topicApproval') }}" style="{{ request()->routeIs('topicApproval') || request()->routeIs('review') ? $linkActive : '' }}" class="text-dark">
            <i class="bi bi-card-checklist"></i>Topic Approval
          </a>
        </li>

        <li style="{{ request()->routeIs('responseAppointment') ? $navActive : '' }}">
          <a href="{{ route('responseAppointment') }}" style="{{ request()->routeIs('responseAppointment') ? $linkActive : '' }}" class="text-dark">
            <i class="icon-padnote"></i>Appointment Requests
          </a>
        </li>

        <li style="{{ request()->routeIs('notifications') ? $navActive : '' }}">
          <a href="{{ route('notifications') }}" style="{{ request()->routeIs('notifications') ? $linkActive : '' }}" class="text-dark">
            <i class="bi bi-bell"></i>Notifications
          </a>
        </li>

        <li style="{{ request()->routeIs('changePassword') ? $navActive : '' }}">
          <a href="{{ route('changePassword') }}" style="{{ request()->routeIs('changePassword') ? $linkActive : '' }}" class="text-dark">
            <i class="icon-settings"></i>Change Password
          </a>
        </li>

      </ul>
    </nav>
    <!-- Sidebar Navigation end-->
