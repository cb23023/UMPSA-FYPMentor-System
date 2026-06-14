<!DOCTYPE html>
<html>
  <head>
    @extends('fypcoordinator.css')
    @section('title', 'List of Student')
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
.form-select, .btn {
    border-radius: 8px;
}
.form-select, .form-label, .table, .table th, .table td {
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
.badge.bg-primary {
    background: linear-gradient(90deg, #0984e3 0%, #00b894 100%);
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
                    <h2 class="h3 mb-0" style="color: #2c3e50; font-weight: 600;">Student List</h2>
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
                                    <h3 class="mb-4" style="font-weight: 700; color: #000;">Student List</h3>
                                    <form method="GET" action="{{ url()->current() }}" class="row g-3 align-items-end mb-3">
                                        <div class="col-md-3">
                                            <label for="entry_year" class="form-label text-uppercase fw-semibold small" style="color: #000;">Entry Year</label>
                                            <select name="entry_year" id="entry_year" class="form-select shadow-sm" style="color: #000;">
                                                <option value="">All Years</option>
                                                @foreach($years as $year)
                                                    <option value="{{ $year }}" {{ (isset($entryYear) && $entryYear == $year) ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="course" class="form-label text-uppercase fw-semibold small" style="color: #000;">Course</label>
                                            <select name="course" id="course" class="form-select shadow-sm" style="color: #000;">
                                                <option value="">All Courses</option>
                                                @foreach($courses as $c)
                                                    <option value="{{ $c }}" {{ (isset($course) && $course == $c) ? 'selected' : '' }}>
                                                        {{ $c }}
                                                    </option>
                                                @endforeach
                                            </select>
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
                                                    <th class="text-uppercase small fw-bold" style="color: #000;">Student ID</th>
                                                    <th class="text-uppercase small fw-bold" style="color: #000;">Name</th>
                                                    <th class="text-uppercase small fw-bold" style="color: #000;">Course</th>
                                                    {{-- Add more columns as needed --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($data as $student)
                                                <tr>
                                                    <td class="fw-semibold" style="color: #000;">{{ $student->studentID }}</td>
                                                    <td class="fw-semibold" style="color: #000;">{{ $student->name }}</td>
                                                    <td>
                                                        <span class="badge rounded-pill bg-primary text-white px-3 py-2" style="font-size: 0.95em;">
                                                            {{ $student->course }}
                                                        </span>
                                                    </td>
                                                    {{-- Add more columns as needed --}}
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="3" class="text-center py-4" style="color: #000;">No students found for the selected filter.</td>
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
    <!-- JavaScript files-->
    @include('fypcoordinator.java')
  </body>
</html>

