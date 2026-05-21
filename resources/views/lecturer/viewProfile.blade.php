<!DOCTYPE html>
<html>
  <head>
    {{-- @include('lecturer.css') --}}
    @extends('lecturer.css')
    @section('title', 'Profile')
    <style>
      .btn-group {
        display: flex;
        gap: 10px;
      }
      .hidden {
        display: none;
      }
      .page-content {
        background-color: #f8f9fa;
        min-height: 100vh;
        padding: 20px;
      }
      .card {
        border: none;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        border-radius: 10px;
      }
      .card-body {
        padding: 2rem;
      }
      .profile-picture {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
      }
      .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 8px 20px;
        border-radius: 5px;
        transition: all 0.3s ease;
      }
      .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
      }
      .btn-success {
        background-color: #28a745;
        border: none;
        padding: 8px 20px;
        border-radius: 5px;
        transition: all 0.3s ease;
      }
      .btn-success:hover {
        background-color: #218838;
        transform: translateY(-2px);
      }
      .btn-danger {
        background-color: #dc3545;
        border: none;
        padding: 8px 20px;
        border-radius: 5px;
        transition: all 0.3s ease;
      }
      .btn-danger:hover {
        background-color: #c82333;
        transform: translateY(-2px);
      }
      .table {
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
      }
      .table thead {
        background-color: #f8f9fa;
      }
      .badge {
        padding: 8px 12px;
        border-radius: 20px;
      }
      .form-control {
        border-radius: 5px;
        border: 1px solid #dee2e6;
        padding: 10px;
      }
      .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
      }
      .timetable-image {
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
      }
    </style>
  </head>
  <body>
    @include('lecturer.header')
    @include('lecturer.sidebar')

    <div class="page-content bg-white">
      <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="mb-0">Profile</h2>
        </div>
        
        <div class="card bg-white border-0">
          <div class="card-body">
            <div class="row">
              <!-- Profile Picture Section -->
              <div class="col-md-3 text-center">
                <img
                  src="lecturerProfile/{{ $lecturer->profilePicture }}"
                  alt="Profile Picture"
                  class="profile-picture mb-4"
                />
                <form
                  action="{{ url('uploadPicture', $lecturer->lecturerID) }}"
                  method="POST"
                  enctype="multipart/form-data"
                >
                  @csrf
                  <div class="custom-file">
                    <input type="file" name="profilePicture" class="custom-file-input form-control mb-3" id="profilePicture" accept="image/*">
                    <label class="custom-file-label" for="profilePicture">Choose file</label>
                  </div>
                  <div class="mt-3">
                    <button type="submit" class="btn btn-primary btn-sm w-100" id="uploadPictureButton" disabled>
                      Update Profile
                    </button>
                  </div>
                </form>
              </div>

              <!-- Profile Details Section -->
              <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <h4 class="mb-0">{{ $lecturer->name }}</h4>
                  <span class="badge bg-info text-white">Quota Available: {{ $lecturer->numberQuota }}</span>
                </div>

                <!-- Post Topic -->
                <button
                  class="btn btn-success mb-4"
                  id="postTopicButton"
                  @if ($lecturer->numberQuota == 0) disabled @endif
                >
                  Post Topic
                </button>
                <div
                  id="postTopicForm"
                  class="hidden mt-3"
                  @if ($lecturer->numberQuota == 0) style="display: none;" @endif
                >
                  <form action="{{ url('postTopic') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                      <label for="topicName" class="form-label">Topic Name</label>
                      <input type="text" name="title" class="form-control" id="topicName" required />
                    </div>
                    <div class="mb-3">
                      <label for="topicDescription" class="form-label">Description</label>
                      <textarea name="description" class="form-control" id="topicDescription" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
                </div>

                <!-- Topic List -->
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Topic</th>
                        <th>Student</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($topic as $topic)
                        <tr>
                          <td>{{ $topic->title }}</td>
                          <td>{{ $topic->student->name ?? 'None' }}</td>
                          <td>
                            @if ($topic->status === 'Actived')
                              <span class="badge bg-success text-white">Actived</span>
                            @elseif ($topic->status === 'Closed')
                              <span class="badge bg-danger text-white">Closed</span>
                            @endif
                          </td>
                          <td>
                            <form action="{{ url('deleteTopic', $topic->topicID) }}" method="POST" style="display: inline;">
                              @csrf
                              <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            @if ($topic->status === 'Actived')
                              <a href="{{ url('editTopic', $topic->topicID) }}" class="btn btn-primary btn-sm me-2 mt-2" style="background-color: #007bff !important; border-color: #007bff !important; color: white !important;">Edit</a>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                      @foreach ($closedCustomTopics as $topic)
                        <tr>
                          <td>{{ $topic->title }}</td>
                          <td>{{ $topic->student->name ?? 'None' }}</td>
                          <td><span class="badge bg-danger text-white">Closed</span></td>
                          <td>
                            <form action="{{ url('deleteTopic', $topic->topicID) }}" method="POST" style="display: inline;">
                              @csrf
                              <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>

                <!-- Timetable Section -->
                <div class="mt-5">
                  <h5 class="mb-3">Timetable</h5>
                  <img src="timetable/{{ $lecturer->timetable }}" alt="TimeTable" class="timetable-image mb-4" style="max-width: 100%; height: auto;" />
                  <form
                    action="{{ url('uploadTimetable', $lecturer->lecturerID) }}"
                    method="POST"
                    enctype="multipart/form-data"
                  >
                    @csrf
                    <div class="btn-group">
                      <div class="custom-file">
                        <input type="file" name="timetable" class="custom-file-input form-control mb-3" id="timetableFile" accept="image/*" onchange="toggleUploadButton('uploadTimetableButton', 'timetableFile')">
                        <label class="custom-file-label" for="timetableFile">Choose file</label>
                      </div>
                      <button type="submit" class="btn btn-primary" id="uploadTimetableButton" disabled>
                        Upload Timetable
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

    @include('lecturer.java')
    <script>
      // Toggle Post Topic Form
      const postTopicButton = document.getElementById('postTopicButton');
      if (postTopicButton && !postTopicButton.disabled) {
        postTopicButton.addEventListener('click', function () {
          const form = document.getElementById('postTopicForm');
          form.classList.toggle('hidden');
        });
      }

      // Enable Upload Button
      document.getElementById('profilePicture').addEventListener('change', function () {
        const button = document.getElementById('uploadPictureButton');
        button.disabled = !this.value;
      });

      function toggleUploadButton(buttonId, inputId) {
        const button = document.getElementById(buttonId);
        const input = document.getElementById(inputId);
        button.disabled = !input.value;
      }
    </script>
  </body>
</html>
