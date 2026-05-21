<!DOCTYPE html>
<html>
  <head>
    {{-- @include('lecturer.css') --}}
    @extends('lecturer.css')
    @section('title', 'Topic Approval')
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

    <div class="page-content bg-white">
      <div class="container mt-4 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="mb-0">Requested Topics</h2>
        </div>

        <div class="card bg-white border-0">
          <div class="card-body p-4">
            @if ($topic->isEmpty())
              <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted h5">No topic requests available.</p>
              </div>
            @else
              <div class="table-responsive">
                <table class="table table-hover align-middle">
                  <thead class="bg-light">
                    <tr>
                      <th class="py-3">Student Name</th>
                      <th class="py-3">Topic</th>
                      <th class="py-3">Description</th>
                      <th class="py-3">Status</th>
                      <th class="py-3 text-end">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($topic as $application)
                    <tr>
                      <td class="py-3">{{ $application->student->name ?? 'Unknown Student' }}</td>
                      <td class="py-3">{{ $application->topic->title }}</td>
                      <td class="py-3">
                        <div class="text-truncate" style="max-width: 200px;">
                          {{ $application->topic->description ?? 'No description provided' }}
                        </div>
                      </td>
                      <td class="py-3">
                        <span class="badge
                          @if ($application->status === 'Pending') bg-warning text-dark
                          @elseif ($application->status === 'Approved') bg-success
                          @elseif ($application->status === 'Rejected') bg-danger
                          @endif px-3 py-2">
                          {{ $application->status }}
                        </span>
                      </td>
                      <td class="py-3 text-end">
                        <a href="{{ route('review', $application->id) }}" class="btn btn-outline-primary">
                          <i class="fas fa-eye me-2"></i>Review
                        </a>
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
    </div>

    @include('lecturer.java')
  </body>
</html>
