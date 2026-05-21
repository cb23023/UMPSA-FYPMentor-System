<!DOCTYPE html>
<html>
<head>
    @extends('student.css')
    @section('title', 'List of Lecturers')
    <style>
        .page-content { background-color: #f8f9fa; min-height: 100vh; padding: 20px; }
    </style>
</head>
<body>

    @include('student.header')
    @include('student.sidebar')

    <div class="page-content bg-white">
        <div class="page-header" style="background-color: white; padding: 2.5rem 0;">
            <div class="container-fluid">
                <h2 class="h3 mb-4" style="color: black; font-weight: 600;">List of Lecturers</h2>

                <!-- Search Form -->
                <form action="{{ route('listOfLecturer') }}" method="GET" class="mb-4">
                    <div class="input-group" style="max-width: 500px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <input type="text" name="query" class="form-control border-0"
                            placeholder="Search lecturer by name..."
                            value="{{ request('query') }}"
                            style="padding: 0.8rem 1.2rem; font-size: 1rem;">
                        <button type="submit" class="btn btn-primary" style="padding: 0.8rem 1.5rem;">
                            <i class="icon-search me-1"></i>Search
                        </button>
                    </div>
                </form>

                <!-- Lecturer Table -->
                <div class="table-responsive bg-white rounded" style="box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <table class="table mb-0" id="lecturerTable">
                        <thead style="background-color: #f8f9fa;">
                            <tr>
                                <th class="py-3 px-4" style="font-weight: 600; color: #333; border-bottom: 2px solid #dee2e6;">Name</th>
                                <th class="py-3 px-4" style="font-weight: 600; color: #333; border-bottom: 2px solid #dee2e6;">Email</th>
                                <th class="py-3 px-4" style="font-weight: 600; color: #333; border-bottom: 2px solid #dee2e6;">Quota Left</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lecturer as $lec)
                            <tr style="border-bottom: 1px solid #eee;">
                                <td class="py-3 px-4">
                                    <a href="{{ route('lecturerProfile', $lec->lecturerID) }}"
                                        style="color: #1468b0; text-decoration: none; font-weight: 500; font-size: 1.05rem;">
                                        {{ $lec->name }}
                                    </a>
                                </td>
                                <td class="py-3 px-4" style="color: #444; font-size: 1.05rem;">
                                    {{ $lec->user->email ?? 'N/A' }}
                                </td>
                                <td class="py-3 px-4">
                                    @if($lec->numberQuota > 0)
                                        <span class="badge bg-success">{{ $lec->numberQuota }} slots</span>
                                    @else
                                        <span class="badge bg-secondary">Full</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-5" style="color: #666;">No lecturers found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    @include('student.java')
</body>
</html>
