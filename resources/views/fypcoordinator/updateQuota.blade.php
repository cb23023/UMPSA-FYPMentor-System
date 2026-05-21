
<!DOCTYPE html>
<html>
  <head>
    <base href="{{ url('/') }}/">
    @extends('fypcoordinator.css')
    @section('title', 'Quota Update')

    <style>
        .container {
            margin: 20px auto;
            max-width: 800px;
            text-align: center;
        }
        h1 {
            font-size: 24px;
            font-weight: bold;
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
        .quota-controls {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .quota-button {
            background-color: #ddd;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .quota {
            //background-color: #eee;//
            padding: 5px 10px;
            border-radius: 5px;
            width: 40px;
            text-align: center;
        }
        .btn-save {
            background-color: gray;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
            margin-top: 20px;
        }
        .btn-save:hover {
            background-color: darkgray;
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
                        <h2 class="h3 mb-2" style="color: #2c3e50; font-weight: 600;">Update Lecturer Quota</h2>
                        <p class="text-muted mb-0" style="font-size: 0.95rem;">Manage lecturer supervision quota</p>
                    </div>
                </div>

                <div class="card border-0" style="background-color: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 12px;">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ url('updateQuotaList') }}" enctype="multipart/form-data" id="quota-form">
                            @csrf
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr style="background-color: #f8fafc;">
                                            <th class="py-4 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Lecturer Name</th>
                                            <th class="py-4 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Quota</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lecturer as $lect)
                                        <tr style="border-bottom: 1px solid #f1f5f9;">
                                            <td class="py-4 px-4" style="color: #334155; font-size: 1rem;">
                                                <input
                                                    class="form-control border-0 bg-transparent"
                                                    type="text"
                                                    id="name-{{ $lect->lecturerID }}"
                                                    name="name[{{ $lect->lecturerID }}]"
                                                    value="{{ $lect->name }}"
                                                    readonly
                                                    style="color: #334155; font-size: 1rem;"
                                                >
                                            </td>
                                            <td class="py-4 px-4">
                                                <div class="d-flex align-items-center gap-2">
                                                    <button
                                                        type="button"
                                                        class="btn btn-light"
                                                        onclick="decreaseQuota({{ $lect->lecturerID }})"
                                                        style="width: 40px; height: 40px; border-radius: 8px; font-weight: 600; color: #475569;"
                                                    >-</button>
                                                    <input
                                                        type="text"
                                                        class="form-control text-center"
                                                        id="quota-{{ $lect->lecturerID }}"
                                                        name="numberQuota[{{ $lect->lecturerID }}]"
                                                        value="{{ $lect->numberQuota }}"
                                                        style="width: 80px; border-radius: 8px; border: 2px solid #e2e8f0;"
                                                    >
                                                    <button
                                                        type="button"
                                                        class="btn btn-light"
                                                        onclick="increaseQuota({{ $lect->lecturerID }})"
                                                        style="width: 40px; height: 40px; border-radius: 8px; font-weight: 600; color: #475569;"
                                                    >+</button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary px-5 py-3" onclick="confirmSave()"
                                    style="background: linear-gradient(135deg, #1468b0 0%, #0f4c81 100%); 
                                    border: none; font-weight: 500; border-radius: 12px; 
                                    box-shadow: 0 4px 12px rgba(20,104,176,0.2);
                                    transition: all 0.2s ease;">
                                    <i class="bi bi-save m-1"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
    <!-- JavaScript files-->
    @include('fypcoordinator.java')
    <script>
        function increaseQuota(id) {
            const quotaInput = document.getElementById(`quota-${id}`);
            quotaInput.value = parseInt(quotaInput.value) + 1;
        }

        function decreaseQuota(id) {
            const quotaInput = document.getElementById(`quota-${id}`);
            if (parseInt(quotaInput.value) > 0) {
                quotaInput.value = parseInt(quotaInput.value) - 1;
            }
        }

        function confirmSave() {
            // Display confirmation popup
            const confirmation = confirm("Do you want to save the changes?");
            if (confirmation) {
                // If user confirms, submit the form
                document.getElementById('quota-form').submit();
            } else {
                // If user cancels, redirect to MainMenu
                window.location.href = "{{ url('home') }}";
            }
        }
    </script>
  </body>
</html>
