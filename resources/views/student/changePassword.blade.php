<!DOCTYPE html>
<html>
  <head>
    @extends('student.css')
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

    @include('student.header')

    @include('student.sidebar')

    <div class="page-content bg-white">
        <div class="page-header" style="background-color: white; padding: 2.5rem 0;">
            <div class="container-fluid">
                <h2 class="h3 mb-4" style="color: black; font-weight: 600;">Change Password</h2>
                
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card shadow-sm" style="border: none; border-radius: 10px; background-color: white;">
                            <div class="card-body p-4">
                                <form action="{{ url('newPassword') }}" method="POST">
                                    @csrf
                                    
                                    <div class="mb-4">
                                        <label for="current_password" class="form-label" style="color: #444; font-weight: 500;">Current Password</label>
                                        <input type="password" 
                                               class="form-control" 
                                               id="current_password" 
                                               name="current_password" 
                                               required
                                               style="padding: 0.8rem; border: 1px solid #ddd; border-radius: 8px;">
                                    </div>

                                    <div class="mb-4">
                                        <label for="new_password" class="form-label" style="color: #444; font-weight: 500;">New Password</label>
                                        <input type="password" 
                                               class="form-control" 
                                               id="new_password" 
                                               name="new_password" 
                                               required
                                               style="padding: 0.8rem; border: 1px solid #ddd; border-radius: 8px;">
                                    </div>

                                    <div class="mb-4">
                                        <label for="confirm_password" class="form-label" style="color: #444; font-weight: 500;">Confirm New Password</label>
                                        <input type="password" 
                                               class="form-control" 
                                               id="confirm_password" 
                                               name="confirm_password" 
                                               required
                                               style="padding: 0.8rem; border: 1px solid #ddd; border-radius: 8px;">
                                    </div>

                                    <button type="submit" 
                                            class="btn btn-primary w-100" 
                                            style="padding: 0.8rem; font-weight: 500; background-color: #1468b0; border: none; border-radius: 8px;">
                                        Update Password
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript files-->
    @include('student.java')
  </body>
</html>
