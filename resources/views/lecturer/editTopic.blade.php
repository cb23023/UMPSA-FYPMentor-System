<!DOCTYPE html>
<html>
  <head>
    @extends('lecturer.css')
    @section('title', 'Edit Topic')
    <style>
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
        .form-label {
            font-weight: 600;
            color: #475569;
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid #dee2e6;
            padding: 10px;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
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
    </style>
  </head>
  <body>
    @include('lecturer.header')
    @include('lecturer.sidebar')

    <div class="page-content bg-white">
      <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="mb-0">Edit Topic</h2>
        </div>
        
        <div class="card bg-white border-0">
          <div class="card-body">
            <form action="{{ url('updateTopic', $topic->topicID) }}" method="POST">
              @csrf
              <div class="mb-3">
                <label for="topicName" class="form-label">Topic Name</label>
                <input type="text" name="title" class="form-control" id="topicName"  value="{{ $topic->title }}" required />
              </div>
              <div class="mb-3">
                <label for="topicDescription" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="topicDescription" rows="4" required>{{ $topic->description }}</textarea>
              </div>
              <button type="submit" class="btn btn-primary" style="background-color: #007bff !important; border-color: #007bff !important; color: white !important;">Update Topic</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    @include('lecturer.java')
  </body>
</html> 