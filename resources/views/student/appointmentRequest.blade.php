<!DOCTYPE html>
<html>
  <head>
    @extends('student.css')
    @section('title', 'Appointment Request')
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

    <div class="page-content bg-white">
      <div class="page-header" style="background-color: white; padding: 2.5rem 0;">
        <div class="container-fluid">
          <h2 class="h3 mb-4" style="color: black; font-weight: 600;">Appointment Status</h2>

          @if($appointments->isEmpty())
            <div class="text-center py-5" style="color: #666; font-size: 1.1rem;">
              No appointments found.
            </div>
          @else
            <div class="table-responsive bg-white rounded" style="box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
              <table class="table mb-0">
                <thead style="background-color: #f8f9fa;">
                  <tr>
                    <th class="py-3 px-4" style="font-weight: 600; color: #333; border-bottom: 2px solid #dee2e6;">Lecturer</th>
                    <th class="py-3 px-4" style="font-weight: 600; color: #333; border-bottom: 2px solid #dee2e6;">Date</th>
                    <th class="py-3 px-4" style="font-weight: 600; color: #333; border-bottom: 2px solid #dee2e6;">Time</th>
                    <th class="py-3 px-4" style="font-weight: 600; color: #333; border-bottom: 2px solid #dee2e6;">Status</th>
                    <th class="py-3 px-4" style="font-weight: 600; color: #333; border-bottom: 2px solid #dee2e6;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($appointments as $appointment)
                    <tr style="border-bottom: 1px solid #eee;">
                      <td class="py-3 px-4" style="color: #444; font-size: 1.05rem;">{{ $appointment->lecturer_name }}</td>
                      <td class="py-3 px-4" style="color: #444; font-size: 1.05rem;">{{ $appointment->date }}</td>
                      <td class="py-3 px-4" style="color: #444; font-size: 1.05rem;">{{ $appointment->time }}</td>
                      <td class="py-3 px-4">
                        @if($appointment->status == 'Pending')
                          <span class="badge bg-warning text-dark" style="padding: 0.5rem 1rem; font-weight: 500;">Pending</span>
                        @elseif($appointment->status == 'Approved')
                          <span class="badge bg-success text-white" style="padding: 0.5rem 1rem; font-weight: 500;">Approved</span>
                        @elseif($appointment->status == 'Rejected')
                          <span class="badge bg-danger text-white" style="padding: 0.5rem 1rem; font-weight: 500;">Rejected</span>
                        @endif
                      </td>
                      <td class="py-3 px-4">
                        @if($appointment->status == 'Pending')
                          <form action="{{ url('cancelAppointment', $appointment->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-outline-danger" 
                                    type="submit" 
                                    onclick="return confirm('Are you sure you want to cancel?')"
                                    style="padding: 0.5rem 1rem; font-weight: 500;"
                                    onmouseover="this.style.color='white'"
                                    onmouseout="this.style.color='#dc3545'">
                              Cancel
                            </button>
                          </form>
                        @endif
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

    @include('student.java')
  </body>
</html>
