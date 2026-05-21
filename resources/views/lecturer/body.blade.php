{{-- Lecturer Dashboard Content --}}
<section>
<div class="container-fluid">
  <div class="row">
    <!-- Current Students Card -->
    <div class="col-md-6 col-lg-3 mb-4">
      <div class="card border-0 shadow-sm" style="background-color: white; height: 120px; border-radius: 12px;">
        <div class="card-body">
          <div class="d-flex align-items-center h-100">
            <div class="flex-shrink-0 me-4" style="padding-right: 1rem;">
              <i class="bi bi-person-video3 fa-2x text-primary" style="font-size: 2rem;"></i>
            </div>
            <div class="flex-grow-1" style="padding-left: 1rem;">
              <h6 class="mb-1 text-muted" style="font-size: 0.85rem;">Current Students</h6>
              <h3 class="mb-0" style="font-weight: 700; color: #1468b0;">{{ $currentStudents }}</h3>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quota Left Card -->
    <div class="col-md-6 col-lg-3 mb-4">
      <div class="card border-0 shadow-sm" style="background-color: white; height: 120px; border-radius: 12px;">
        <div class="card-body">
          <div class="d-flex align-items-center h-100">
            <div class="flex-shrink-0 me-4" style="padding-right: 1rem;">
              <i class="bi bi-people-fill fa-2x text-success" style="font-size: 2rem;"></i>
            </div>
            <div class="flex-grow-1" style="padding-left: 1rem;">
              <h6 class="mb-1 text-muted" style="font-size: 0.85rem;">Quota Remaining</h6>
              <h3 class="mb-0" style="font-weight: 700; color: #10b981;">{{ $quotaLeft }}</h3>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Appointments Card -->
    <div class="col-md-6 col-lg-3 mb-4">
      <div class="card border-0 shadow-sm" style="background-color: white; height: 120px; border-radius: 12px;">
        <div class="card-body">
          <div class="d-flex align-items-center h-100">
            <div class="flex-shrink-0 me-4" style="padding-right: 1rem;">
              <i class="bi bi-calendar-check fa-2x text-warning" style="font-size: 2rem;"></i>
            </div>
            <div class="flex-grow-1" style="padding-left: 1rem;">
              <h6 class="mb-1 text-muted" style="font-size: 0.85rem;">Pending Appointments</h6>
              <h3 class="mb-0" style="font-weight: 700; color: #f59e0b;">{{ $appointments->where('status','Pending')->count() }}</h3>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Notifications Card -->
    <div class="col-md-6 col-lg-3 mb-4">
      <div class="card border-0 shadow-sm" style="background-color: white; height: 120px; border-radius: 12px;">
        <div class="card-body">
          <div class="d-flex align-items-center h-100">
            <div class="flex-shrink-0 me-4" style="padding-right: 1rem;">
              <i class="bi bi-bell fa-2x text-danger" style="font-size: 2rem;"></i>
            </div>
            <div class="flex-grow-1" style="padding-left: 1rem;">
              <h6 class="mb-1 text-muted" style="font-size: 0.85rem;">Unread Notifications</h6>
              <h3 class="mb-0" style="font-weight: 700; color: #ef4444;">{{ $unreadNotifications }}</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Appointments Table -->
  <div class="row mt-2">
    <div class="col-12">
      <div class="card border-0" style="background-color: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 12px;">
        <div class="card-header bg-transparent border-0 pt-4 pb-2 px-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0" style="color: #2c3e50; font-weight: 600;">
              <i class="bi bi-calendar-check me-2"></i>Recent Appointments
            </h5>
            <a href="{{ route('responseAppointment') }}" class="btn btn-sm btn-outline-primary">View All</a>
          </div>
        </div>
        <div class="card-body px-0 pb-0">
          <div class="table-responsive">
            <table class="table align-middle mb-0">
              <thead>
                <tr style="background-color: #f8fafc;">
                  <th class="py-3 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Student</th>
                  <th class="py-3 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Date</th>
                  <th class="py-3 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Time</th>
                  <th class="py-3 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($appointments as $appt)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                  <td class="py-3 px-4" style="color: #334155;">{{ $appt->student->name ?? 'N/A' }}</td>
                  <td class="py-3 px-4" style="color: #334155;">{{ $appt->date }}</td>
                  <td class="py-3 px-4" style="color: #334155;">{{ $appt->time }}</td>
                  <td class="py-3 px-4">
                    @if($appt->status === 'Approved')
                      <span class="badge rounded-pill text-white" style="background-color: #10b981; padding: 0.4rem 1rem;">Approved</span>
                    @elseif($appt->status === 'Pending')
                      <span class="badge rounded-pill text-white" style="background-color: #f59e0b; padding: 0.4rem 1rem;">Pending</span>
                    @else
                      <span class="badge rounded-pill text-white" style="background-color: #ef4444; padding: 0.4rem 1rem;">Rejected</span>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" class="text-center py-4 text-muted">No appointments yet.</td>
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
