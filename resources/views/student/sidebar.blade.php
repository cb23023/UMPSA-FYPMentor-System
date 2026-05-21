<div class="d-flex align-items-stretch">
    <nav id="sidebar" style="background-color: white;">
      <div class="sidebar-header d-flex align-items-center">
        <div class="title">
          <h1 class="h5" style="color: black; padding-bottom: 10px;">{{ Auth()->user()->email }}</h1>
          <p style="color: white; background-color: #1468b0; border-radius: 10px; padding: 5px 10px; font-size: 12px; display: inline-block; font-weight: bold;">Student</p>
        </div>
      </div>
      <span class="heading" style="color: black;">Main</span>
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

        <li style="{{ request()->routeIs('listOfLecturer') || request()->routeIs('lecturerProfile') ? $navActive : '' }}">
          <a href="{{ route('listOfLecturer') }}" style="{{ request()->routeIs('listOfLecturer') || request()->routeIs('lecturerProfile') ? $linkActive : '' }}" class="text-dark">
            <i class="bi bi-person-lines-fill"></i>List of Lecturers
          </a>
        </li>

        <li style="{{ request()->routeIs('appointmentRequest') || request()->routeIs('applyAppointment') ? $navActive : '' }}">
          <a href="{{ route('appointmentRequest') }}" style="{{ request()->routeIs('appointmentRequest') || request()->routeIs('applyAppointment') ? $linkActive : '' }}" class="text-dark">
            <i class="bi bi-people-fill"></i>My Appointments
          </a>
        </li>

        <li style="{{ request()->routeIs('topicRequest') || request()->routeIs('applyTopic') ? $navActive : '' }}">
          <a href="{{ route('topicRequest') }}" style="{{ request()->routeIs('topicRequest') || request()->routeIs('applyTopic') ? $linkActive : '' }}" class="text-dark">
            <i class="bi bi-card-checklist"></i>My Topics
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
