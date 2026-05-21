<section>
<div class="row">
    <!-- Active Time Frame Card -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 h-100" style="background-color: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 12px;">
            <div class="card-body p-4">
                <h5 class="card-title mb-4" style="color: #1e293b; font-weight: 600;">
                    <i class="bi bi-calendar-range m-2" style="color: #1468b0;"></i>Current Active Time Frame
                </h5>
                @if($activeTimeFrame)
                <div class="mb-3">
                    <p class="mb-1" style="color: #475569; font-size: 0.9rem;">Description:</p>
                    <p class="mb-3" style="color: #334155; font-weight: 500;">{{ $activeTimeFrame->description }}</p>
                </div>
                @if($activeTimeFrame->semester || $activeTimeFrame->academic_year)
                <div class="mb-3">
                    @if($activeTimeFrame->semester)
                    <span class="badge bg-primary me-2">Semester {{ $activeTimeFrame->semester }}</span>
                    @endif
                    @if($activeTimeFrame->academic_year)
                    <span class="badge bg-secondary">{{ $activeTimeFrame->academic_year }}</span>
                    @endif
                </div>
                @endif
                <div class="row">
                    <div class="col-6">
                        <p class="mb-1" style="color: #475569; font-size: 0.9rem;">Start Date:</p>
                        <p style="color: #334155; font-weight: 500;">{{ $activeTimeFrame->startDate }}</p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1" style="color: #475569; font-size: 0.9rem;">End Date:</p>
                        <p style="color: #334155; font-weight: 500;">{{ $activeTimeFrame->endDate }}</p>
                    </div>
                </div>
                @else
                <div class="text-center py-3">
                    <i class="bi bi-calendar-x" style="font-size: 2rem; color: #94a3b8;"></i>
                    <p class="mt-2 text-muted">No active time frame set.</p>
                    <a href="{{ route('manageTimeFrame') }}" class="btn btn-sm btn-primary mt-1">Set Time Frame</a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="col-md-6">
        <div class="row">
            <!-- Total Supervisors Card -->
            <div class="col-md-6 mb-4">
                <div class="card border-0" style="background: linear-gradient(135deg, #1468b0 0%, #0f4c81 100%); border-radius: 12px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-person-badge text-white m-2" style="font-size: 2rem;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title mb-1 text-white" style="font-size: 0.9rem; opacity: 0.9;">Total Supervisors</h6>
                                <h3 class="mb-0 text-white" style="font-weight: 600;">{{ $totalLecturers }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Students Card -->
            <div class="col-md-6 mb-4">
                <div class="card border-0" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 12px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-mortarboard text-white m-2" style="font-size: 2rem;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title mb-1 text-white" style="font-size: 0.9rem; opacity: 0.9;">Total Students</h6>
                                <h3 class="mb-0 text-white" style="font-weight: 600;">{{ $totalStudents }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications Card -->
            <div class="col-12 mb-2">
                <div class="card border-0" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 12px;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-bell text-white m-2" style="font-size: 1.5rem;"></i>
                                <div class="ms-2">
                                    <h6 class="mb-0 text-white" style="font-size: 0.9rem; opacity: 0.9;">Unread Notifications</h6>
                                    <h4 class="mb-0 text-white" style="font-weight: 600;">{{ $unreadNotifications }}</h4>
                                </div>
                            </div>
                            <a href="{{ route('notifications') }}" class="btn btn-light btn-sm">View All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
