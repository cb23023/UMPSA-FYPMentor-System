<!DOCTYPE html>
<html>
<head>
  @php $role = auth()->user()->role; @endphp
  @extends($role === 'fypcoordinator' ? 'fypcoordinator.css' : ($role === 'lecturer' ? 'lecturer.css' : 'student.css'))
  @section('title', 'Notifications')
  <style>
    .page-content { background-color: #f8f9fa; min-height: 100vh; padding: 20px; }
    .notification-item { transition: background 0.2s ease; }
    .notification-item:hover { background-color: #f8fafc; }
    .notification-unread { border-left: 4px solid #1468b0; }
    .notification-read   { border-left: 4px solid #e2e8f0; opacity: 0.75; }
  </style>
</head>
<body>

  @if($role === 'fypcoordinator')
    @include('fypcoordinator.header')
    @include('fypcoordinator.sidebar')
  @elseif($role === 'lecturer')
    @include('lecturer.header')
    @include('lecturer.sidebar')
  @else
    @include('student.header')
    @include('student.sidebar')
  @endif

  <div class="page-content bg-white">
    <div class="container mt-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0" style="color: #2c3e50; font-weight: 600;">
          <i class="bi bi-bell me-2"></i>Notifications
        </h2>
        @if($notifications->whereNull('read_at')->count() > 0)
        <form method="POST" action="{{ route('notifications.readAll') }}">
          @csrf
          <button type="submit" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-check2-all me-1"></i>Mark All as Read
          </button>
        </form>
        @endif
      </div>

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <div class="card border-0" style="box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 12px;">
        @forelse($notifications as $notif)
        <div class="notification-item p-4 {{ $notif->read_at ? 'notification-read' : 'notification-unread' }}"
             style="border-bottom: 1px solid #f1f5f9;">
          <div class="d-flex justify-content-between align-items-start">
            <div class="flex-grow-1">
              <div class="d-flex align-items-center mb-1">
                @if($notif->type === 'appointment')
                  <i class="bi bi-calendar-check me-2 text-primary"></i>
                @elseif($notif->type === 'topic')
                  <i class="bi bi-journals me-2 text-success"></i>
                @elseif($notif->type === 'timeframe')
                  <i class="bi bi-clock me-2 text-warning"></i>
                @else
                  <i class="bi bi-info-circle me-2 text-secondary"></i>
                @endif
                <span class="badge text-capitalize" style="
                  background-color: {{ $notif->type === 'appointment' ? '#dbeafe' : ($notif->type === 'topic' ? '#d1fae5' : '#fef3c7') }};
                  color: {{ $notif->type === 'appointment' ? '#1d4ed8' : ($notif->type === 'topic' ? '#065f46' : '#92400e') }};
                  font-size: 0.75rem; padding: 0.3rem 0.7rem; border-radius: 6px;">
                  {{ $notif->type }}
                </span>
                @if(!$notif->read_at)
                  <span class="ms-2 badge bg-primary rounded-pill" style="font-size: 0.7rem;">New</span>
                @endif
              </div>
              <p class="mb-1" style="color: #334155;">{{ $notif->message }}</p>
              <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
            </div>

            @if(!$notif->read_at)
            <form method="POST" action="{{ route('notifications.read', $notif->id) }}" class="ms-3">
              @csrf
              <button type="submit" class="btn btn-sm btn-outline-secondary" title="Mark as read">
                <i class="bi bi-check"></i>
              </button>
            </form>
            @endif
          </div>
        </div>
        @empty
        <div class="text-center py-5">
          <i class="bi bi-bell-slash" style="font-size: 3rem; color: #94a3b8;"></i>
          <p class="text-muted mt-3">No notifications yet.</p>
        </div>
        @endforelse
      </div>
    </div>
  </div>

  @if($role === 'fypcoordinator')
    @include('fypcoordinator.java')
  @elseif($role === 'lecturer')
    @include('lecturer.java')
  @else
    @include('student.java')
  @endif
</body>
</html>
