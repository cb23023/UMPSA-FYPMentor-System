<!DOCTYPE html>
<html>
  <head>
    <base href="{{ url('/') }}/">
    @extends('student.css')
    @section('title', 'Edit Appointment')
    <style>
      .page-content { background-color: #f8f9fa; min-height: 100vh; padding: 20px; }
    </style>
  </head>
  <body>
    @include('student.header')
    @include('student.sidebar')

    <div class="page-content bg-white">
      <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="mb-0" style="color: #2c3e50; font-weight: 600;">Edit Appointment</h2>
        </div>

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4">
          <div class="card-body p-4">
            <h5 class="mb-4" style="color: #2c3e50; font-weight: 600;">
              <i class="bi bi-pencil-square me-2" style="color: #1468b0;"></i>Update Appointment Details
            </h5>

            <form action="{{ route('updateAppointment', $appointment->id) }}" method="POST">
              @csrf
              @method('PUT')

              <!-- Lecturer Info (read-only) -->
              <div class="row g-3 mb-3">
                <div class="col-md-4">
                  <label class="form-label text-muted fw-semibold">Lecturer ID</label>
                  <input type="text" class="form-control bg-light" value="{{ $lecturer->lecturerID }}" readonly>
                </div>
                <div class="col-md-8">
                  <label class="form-label text-muted fw-semibold">Lecturer Name</label>
                  <input type="text" class="form-control bg-light" value="{{ $lecturer->name }}" readonly>
                </div>
              </div>

              <!-- Appointment Title -->
              <div class="mb-3">
                <label class="form-label fw-semibold">Appointment Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control"
                       value="{{ old('title', $appointment->title) }}" required
                       style="border-radius: 8px; border: 2px solid #e2e8f0;">
              </div>

              <!-- Description -->
              <div class="mb-3">
                <label class="form-label fw-semibold">Description / Agenda</label>
                <textarea name="description" class="form-control" rows="3"
                          style="border-radius: 8px; border: 2px solid #e2e8f0;">{{ old('description', $appointment->description) }}</textarea>
              </div>

              <!-- Date and Time -->
              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Preferred Date <span class="text-danger">*</span></label>
                  <input type="date" name="date" class="form-control" required
                         value="{{ old('date', $appointment->date) }}"
                         style="border-radius: 8px; border: 2px solid #e2e8f0;">
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Preferred Time <span class="text-danger">*</span></label>
                  <input type="time" name="time" class="form-control" required
                         value="{{ old('time', \Carbon\Carbon::parse($appointment->time)->format('H:i')) }}"
                         style="border-radius: 8px; border: 2px solid #e2e8f0;">
                </div>
              </div>

              <!-- Meeting Type -->
              <div class="mb-3">
                <label class="form-label fw-semibold">Meeting Type <span class="text-danger">*</span></label>
                <select name="meeting_type" id="meetingType" class="form-select" required
                        style="border-radius: 8px; border: 2px solid #e2e8f0;" onchange="toggleMeetingLink()">
                  <option value="physical" {{ old('meeting_type', $appointment->meeting_type) === 'physical' ? 'selected' : '' }}>Physical (Face-to-Face)</option>
                  <option value="online"   {{ old('meeting_type', $appointment->meeting_type) === 'online'   ? 'selected' : '' }}>Online</option>
                </select>
              </div>

              <!-- Meeting Link -->
              <div class="mb-3" id="meetingLinkGroup"
                   style="display: {{ old('meeting_type', $appointment->meeting_type) === 'online' ? 'block' : 'none' }};">
                <label class="form-label fw-semibold">Meeting Link</label>
                <input type="url" name="meeting_link" class="form-control"
                       placeholder="https://meet.google.com/..."
                       value="{{ old('meeting_link', $appointment->meeting_link) }}"
                       style="border-radius: 8px; border: 2px solid #e2e8f0;">
                <div class="form-text">Provide a Zoom/Google Meet/Teams link for online meetings.</div>
              </div>

              <!-- Buttons -->
              <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill fw-semibold"
                        style="background: linear-gradient(135deg, #1468b0, #0f4c81); border: none;">
                  <i class="bi bi-save me-2"></i>Save Changes
                </button>
                <a href="{{ route('appointmentRequest') }}"
                   class="btn btn-outline-secondary px-5 py-2 rounded-pill fw-semibold">
                  Cancel
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script>
      function toggleMeetingLink() {
        const type  = document.getElementById('meetingType').value;
        const group = document.getElementById('meetingLinkGroup');
        group.style.display = (type === 'online') ? 'block' : 'none';
      }
    </script>

    @include('student.java')
  </body>
</html>
