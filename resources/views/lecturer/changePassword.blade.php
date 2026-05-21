<!DOCTYPE html>
<html>
  <head>
    {{-- @include('lecturer.css') --}}
    @extends('lecturer.css')
    @section('title', 'Change Password')

    <style>
        
        .page-content {
            background-color: #f8f9fa;
            min-height: 100vh;
            padding: 20px;
        }
    
        .change-password-form {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .change-password-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn-submit {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>


  </head>
  <body>

    @include('lecturer.header')

    @include('lecturer.sidebar')

      <div class="page-content bg-white">
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Change Password</h2>
                
            </div>
            <div class="page-header bg-white">
                <div class="container-fluid d-flex justify-content-center align-items-center min-vh-100">
                    <form class="change-password-form bg-white p-5 rounded-4 shadow" action="{{ url('newPassword') }}" method="POST" style="width: 100%; max-width: 400px;">
                        @csrf
                        
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control border-2" id="current_password" name="current_password" placeholder="Current Password" required>
                            {{-- <label for="current_password" class="text-muted">Current Password</label> --}}
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password" class="form-control border-2" id="new_password" name="new_password" placeholder="New Password" required>
                            {{-- <label for="new_password" class="text-muted">New Password</label> --}}
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password" class="form-control border-2" id="confirm_password" name="confirm_password" placeholder="Confirm New Password" required>
                            {{-- <label for="confirm_password" class="text-muted">Confirm New Password</label> --}}
                        </div>

                        <button type="submit" class="btn w-100 py-3" style="background-color: #3498db; color: white; font-weight: 500; transition: all 0.3s ease;">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript files-->
    @include('lecturer.java')
  </body>
</html>
