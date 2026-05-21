<!DOCTYPE html>
<html>
  <head>
    @extends('fypcoordinator.css')
    @section('title', 'Manage Quota')
    <style>
        .header a {
            text-decoration: none;
            font-weight: bold;
            color: black;
        }
        .container {
            margin: 20px auto;
            max-width: 800px;
            text-align: center;
        }
        h1 {
            font-size: 24px;
            font-weight: bold;
        }
        .btn-container {
            margin: 20px 0;
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        .btn-update, .btn-report {
            background-color: gray;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
        }
        .btn-update:hover, .btn-report:hover {
            background-color: darkgray;
        }
        .lecturer-list {
            list-style-type: none;
            padding: 0;
            margin: 20px 0;
        }
        .lecturer-item {
            background-color: #f4f4f4;
            padding: 15px;
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 5px;
        }
        .quota {
            background-color: #ddd;
            padding: 5px 10px;
            border-radius: 5px;
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
                    <h2 class="h3 mb-2" style="color: #2c3e50; font-weight: 600;">Lecturer Quota Management</h2>
                    <div class="d-flex gap-2">
                        <a class="btn btn-primary px-4 py-2 m-1" href="{{url('updateQuota')}}" 
                            style="background-color: #1468b0; border: none; font-weight: 500;">
                            <i class="bi bi-pencil-square me-2"></i>Update Quota
                        </a>
                        <form action="{{ url('generateQuota') }}" method="post" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success px-4 py-2 m-1" 
                                style="background-color: #10b981; border: none; font-weight: 500;">
                                <i class="bi bi-file-pdf me-2"></i>Generate Report
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card border-0" style="background-color: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 12px;">
                    <div class="card-body px-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr style="background-color: #f8fafc;">
                                        <th class="py-4 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Lecturer Name</th>
                                        <th class="py-4 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Quota</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lecturer as $lecturer)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td class="py-4 px-4" style="color: #334155; font-size: 1rem;">{{ $lecturer->name }}</td>
                                        <td class="py-4 px-4" style="color: #334155; font-size: 1rem;">{{ $lecturer->numberQuota }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('fypcoordinator.java')
  </body>
</html>
