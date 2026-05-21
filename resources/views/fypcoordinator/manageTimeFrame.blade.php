<!DOCTYPE html>
<html>
  <head>
    @extends('fypcoordinator.css')
    @section('title', 'Manage Time Frame')
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
          <h2 class="h3 mb-4" style="color: #2c3e50; font-weight: 600;">Manage Time Frame</h2>

          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif

          <div class="row">
            <!-- ADD NEW TIME FRAME FORM -->
            <div class="col-lg-5 mb-4">
              <div class="card border-0" style="background-color: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 12px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                  <h5 class="mb-0" style="color: #1e293b; font-weight: 600;">
                    <i class="bi bi-plus-circle me-2" style="color: #1468b0;"></i>Add New Time Frame
                  </h5>
                </div>
                <div class="card-body p-4">
                  <form id="timeFrameForm" method="POST" action="{{ route('saveTimeFrame') }}">
                    @csrf

                    <div class="mb-3">
                      <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                      <textarea name="description" class="form-control" rows="3" placeholder="e.g. Supervisor Hunting Time Frame" required
                        style="border-radius: 8px; border: 2px solid #e2e8f0;"></textarea>
                    </div>

                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label class="form-label fw-semibold">Semester</label>
                        <input type="text" name="semester" class="form-control" placeholder="e.g. 1"
                          style="border-radius: 8px; border: 2px solid #e2e8f0;">
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fw-semibold">Academic Year</label>
                        <input type="text" name="academic_year" class="form-control" placeholder="e.g. 2024/2025"
                          style="border-radius: 8px; border: 2px solid #e2e8f0;">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="startDate" class="form-control" required
                          style="border-radius: 8px; border: 2px solid #e2e8f0;">
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
                        <input type="date" name="endDate" class="form-control" required
                          style="border-radius: 8px; border: 2px solid #e2e8f0;">
                      </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                      <button type="button" class="btn btn-primary px-4 py-2" onclick="confirmSave()"
                        style="background: linear-gradient(135deg, #1468b0, #0f4c81); border: none; border-radius: 8px; font-weight: 500;">
                        <i class="bi bi-bell me-2"></i>Save &amp; Notify All Users
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- EXISTING TIME FRAMES TABLE -->
            <div class="col-lg-7 mb-4">
              <div class="card border-0" style="background-color: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 12px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                  <h5 class="mb-0" style="color: #1e293b; font-weight: 600;">
                    <i class="bi bi-list-ul me-2" style="color: #1468b0;"></i>Time Frame History
                  </h5>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table align-middle mb-0">
                      <thead>
                        <tr style="background-color: #f8fafc;">
                          <th class="py-3 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Description</th>
                          <th class="py-3 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Period</th>
                          <th class="py-3 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Status</th>
                          <th class="py-3 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($timeFrames as $tf)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                          <td class="py-3 px-4">
                            <div style="color: #334155; font-weight: 500;">{{ $tf->description }}</div>
                            @if($tf->semester || $tf->academic_year)
                            <small class="text-muted">
                              @if($tf->semester) Sem {{ $tf->semester }} @endif
                              @if($tf->academic_year) &bull; {{ $tf->academic_year }} @endif
                            </small>
                            @endif
                          </td>
                          <td class="py-3 px-4" style="font-size: 0.85rem; color: #475569;">
                            {{ $tf->startDate }} &mdash; {{ $tf->endDate }}
                          </td>
                          <td class="py-3 px-4">
                            @if($tf->is_active)
                              <span class="badge bg-success">Active</span>
                            @else
                              <span class="badge bg-secondary">Inactive</span>
                            @endif
                          </td>
                          <td class="py-3 px-4">
                            <div class="d-flex gap-2">
                              @if(!$tf->is_active)
                              <form method="POST" action="{{ route('setActiveTimeFrame', $tf->timeFrameID) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-success" title="Set as active">
                                  <i class="bi bi-check2-circle"></i>
                                </button>
                              </form>
                              @endif
                              <form method="POST" action="{{ route('deleteTimeFrame', $tf->timeFrameID) }}"
                                onsubmit="return confirm('Delete this time frame?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                  <i class="bi bi-trash"></i>
                                </button>
                              </form>
                            </div>
                          </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="4" class="text-center py-4 text-muted">No time frames created yet.</td>
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

    <script>
      function confirmSave() {
        if (confirm("Save this time frame and notify all users?")) {
          document.getElementById('timeFrameForm').submit();
        }
      }
    </script>

    @include('fypcoordinator.java')
  </body>
</html>
