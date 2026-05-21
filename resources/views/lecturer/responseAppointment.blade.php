<!DOCTYPE html>
<html>
  <head>
    @extends('lecturer.css')
    @section('title', 'Appointment Requests')
    <style>
      .page-content { background-color: #f8f9fa; min-height: 100vh; padding: 20px; }
    </style>
  </head>
  <body>
    @include('lecturer.header')
    @include('lecturer.sidebar')

    <div class="page-content bg-white">
      <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="mb-0" style="color: #2c3e50; font-weight: 600;">Appointment Requests</h2>
          <span class="badge bg-primary fs-6 px-3 py-2">Total: {{ $appointments->count() }}</span>
        </div>

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        @forelse($appointments->sortByDesc(fn($a) => $a->status === 'Pending') as $appointment)
        <div class="card mb-4 shadow-sm border-0" style="border-radius: 12px; background-color: #ffffff;">
          <div class="card-body p-4">
            <div class="row align-items-start">
              <div class="col-md-8">
                <h5 class="card-title mb-1 text-primary">
                  {{ $appointment->student->name ?? 'Unknown Student' }}
                </h5>
                @if($appointment->title)
                  <p class="mb-2 text-dark fw-semibold">{{ $appointment->title }}</p>
                @endif
                @if($appointment->description)
                  <p class="mb-3 text-muted small">{{ $appointment->description }}</p>
                @endif

                <div class="d-flex flex-wrap gap-4">
                  <div>
                    <small class="text-muted d-block">Request Date</small>
                    <span class="fw-semibold">{{ $appointment->created_at->format('d M Y') }}</span>
                  </div>
                  <div>
                    <small class="text-muted d-block">Appointment Date</small>
                    <span class="fw-semibold">{{ $appointment->date }}</span>
                  </div>
                  <div>
                    <small class="text-muted d-block">Time Slot</small>
                    <span class="fw-semibold">{{ $appointment->time }}</span>
                  </div>
                  <div>
                    <small class="text-muted d-block">Meeting Type</small>
                    <span class="fw-semibold text-capitalize">{{ $appointment->meeting_type ?? 'Physical' }}</span>
                  </div>
                  @if($appointment->meeting_type === 'online' && $appointment->meeting_link)
                  <div>
                    <small class="text-muted d-block">Meeting Link</small>
                    <a href="{{ $appointment->meeting_link }}" target="_blank" class="small">Open Link</a>
                  </div>
                  @endif
                </div>

                @if($appointment->status === 'Rejected' && $appointment->rejection_reason)
                <div class="mt-3 p-3 bg-danger bg-opacity-10 rounded">
                  <small class="text-danger fw-semibold">Rejection Reason:</small>
                  <p class="mb-0 text-danger small">{{ $appointment->rejection_reason }}</p>
                </div>
                @endif
              </div>

              <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="mb-3">
                  @if($appointment->status === 'Pending')
                    <span class="badge bg-warning text-white px-3 py-2">Pending</span>
                  @elseif($appointment->status === 'Approved')
                    <span class="badge bg-success text-white px-3 py-2">Approved</span>
                  @else
                    <span class="badge bg-danger text-white px-3 py-2">Rejected</span>
                  @endif
                </div>

                @if($appointment->status === 'Pending')
                <!-- Approve -->
                <form action="{{ route('approval', $appointment->id) }}" method="POST" class="mb-2">
                  @csrf
                  <button type="submit" name="action" value="approve" class="btn btn-success w-100"
                    onclick="return confirm('Approve this appointment?')">
                    <i class="bi bi-check-lg me-1"></i> Approve
                  </button>
                </form>

                <!-- Reject with reason -->
                <button class="btn btn-danger w-100" type="button"
                  onclick="toggleRejectForm({{ $appointment->id }})">
                  <i class="bi bi-x-lg me-1"></i> Reject
                </button>

                <div id="rejectForm{{ $appointment->id }}" style="display:none;" class="mt-2">
                  <form action="{{ route('approval', $appointment->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="reject">
                    <textarea name="rejection_reason" class="form-control mb-2" rows="2"
                      placeholder="Reason for rejection..." style="border-radius: 8px; font-size: 0.85rem;"></textarea>
                    <button type="submit" class="btn btn-danger w-100 btn-sm">Confirm Reject</button>
                  </form>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="text-center py-5">
          <i class="bi bi-calendar-x" style="font-size: 3rem; color: #94a3b8;"></i>
          <p class="text-muted mt-3">No appointment requests found.</p>
        </div>
        @endforelse
      </div>
    </div>

    <script>
      function toggleRejectForm(id) {
        const el = document.getElementById('rejectForm' + id);
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
      }
    </script>

    @include('lecturer.java')
  </body>
</html>
