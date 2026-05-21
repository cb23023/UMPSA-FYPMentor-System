<!DOCTYPE html>
<html lang="en">
<head>
    @extends('student.css')
    @section('title', 'Topic Request')
    <title>Topic Requests</title>
    <style>
        .page-content {
        background-color: #f8f9fa;
        min-height: 100vh;
        padding: 20px;
        }

        .approval-card {
            background-color: #f8f9fa;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .approval-card h5 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .approval-card p {
            margin: 5px 0;
        }

        .approval-card .btn-cancel {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .approval-card .btn-cancel:hover {
            background-color: #bd2130;
        }
    </style>
</head>
<body>

    @include('student.header')
    @include('student.sidebar')

    <!-- Main Context Area -->
    <div class="page-content bg-white">
        <div class="page-header" style="background-color: white; padding: 2.5rem 0;">
            <div class="container-fluid">
                <h2 class="h3 mb-4" style="color: black; font-weight: 600;">My Topic Requests</h2>

                @if ($topic->isEmpty())
                    <div class="text-center py-5" style="color: #666; font-size: 1.1rem;">
                        No topic requests available.
                    </div>
                @else
                    <div class="table-responsive bg-white rounded" style="box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <table class="table mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th class="py-3 px-4" style="font-weight: 600; color: #333; border-bottom: 2px solid #dee2e6;">Lecturer</th>
                                    <th class="py-3 px-4" style="font-weight: 600; color: #333; border-bottom: 2px solid #dee2e6;">Topic</th>
                                    <th class="py-3 px-4" style="font-weight: 600; color: #333; border-bottom: 2px solid #dee2e6;">Date Applied</th>
                                    <th class="py-3 px-4" style="font-weight: 600; color: #333; border-bottom: 2px solid #dee2e6;">Status</th>
                                    <th class="py-3 px-4" style="font-weight: 600; color: #333; border-bottom: 2px solid #dee2e6;">Remarks</th>
                                    <th class="py-3 px-4" style="font-weight: 600; color: #333; border-bottom: 2px solid #dee2e6;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topic as $application)
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <td class="py-3 px-4" style="color: #444; font-size: 1.05rem;">{{ $application->topic->lecturer->name }}</td>
                                        <td class="py-3 px-4" style="color: #444; font-size: 1.05rem;">{{ $application->topic->title }}</td>
                                        <td class="py-3 px-4" style="color: #444; font-size: 1.05rem;">{{ $application->created_at->format('d M Y') }}</td>
                                        <td class="py-3 px-4">
                                            <span class="badge
                                                @if ($application->status === 'Pending') bg-warning text-dark
                                                @elseif ($application->status === 'Approved') bg-success text-white
                                                @elseif ($application->status === 'Rejected') bg-danger text-white
                                                @endif"
                                                style="padding: 0.5rem 1rem; font-weight: 500;">
                                                {{ $application->status }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4" style="color: #444; font-size: 1.05rem;">{{ $application->remarks ?? 'No remarks' }}</td>
                                        <td class="py-3 px-4">
                                            @if ($application->status === 'Pending')
                                                <form action="{{ url('cancelRequest', $application->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="btn btn-outline-danger" 
                                                            onclick="return confirm('Are you sure you want to cancel?')"
                                                            style="padding: 0.5rem 1rem; font-weight: 500;">
                                                        Cancel
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- JavaScript files-->
    @include('student.java')
</body>
</html>
