<!DOCTYPE html>
<html>
  <head>
    <base href="{{ url('/') }}/">
    @extends('student.css')
    @section('title', 'Lecturer Profile')
    <style>
        .page-content {
        background-color: #f8f9fa;
        min-height: 100vh;
        padding: 20px;
        }
    </style>

  </head>
  <body>

    @include('student.header')

    @include('student.sidebar')

    <!-- Main Content -->
    <div class="page-content bg-white">
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0" style="color: #2c3e50; font-weight: 600;">{{ $lecturer->name }}'s Profile</h2>
            </div>

            <div class="card border-0 shadow-sm" style="background-color: #ffffff; border-radius: 12px;">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Lecturer Profile Picture -->
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="position-relative" style="width: 250px; height: 250px; margin: 0 auto;">
                                    <img src="lecturerProfile/{{ $lecturer->profilePicture }}" 
                                         alt="Lecturer Picture" 
                                         class="img-fluid rounded-circle shadow-sm"
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            </div>
                        </div>

                        <!-- Lecturer Details -->
                        <div class="col-md-8">
                            <div class="ps-md-4">
                                <h3 class="mb-4" style="color: #2c3e50; font-weight: 600;">{{ $lecturer->name }}</h3>
                                
                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-people-fill me-3" style="color: #3498db; font-size: 1.2rem;"></i>
                                        <div>
                                            <span class="text-muted">Quota Available:</span>
                                            <span class="ms-2 fw-semibold">{{ $lecturer->numberQuota }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-envelope-fill me-3" style="color: #3498db; font-size: 1.2rem;"></i>
                                        <div>
                                            <span class="text-muted">Email:</span>
                                            <span class="ms-2 fw-semibold">{{ $lecturer->user->email }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h5 class="mb-3" style="color: #2c3e50; font-weight: 600;">
                                        <i class="bi bi-calendar3 me-2"></i>Timetable
                                    </h5>
                                    <img src="timetable/{{ $lecturer->timetable }}" 
                                         alt="TimeTable" 
                                         class="img-fluid rounded shadow-sm"
                                         style="max-width: 100%; height: auto;">
                                </div>

                                <div class="mb-4">
                                    <h5 class="mb-3" style="color: #2c3e50; font-weight: 600;">
                                        <i class="bi bi-list-check me-2"></i>Topics
                                    </h5>
                                    <div class="list-group">
                                        @foreach ($topic as $topic)
                                            <div class="list-group-item border-0 bg-light mb-2 rounded">
                                                {{ $topic->title }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="d-flex gap-3 mt-4">
                                    <a href="{{url('applyAppointment',$lecturer->lecturerID)}}" 
                                       class="btn btn-primary px-4 py-2 rounded-pill shadow-sm"
                                       style="background-color: #3498db; border: none;">
                                        <i class="bi bi-calendar-plus me-2"></i>Apply Appointment
                                    </a>
                                    @if ($lecturer->numberQuota > 0)
                                        <a href="{{url('applyTopic',$lecturer->lecturerID)}}" 
                                           class="btn btn-secondary px-4 py-2 rounded-pill shadow-sm"
                                           style="background-color: #2c3e50; border: none;">
                                            <i class="bi bi-plus-circle me-2"></i>Apply Topic
                                        </a>
                                    @else
                                        <button class="btn btn-secondary px-4 py-2 rounded-pill shadow-sm" 
                                                disabled
                                                style="background-color: #95a5a6; border: none;">
                                            <i class="bi bi-plus-circle me-2"></i>Apply Topic (Full)
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript files-->
    @include('lecturer.java')
  </body>
</html>
