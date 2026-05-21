<!DOCTYPE html>
<html>

<head>
    @extends('fypcoordinator.css')
    @section('title', 'User List')
    <style>
        .page-content {
            background-color: #f8f9fa;
            min-height: 100vh;
            padding: 20px;
        }
        table {
            margin: 20px 0;
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 15px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
        td {
            padding: 10px;
            color: #334155;
        }
        .profile-picture {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .nav-tabs {
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 1.5rem;
        }
        .nav-tabs .nav-link {
            border: none;
            color: #64748b;
            font-weight: 500;
            padding: 1rem 1.5rem;
            margin-right: 0.5rem;
            border-radius: 0.5rem 0.5rem 0 0;
            transition: all 0.2s ease;
        }
        .nav-tabs .nav-link:hover {
            color: #334155;
            background-color: #f8fafc;
        }
        .nav-tabs .nav-link.active {
            color: #1468b0;
            background-color: #ffffff;
            border-bottom: 3px solid #1468b0;
        }
        .tab-content {
            background-color: #ffffff;
            border-radius: 0 0.5rem 0.5rem 0.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .pagination {
            margin-top: 1.5rem;
            justify-content: center;
            gap: 0.5rem;
        }
        .pagination button {
            padding: 0.5rem 1rem;
            border: 1px solid #e2e8f0;
            background-color: #ffffff;
            color: #1468b0;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .pagination button:hover:not(:disabled) {
            background-color: #f8fafc;
            border-color: #1468b0;
        }
        .pagination button.active {
            background-color: #1468b0;
            border-color: #1468b0;
            color: #ffffff;
        }
        .pagination button:disabled {
            color: #94a3b8;
            background-color: #f8fafc;
            cursor: not-allowed;
        }
        .pagination-info {
            text-align: center;
            color: #64748b;
            margin-top: 0.5rem;
            font-size: 0.875rem;
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
                    <h2 class="h3 mb-0" style="color: #2c3e50; font-weight: 600;">User List</h2>
                    <div class="d-flex gap-2">
                        <a class="btn btn-primary px-4 py-2 m-1" href="{{'uploadUser'}}" style="background-color: #1468b0; border: none; font-weight: 500;">
                            <i class="bi bi-upload me-2"></i>Upload
                        </a>
                        <a class="btn btn-success px-4 py-2 m-1" href="{{'fypReport'}}" style="background-color: #10b981; border: none; font-weight: 500;">
                            <i class="bi bi-file-pdf me-2"></i>Generate PDF
                        </a>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs" id="userTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="lecturer-tab" data-bs-toggle="tab" data-bs-target="#lecturer" type="button" role="tab" aria-controls="lecturer" aria-selected="true">
                            <i class="bi bi-person-badge me-2"></i>Lecturers
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="student-tab" data-bs-toggle="tab" data-bs-target="#student" type="button" role="tab" aria-controls="student" aria-selected="false">
                            <i class="bi bi-mortarboard me-2"></i>Students
                        </button>
                    </li>
                </ul>

                <!-- Tabs Content -->
                <div class="tab-content" id="userTabsContent">
                    <!-- Lecturer Tab -->
                    <div class="tab-pane fade show active" id="lecturer" role="tabpanel" aria-labelledby="lecturer-tab">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" id="lecturerTable">
                                <thead>
                                    <tr style="background-color: #f8fafc;">
                                        <th class="py-4 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Profile</th>
                                        <th class="py-4 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Lecturer ID</th>
                                        <th class="py-4 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Name</th>
                                        <th class="py-4 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Email</th>
                                        <th class="py-4 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Quota</th>
                                    </tr>
                                </thead>
                                <tbody id="lecturerTableBody">
                                    @foreach($lecturers as $lecturer)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td class="py-4 px-4" style="color: #334155; font-size: 1rem;">
                                            <img src="{{ asset('lecturerProfile/' . $lecturer->profilePicture) }}" 
                                                 alt="Profile Picture" 
                                                 class="profile-picture">
                                        </td>
                                        <td class="py-4 px-4" style="color: #334155; font-size: 1rem;">{{ $lecturer->lecturerID }}</td>
                                        <td class="py-4 px-4" style="color: #334155; font-size: 1rem;">{{ $lecturer->name }}</td>
                                        <td class="py-4 px-4" style="color: #334155; font-size: 1rem;">{{ $lecturer->user->email }}</td>
                                        <td class="py-4 px-4" style="color: #334155; font-size: 1rem;">{{ $lecturer->numberQuota }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex flex-column align-items-center">
                            <div class="pagination" id="lecturerPagination"></div>
                            <div class="pagination-info" id="lecturerPaginationInfo"></div>
                        </div>
                    </div>

                    <!-- Student Tab -->
                    <div class="tab-pane fade" id="student" role="tabpanel" aria-labelledby="student-tab">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" id="studentTable">
                                <thead>
                                    <tr style="background-color: #f8fafc;">
                                        <th class="py-4 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Student ID</th>
                                        <th class="py-4 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Name</th>
                                        <th class="py-4 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Email</th>
                                        <th class="py-4 px-4" style="font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0;">Course</th>
                                    </tr>
                                </thead>
                                <tbody id="studentTableBody" class="">
                                    @foreach($students as $student)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td class="py-4 px-4" style="color: #334155; font-size: 1rem;">{{ $student->studentID }}</td>
                                        <td class="py-4 px-4" style="color: #334155; font-size: 1rem;">{{ $student->name }}</td>
                                        <td class="py-4 px-4" style="color: #334155; font-size: 1rem;">{{ $student->user->email }}</td>
                                        <td class="py-4 px-4" style="color: #334155; font-size: 1rem;">{{ $student->course }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex flex-column align-items-center">
                            <div class="pagination" id="studentPagination"></div>
                            <div class="pagination-info" id="studentPaginationInfo"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript files-->
    @include('fypcoordinator.java')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        class Pagination {
            constructor(items, itemsPerPage = 10) {
                this.items = items;
                this.itemsPerPage = itemsPerPage;
                this.currentPage = 1;
                this.totalPages = Math.ceil(items.length / itemsPerPage);
            }

            getCurrentPageItems() {
                const start = (this.currentPage - 1) * this.itemsPerPage;
                const end = start + this.itemsPerPage;
                return this.items.slice(start, end);
            }

            goToPage(page) {
                if (page >= 1 && page <= this.totalPages) {
                    this.currentPage = page;
                    return true;
                }
                return false;
            }

            getPaginationInfo() {
                const start = (this.currentPage - 1) * this.itemsPerPage + 1;
                const end = Math.min(this.currentPage * this.itemsPerPage, this.items.length);
                return `Showing ${start} to ${end} of ${this.items.length} entries`;
            }
        }

        class TablePagination {
            constructor(tableId, paginationId, infoId, items, itemsPerPage = 10) {
                this.tableBody = document.querySelector(`#${tableId} tbody`);
                this.paginationContainer = document.getElementById(paginationId);
                this.infoContainer = document.getElementById(infoId);
                this.pagination = new Pagination(items, itemsPerPage);
                this.setupPagination();
                this.updateTable();
            }

            setupPagination() {
                this.paginationContainer.innerHTML = '';
                
                // Previous button
                const prevButton = document.createElement('button');
                prevButton.innerHTML = '&laquo;';
                prevButton.addEventListener('click', () => this.goToPage(this.pagination.currentPage - 1));
                this.paginationContainer.appendChild(prevButton);

                // Page numbers
                for (let i = 1; i <= this.pagination.totalPages; i++) {
                    const pageButton = document.createElement('button');
                    pageButton.textContent = i;
                    pageButton.addEventListener('click', () => this.goToPage(i));
                    this.paginationContainer.appendChild(pageButton);
                }

                // Next button
                const nextButton = document.createElement('button');
                nextButton.innerHTML = '&raquo;';
                nextButton.addEventListener('click', () => this.goToPage(this.pagination.currentPage + 1));
                this.paginationContainer.appendChild(nextButton);

                this.updatePaginationButtons();
            }

            updatePaginationButtons() {
                const buttons = this.paginationContainer.getElementsByTagName('button');
                
                // Previous button
                buttons[0].disabled = this.pagination.currentPage === 1;
                
                // Page number buttons
                for (let i = 1; i <= this.pagination.totalPages; i++) {
                    buttons[i].classList.toggle('active', i === this.pagination.currentPage);
                }
                
                // Next button
                buttons[buttons.length - 1].disabled = this.pagination.currentPage === this.pagination.totalPages;
            }

            updateTable() {
                const items = this.pagination.getCurrentPageItems();
                this.tableBody.innerHTML = ''; // Clear existing rows
                items.forEach(item => {
                    this.tableBody.appendChild(item); // Append the actual <tr> element
                });
                this.updatePaginationButtons();
                this.infoContainer.textContent = this.pagination.getPaginationInfo();
            }

            goToPage(page) {
                if (this.pagination.goToPage(page)) {
                    this.updateTable();
                }
            }
        }

        // Initialize pagination for both tables
        document.addEventListener('DOMContentLoaded', function() {
            // Get all rows from both tables
            const lecturerRows = Array.from(document.querySelectorAll('#lecturerTableBody tr'));
            const studentRows = Array.from(document.querySelectorAll('#studentTableBody tr'));

            // Create pagination instances
            new TablePagination('lecturerTable', 'lecturerPagination', 'lecturerPaginationInfo', lecturerRows);
            new TablePagination('studentTable', 'studentPagination', 'studentPaginationInfo', studentRows);
        });
    </script>
</body>

</html>
