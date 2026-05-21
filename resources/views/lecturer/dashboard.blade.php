<!DOCTYPE html>
<html>
  <head>
    {{-- @include('lecturer.css') --}}
    @extends('lecturer.css')
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

    @include('lecturer.header')

    @include('lecturer.sidebar')

      {{-- <div class="page-content bg-white">
        <div class="page-header bg-white text-dark">
            <div class="container-fluid">
                @include('lecturer.body')
            </div>
      </div> --}}
      

      <div class="page-content bg-white">
        <div class="container mt-4">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Dashboard</h2>
          </div>
          
          <div class="container-fluid">
            @include('lecturer.body')
          </div>
          
        </div>
      </div>
    <!-- JavaScript files-->
    @include('lecturer.java')
  </body>
</html>
