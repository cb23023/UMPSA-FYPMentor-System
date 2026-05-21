<!DOCTYPE html>
<html>
  <head>
    @extends('student.css')
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

    @include('student.header')

    @include('student.sidebar')

      {{-- <div class="page-content bg-white">
        <div class="page-header" style="background-color: #1468b0;">
            <div class="container-fluid">
                @include('student.body')
            </div>
      </div>
    </div> --}}

    <div class="page-content bg-white">
      <div class="page-header" style="background-color: white; padding: 2.5rem 0;">
          <div class="container-fluid">
              <h2 class="h3 mb-4" style="color: black; font-weight: 600;">Dashboard</h2>

              @include('student.body')
          </div>
        
      </div>
    </div>

    <!-- JavaScript files-->
    @include('student.java')
  </body>
</html>
