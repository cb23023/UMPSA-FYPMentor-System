<!DOCTYPE html>
<html>
  <head>
    @extends('fypcoordinator.css')
    @section('title', 'Edit Time Frame')
    <style>
      .page-content { background-color: #f8f9fa; min-height: 100vh; padding: 20px; }
    </style>
  </head>
  <body>
    @include('fypcoordinator.header')
    @include('fypcoordinator.sidebar')

    <div class="page-content bg-white">
      <div class="page-header" style="background-color: white; padding: 2.5rem 0;">
        <div class="container-fluid">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0" style="color: #2c3e50; font-weight: 600;">Edit Time Frame</h2>
            <a href="{{ route('manageTimeFrame') }}" class="btn btn-outline-secondary" style="border-radius: 8px;">
              <i class="bi bi-arrow-left me-2"></i>Back
            </a>
          </div>

          @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Please check the form.</strong>
              <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif

          <div class="row">
            <div class="col-lg-7 mb-4">
              <div class="card border-0" style="background-color: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 12px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                  <h5 class="mb-0" style="color: #1e293b; font-weight: 600;">
                    <i class="bi bi-pencil-square me-2" style="color: #1468b0;"></i>Update Time Frame Details
                  </h5>
                </div>
                <div class="card-body p-4">
                  <form id="editTimeFrameForm" method="POST" action="{{ route('timeframes.update', $timeFrame->timeFrameID) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                      <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                      <textarea name="description" class="form-control" rows="3" required
                        style="border-radius: 8px; border: 2px solid #e2e8f0;">{{ old('description', $timeFrame->description) }}</textarea>
                    </div>

                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label class="form-label fw-semibold">Semester</label>
                        <input type="text" name="semester" class="form-control" value="{{ old('semester', $timeFrame->semester) }}" placeholder="e.g. 1"
                          style="border-radius: 8px; border: 2px solid #e2e8f0;">
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fw-semibold">Academic Year</label>
                        <input type="text" name="academic_year" class="form-control" value="{{ old('academic_year', $timeFrame->academic_year) }}" placeholder="e.g. 2024/2025"
                          style="border-radius: 8px; border: 2px solid #e2e8f0;">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="startDate" class="form-control" value="{{ old('startDate', $timeFrame->startDate) }}" required
                          style="border-radius: 8px; border: 2px solid #e2e8f0;">
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
                        <input type="date" name="endDate" class="form-control" value="{{ old('endDate', $timeFrame->endDate) }}" required
                          style="border-radius: 8px; border: 2px solid #e2e8f0;">
                      </div>
                    </div>

                    <div class="mb-3">
                      <label class="form-label fw-semibold">Status</label>
                      <select name="status" class="form-select" style="border-radius: 8px; border: 2px solid #e2e8f0;">
                        <option value="active" @selected(old('status', $timeFrame->status) === 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $timeFrame->status) === 'inactive')>Inactive</option>
                      </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-3">
                      <a href="{{ route('manageTimeFrame') }}" class="btn btn-outline-secondary px-4 py-2" style="border-radius: 8px; font-weight: 500;">Cancel</a>
                      <button type="button" class="btn btn-primary px-4 py-2" onclick="confirmUpdate()"
                        style="background: linear-gradient(135deg, #1468b0, #0f4c81); border: none; border-radius: 8px; font-weight: 500;">
                        <i class="bi bi-bell me-2"></i>Update &amp; Notify Students/Lecturers
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      function confirmUpdate() {
        if (confirm("Update this time frame and notify students and lecturers?")) {
          document.getElementById('editTimeFrameForm').submit();
        }
      }
    </script>

    @include('fypcoordinator.java')
  </body>
</html>
