<!DOCTYPE html>
<html>
  <head>
    @extends('fypcoordinator.css')
    @section('title', 'List of Lecturer')
    <style>
        table{
            margin: 20px 0;
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 15px;
            text-align: center;
            font-size:18px;
            font-weight: bold;
        }
    

        td{
            padding:10px;
            color:white;
        }
        img {
            max-width: 300px; /* Restrict image width */
            height: auto; /* Maintain aspect ratio */
        }

        .page-content {
        background-color: #f8f9fa;
        min-height: 100vh;
        padding: 20px;
        }

        body {
            background: #f8f9fa;
            color: #000;
        }
        .card {
            border-radius: 16px;
            background: #fff;
        }
        .form-select, .form-control, .btn {
            border-radius: 8px;
        }
        .form-select, .form-label, .form-control, .table, .table th, .table td {
            color: #000 !important;
        }
        .table thead th {
            background: #f8f9fa;
            color: #000 !important;
            font-size: 0.95rem;
            letter-spacing: 0.04em;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f2f6;
        }
        .btn-primary:hover, .btn-outline-secondary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            transition: all 0.2s;
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
                    <h2 class="h3 mb-0" style="color: #2c3e50; font-weight: 600;">Lecturer List</h2>
                    <div class="d-flex gap-2">
                        <a class="btn btn-primary px-4 py-2 m-1" href="{{ route('uploadUser') }}" style="background-color: #1468b0; border: none; font-weight: 500;">
                            <i class="bi bi-upload me-2"></i>Upload
                        </a>
                        
                        <a class="btn btn-success px-4 py-2 m-1" href="{{ route('fypReport') }}" style="background-color: #10b981; border: none; font-weight: 500;">
                            <i class="bi bi-file-pdf me-2"></i>Generate PDF
                        </a>
                    </div>
                </div>

                <div class="card border-0" style="background-color: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 12px;">
                    <div class="card-body px-0">
                        <div class="container py-4">
                            <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px; background: #fff;">
                                <div class="card-body">
                                    <h3 class="mb-4" style="font-weight: 700; color: #000;">Lecturer List</h3>
                                    <form method="GET" action="{{ url()->current() }}" class="row g-3 align-items-end mb-3">
                                        <div class="col-md-3">
                                            <label for="lecturerID" class="form-label text-uppercase fw-semibold small" style="color: #000;">Lecturer ID</label>
                                            <input type="text" name="lecturerID" id="lecturerID" class="form-control shadow-sm" style="color: #000;" value="{{ isset($lecturerID) ? $lecturerID : '' }}" placeholder="Enter lecturer ID">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="name" class="form-label text-uppercase fw-semibold small" style="color: #000;">Name</label>
                                            <input type="text" name="name" id="name" class="form-control shadow-sm" style="color: #000;" value="{{ isset($name) ? $name : '' }}" placeholder="Enter lecturer name">
                                        </div>
                                        <div class="col-md-4 d-flex gap-2">
                                            <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm">
                                                <i class="fas fa-filter me-2"></i>Filter
                                            </button>
                                            <a href="{{ url()->current() }}" class="btn btn-outline-secondary px-4 fw-semibold shadow-sm">
                                                <i class="fas fa-undo me-2"></i>Reset
                                            </a>
                                        </div>
                                    </form>
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0" style="border-radius: 10px; overflow: hidden;">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-uppercase small fw-bold" style="color: #000;">Lecturer ID</th>
                                                    <th class="text-uppercase small fw-bold" style="color: #000;">Name</th>
                                                    <th class="text-uppercase small fw-bold" style="color: #000;">Profile Picture</th>
                                                    <th class="text-uppercase small fw-bold" style="color: #000;">Email</th>
                                                    <th class="text-uppercase small fw-bold" style="color: #000;">Number of Quota</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($data as $lecturer)
                                                <tr>
                                                    <td class="fw-semibold" style="color: #000;">{{ $lecturer->lecturerID }}</td>
                                                    <td class="fw-semibold" style="color: #000;">{{ $lecturer->name }}</td>
                                                    <td class="py-4 px-4" style="color: #334155; font-size: 1rem;">
                                                        <img
                                                            src="{{ asset('lecturerProfile/' . $lecturer->profilePicture) }}"
                                                            alt="Profile Picture"
                                                            class="profile-picture"
                                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;"
                                                            />
                                                    </td>
                                                    <td class="py-4 px-4" style="color: #334155; font-size: 1rem;">{{$lecturer->user->email}}</td>
                                                    <td class="py-4 px-4" style="color: #334155; font-size: 1rem;">{{$lecturer->numberQuota}}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-4" style="color: #000;">No lecturers found for the selected filter.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      
    </div>
    <!-- JavaScript files-->
    @include('fypcoordinator.java')
  </body>
</html>
