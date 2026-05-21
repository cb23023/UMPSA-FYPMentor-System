<!DOCTYPE html>
<html>
<head>
    @extends('fypcoordinator.css')
    @section('title', 'Generate Report')
    <style>
        label {
            display: inline-block;
            width: 200px;
            color: white;
        }
        .div_deg {
            padding: 10px;
        }

        .page-content {
        background-color: #f8f9fa;
        min-height: 100vh;
        padding: 20px;
        }
    </style>
</head>
<body>
    @include('fypcoordinator.header')
    @include('fypcoordinator.sidebar')

    <div class="page-content bg-white">
        <div class="page-header" style="background-color: white; padding: 2.5rem 0;">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="h3 mb-2" style="color: #2c3e50; font-weight: 600;">Generate Report</h2>
                        <p class="text-muted mb-0" style="font-size: 0.95rem;">Select user type to generate detailed report</p>
                    </div>
                    
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert" style="border-radius: 12px; border: none; box-shadow: 0 4px 12px rgba(220,38,38,0.1); background-color: #fee2e2; color: #991b1b;">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 1.25rem;"></i>
                            <div>
                                <h6 class="alert-heading mb-1" style="font-weight: 600;">Please correct the following errors:</h6>
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card border-0" style="background-color: #ffffff; box-shadow: 0 8px 24px rgba(0,0,0,0.08); border-radius: 16px; max-width: 600px; margin: 2rem auto;">
                    <div class="card-body p-5">
                        <form action="{{ url('generateReport') }}" method="post">
                            @csrf
                            <div class="mb-4">
                                <label for="type" class="form-label" style="color: #1e293b; font-weight: 500; margin-bottom: 0.75rem; font-size: 1.1rem;">
                                    <i class="bi bi-people-fill me-2" style="color: #10b981;"></i>Choose User Type
                                </label>
                                <select name="type" id="type" class="form-select" required 
                                    style="padding: 0.875rem; border-radius: 12px; border: 2px solid #e2e8f0; 
                                    transition: all 0.2s ease; font-size: 1rem; color: #334155;
                                    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="%2310b981" viewBox="0 0 16 16"><path d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/></svg>');
                                    background-repeat: no-repeat;
                                    background-position: right 1rem center;
                                    background-size: 16px 12px;
                                    appearance: none;">
                                    <option value="" disabled selected>{{ __('Select User') }}</option>
                                    <option value="student">{{ __('Student') }}</option>
                                    <option value="lecturer">{{ __('Lecturer') }}</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-end mt-5">
                                <button type="submit" class="btn btn-success px-5 py-3" 
                                    style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); 
                                    border: none; font-weight: 500; border-radius: 12px; 
                                    box-shadow: 0 4px 12px rgba(16,185,129,0.2);
                                    transition: all 0.2s ease;">
                                    <i class="bi bi-file-pdf me-2"></i>Generate Report
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript files -->
    @include('fypcoordinator.java')
</body>
</html>
