<!DOCTYPE html>
<html>
  <head>
    <base href="{{ url('/') }}/">
    @extends('student.css')
    @section('title', 'Topic Application')
    

    <style>
        .page-content {
        background-color: #f8f9fa;
        min-height: 100vh;
        padding: 20px;
        }
        
        .hidden {
            display: none;
        }

        .alert {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
  </head>
  <body>
    @include('student.header')
    @include('student.sidebar')

    <!-- Main Context Area -->
    <div class="page-content bg-white">
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0" style="color: #2c3e50; font-weight: 600;">Apply FYP Topic</h2>
            </div>

            <!-- Alert for Pending Requests -->
            @if ($hasPendingRequest)
            <div class="alert alert-danger rounded-4 shadow-sm" style="border: none; background-color: #fee2e2;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-3" style="color: #dc2626; font-size: 1.25rem;"></i>
                    <span style="color: #991b1b;">You already have a pending topic request. Please wait for it to be approved or rejected before applying for another topic.</span>
                </div>
            </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4" style="background-color: #ffffff;">
                <div class="card-body p-4">
                    <form action="{{ url('apply') }}" method="POST">
                        @csrf
                        <input type="hidden" name="lecturerID" value="{{ $lecturer->lecturerID }}">
                        
                        <!-- Lecturer Name -->
                        <div class="form-floating mb-4">
                            <label for="lecturer-name" class="text-muted">Lecturer Name</label>
                            <input type="text" class="form-control bg-white text-black border-0" id="lecturer-name" value="{{ $lecturer->name }}" >
                        </div>

                        <!-- Topics Dropdown -->
                        <div class="form-floating mb-4">
                            <label for="topic" class="form-label text-muted mb-2" style="display: block; font-size: 0.9rem;">Topic</label>
                            <select id="topic" name="topic" 
                                    class="form-select form-control-lg mb-3 border-2 shadow-sm" 
                                    style="background-color: #ffffff; color: #2c3e50; font-size: 1rem; padding: 0.75rem 1rem; border-radius: 8px; border-color: #e2e8f0; transition: all 0.2s ease; width: 100%;" 
                                    required 
                                    @if ($hasPendingRequest) disabled @endif>
                                <option value="" class="text-muted" style="font-size: 1rem;">Select a Topic</option>
                                @foreach ($topic as $t)
                                    <option value="{{ $t->topicID }}" class="py-2" style="font-size: 1rem;">{{ $t->title }}</option>
                                @endforeach
                                <option value="others" class="py-2" style="font-size: 1rem;">Others</option>
                            </select>
                        </div>

                        <!-- Custom Topic Input -->
                        <div id="custom-topic-container" class="hidden">
                            <div class="form-floating mb-4">
                                <input type="text" class="form-control border-2" id="fyp-title" name="title" placeholder="Enter your custom FYP title" @if ($hasPendingRequest) disabled @endif>
                                <label for="fyp-title" class="text-muted">FYP Title</label>
                            </div>
                            <div class="form-floating mb-4">
                                <textarea class="form-control border-2" id="description" name="description" placeholder="Enter your custom description..." style="height: 120px;" @if ($hasPendingRequest) disabled @endif></textarea>
                                <label for="description" class="text-muted">Description</label>
                            </div>
                        </div>

                        <!-- Apply Button -->
                        <button type="submit" class="btn w-100 py-3" 
                                style="background-color: #3498db; color: white; font-weight: 500; transition: all 0.3s ease;" 
                                @if ($hasPendingRequest) disabled @endif>
                            Apply Topic
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('student.java')

    <script>
        // Show the custom topic fields if "Others" is selected
        document.getElementById('topic').addEventListener('change', function() {
            const customTopicContainer = document.getElementById('custom-topic-container');
            if (this.value === 'others') {
                customTopicContainer.classList.remove('hidden');
            } else {
                customTopicContainer.classList.add('hidden');
            }
        });
    </script>
  </body>
</html>
