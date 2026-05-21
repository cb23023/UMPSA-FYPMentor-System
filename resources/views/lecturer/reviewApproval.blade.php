<!DOCTYPE html>
<html>
<head>
    <base href="{{ url('/') }}/">
    {{-- @include('lecturer.css') --}}
    @extends('lecturer.css')
    @section('title', 'Review Approval')
    <style>
        .topic-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 20px auto;
            background-color: #f9f9f9;
            max-width: 600px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-check {
            margin-bottom: 10px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
</head>
<body>
    @include('lecturer.header')
    @include('lecturer.sidebar')

    <div class="page-content bg-white">
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Review Topic</h2>
                <a href="{{ route('topicApproval') }}" class="btn btn-primary" style="background-color: #007bff; color: white;">
                    <i class=" me-2"></i>Back
                </a>
            </div>

            <div class="card bg-white border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted mb-1">Student Name</label>
                                <p class="h5 mb-0">{{ $topic->student->name ?? 'Unknown Student' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted mb-1">Topic</label>
                                <p class="h5 mb-0">{{ $topic->topic->title }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted mb-1">Current Status</label>
                                <span class="badge
                                    @if ($topic->status === 'Pending') bg-warning text-dark
                                    @elseif ($topic->status === 'Approved') bg-success
                                    @elseif ($topic->status === 'Rejected') bg-danger
                                    @endif px-3 py-2">
                                    {{ $topic->status }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted mb-2">Description</label>
                        <div class="p-3 bg-light rounded">
                            {{ $topic->topic->description ?? 'No description provided' }}
                        </div>
                    </div>

                    <form action="{{ route('updateApplication', $topic->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold">Approval Decision</label>
                            <div class="d-flex gap-4">
                                <div class="form-check px-4 d-flex align-items-center">
                                    <input class="form-check-input me-2" type="radio" name="status" id="approve" value="Approved" required>
                                    <label class="form-check-label mb-0" for="approve">
                                        Approve
                                    </label>
                                </div>
                                <div class="form-check px-4 d-flex align-items-center">
                                    <input class="form-check-input me-2" type="radio" name="status" id="reject" value="Rejected" required>
                                    <label class="form-check-label mb-0" for="reject">
                                        Reject
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="remarks" class="form-label fw-bold">Remarks</label>
                            <textarea name="remarks" id="remarks" class="form-control" rows="3" 
                                placeholder="Enter any remarks here (optional)"></textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-paper-plane me-2"></i>Submit Decision
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('lecturer.java')
</body>
</html>
