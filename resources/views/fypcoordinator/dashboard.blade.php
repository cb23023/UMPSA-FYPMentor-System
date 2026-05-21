<!DOCTYPE html>
<html>
  <head>
    @extends('fypcoordinator.css')
    @section('title', 'Dashboard')
    <style>
      .page-content {
        background-color: #f8f9fa;
        min-height: 100vh;
        padding: 20px;
      }
    </style>
  </head>
  <body>

    @include('fypcoordinator.header')

    @include('fypcoordinator.sidebar')

    <div class="page-content bg-white">
      <div class="page-header" style="background-color: white; padding: 2.5rem 0;">
          <div class="container-fluid">
              <h2 class="h3 mb-4" style="color: black; font-weight: 600;">Dashboard</h2>

              @include('fypcoordinator.body')
          </div>
        
      </div>
    </div>
    <!-- JavaScript files-->
    @include('fypcoordinator.java')
  </body>
</html>
