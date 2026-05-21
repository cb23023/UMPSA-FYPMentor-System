<!DOCTYPE html>
<html>
<head>
    @extends('fypcoordinator.css')
    @section('title', 'Upload Users')
    <style>
        label {
            display: inline-block;
            width: 200px;
            color: white;
        }
        .div_deg {
            padding: 10px;
        }
        
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="h3 mb-2" style="color: #2c3e50; font-weight: 600;">Upload User</h2>
                        <p class="text-muted mb-0" style="font-size: 0.95rem;">Upload user data via CSV file</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ url('download-user-template') }}" class="btn btn-info px-4 py-2 m-1" style="background-color: #0d6efd; border: none; font-weight: 500; color: white;">
                            <i class="bi bi-download me-2"></i>Download Template
                        </a>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert" style="border-radius: 12px; border: none; box-shadow: 0 4px 12px rgba(220,38,38,0.1); background-color: #fee2e2; color: #991b1b;">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 1.25rem;"></i>
                            <div>
                                <h6 class="alert-heading mb-1" style="font-weight: 600;">Please correct the following errors:</h6>
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card border-0" style="background-color: #ffffff; box-shadow: 0 8px 24px rgba(0,0,0,0.08); border-radius: 16px; max-width: 600px; margin: 2rem auto;">
                    <div class="card-body p-5">
                        <form action="{{ url('upload_user') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="formFile" class="form-label" style="color: #1e293b; font-weight: 500; margin-bottom: 0.75rem; font-size: 1.1rem;">
                                    <i class="bi bi-file-earmark-spreadsheet me-2" style="color: #10b981;"></i>CSV File
                                </label>
                                <input class="form-control" type="file" id="formFile" name="file" required
                                    style="padding: 1rem; border-radius: 12px; border: 2px solid #e2e8f0; 
                                    transition: all 0.2s ease; font-size: 1.1rem; color: #334155;
                                    min-height: 70px; width: 100%; cursor: pointer;
                                    background-color: #f8fafc;">
                            </div>

                            <div class="d-flex justify-content-end mt-5">
                                <button type="submit" class="btn btn-success px-5 py-3" 
                                    style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); 
                                    border: none; font-weight: 500; border-radius: 12px; 
                                    box-shadow: 0 4px 12px rgba(16,185,129,0.2);
                                    transition: all 0.2s ease;">
                                    <i class="bi bi-upload me-2"></i>Upload Users
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript files -->
    @include('fypcoordinator.java')
</body>
</html>
