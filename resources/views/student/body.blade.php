{{-- Student Dashboard Content --}}
<section>
  <div class="container-fluid">

    <!-- Quick Info Cards -->
    <div class="row mb-4">
      <div class="col-md-6 col-lg-3 mb-3">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, #1468b0, #0f4c81);">
          <div class="card-body p-3 text-white">
            <div class="d-flex align-items-center">
              <i class="bi bi-journals me-3" style="font-size: 2rem;"></i>
              <div>
                <small style="opacity: 0.85;">Topic Applications</small>
                <h4 class="mb-0 fw-bold">{{ $approvedTopics->count() }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-3 mb-3">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, #10b981, #059669);">
          <div class="card-body p-3 text-white">
            <div class="d-flex align-items-center">
              <i class="bi bi-calendar-check me-3" style="font-size: 2rem;"></i>
              <div>
                <small style="opacity: 0.85;">Approved Appointments</small>
                <h4 class="mb-0 fw-bold">{{ $approvedAppointments->count() }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-3 mb-3">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, #f59e0b, #d97706);">
          <div class="card-body p-3 text-white">
            <div class="d-flex align-items-center">
              <i class="bi bi-bell me-3" style="font-size: 2rem;"></i>
              <div>
                <small style="opacity: 0.85;">Notifications</small>
                <h4 class="mb-0 fw-bold">{{ $unreadNotifications }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Approved Topics Table -->
    <div class="row mt-2">
      <div class="col-12">
        <div class="card border-0" style="background-color: #1468b0; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 12px;">
          <div class="card-header bg-transparent border-0 pt-4 pb-2 px-4">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="card-title mb-0" style="color: white; font-weight: 600;">
                <i class="bi bi-check-circle me-2"></i>Approved Topics
              </h5>
              <a href="{{ route('topicRequest') }}" class="btn btn-sm btn-light">View All</a>
            </div>
          </div>
          <div class="card-body px-0 pb-2">
            <div class="table-responsive">
              <table class="table align-middle mb-0">
                <thead>
                  <tr style="background-color: #f8fafc;">
                    <th class="py-3 px-4" style="font-weight: 600; color: #1468b0; border-bottom: 2px solid #e2e8f0;">Topic</th>
                    <th class="py-3 px-4" style="font-weight: 600; color: #1468b0; border-bottom: 2px solid #e2e8f0;">Supervisor</th>
                    <th class="py-3 px-4" style="font-weight: 600; color: #1468b0; border-bottom: 2px solid #e2e8f0;">Status</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($approvedTopics as $app)
                  <tr style="border-bottom: 1px solid #f1f5f9; background-color: white;">
                    <td class="py-3 px-4" style="color: #334155;">{{ $app->topic->title ?? 'N/A' }}</td>
                    <td class="py-3 px-4" style="color: #334155;">{{ $app->topic->lecturer->name ?? 'N/A' }}</td>
                    <td class="py-3 px-4">
                      <span class="badge rounded-pill text-white" style="background-color: green; padding: 0.4rem 1rem;">Approved</span>
                    </td>
                  </tr>
                  @empty
                  <tr style="background-color: white;">
                    <td colspan="3" class="text-center py-4 text-muted">No approved topics yet. <a href="{{ route('listOfLecturer') }}">Browse supervisors</a></td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Approved Appointments Table -->
    <div class="row mt-4">
      <div class="col-12">
        <div class="card border-0" style="background-color: #1468b0; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 12px;">
          <div class="card-header bg-transparent border-0 pt-4 pb-2 px-4">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="card-title mb-0" style="color: #FFFFFF; font-weight: 600;">
                <i class="bi bi-calendar-check me-2"></i>Approved Appointments
              </h5>
              <a href="{{ route('appointmentRequest') }}" class="btn btn-sm btn-light">View All</a>
            </div>
          </div>
          <div class="card-body px-0 pb-2">
            <div class="table-responsive">
              <table class="table align-middle mb-0">
                <thead>
                  <tr style="background-color: #f8fafc;">
                    <th class="py-3 px-4" style="font-weight: 600; color: #1468b0; border-bottom: 2px solid #e2e8f0;">Supervisor</th>
                    <th class="py-3 px-4" style="font-weight: 600; color: #1468b0; border-bottom: 2px solid #e2e8f0;">Date</th>
                    <th class="py-3 px-4" style="font-weight: 600; color: #1468b0; border-bottom: 2px solid #e2e8f0;">Time</th>
                    <th class="py-3 px-4" style="font-weight: 600; color: #1468b0; border-bottom: 2px solid #e2e8f0;">Status</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($approvedAppointments as $appt)
                  <tr style="border-bottom: 1px solid #f1f5f9; background-color: #FFFFFF;">
                    <td class="py-3 px-4" style="color: #334155;">{{ $appt->lecturer->name ?? 'N/A' }}</td>
                    <td class="py-3 px-4" style="color: #334155;">{{ $appt->date }}</td>
                    <td class="py-3 px-4" style="color: #334155;">{{ $appt->time }}</td>
                    <td class="py-3 px-4">
                      <span class="badge rounded-pill text-white" style="background-color: green; padding: 0.4rem 1rem;">Approved</span>
                    </td>
                  </tr>
                  @empty
                  <tr style="background-color: #FFFFFF;">
                    <td colspan="4" class="text-center py-4 text-muted">No approved appointments yet.</td>
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
</section>
