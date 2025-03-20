<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Alumni Forum - Student List</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </head>
    <body class="bg-light">
        <div class="min-vh-100">
            @if (Route::has('login'))
                <div class="position-fixed top-0 end-0 p-3 text-end">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-decoration-none text-secondary fw-semibold">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-decoration-none text-secondary fw-semibold">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ms-3 text-decoration-none text-secondary fw-semibold">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="container py-5">
                <div class="row g-4">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <h1 class="display-4 fw-bold">Student Directory</h1>
                    </div>

                    <div class="col-12">
                    <div class="card shadow-lg border-0 bg-white bg-opacity-75 p-4">
                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <svg class="bi bi-search" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </span>
                                <form class="search-form">
                                <div class="position-relative">
                                    <input type="text" name="search" id="searchInput" placeholder="Search by name, email, or company..." class="form-control border-start-0 ps-0">
                                    <button type="button" id="clearSearch" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-secondary" style="display: none;">
                                        <svg class="bi bi-x" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const searchInput = document.getElementById('searchInput');
                                const clearButton = document.getElementById('clearSearch');
                                const departmentSelect = document.getElementById('department');
                                const sessionSelect = document.getElementById('session');
                                const bloodGroupSelect = document.getElementById('blood_group');
                                const genderSelect = document.getElementById('gender');
                                let searchTimeout;

                                function updateSearch() {
                                    const currentUrl = new URL(window.location.href);
                                    const searchValue = searchInput.value.trim();
                                    
                                    if (searchValue) {
                                        currentUrl.searchParams.set('search', searchValue);
                                    } else {
                                        currentUrl.searchParams.delete('search');
                                    }

                                    if (departmentSelect.value) {
                                        currentUrl.searchParams.set('department', departmentSelect.value);
                                    } else {
                                        currentUrl.searchParams.delete('department');
                                    }

                                    if (sessionSelect.value) {
                                        currentUrl.searchParams.set('session', sessionSelect.value);
                                    } else {
                                        currentUrl.searchParams.delete('session');
                                    }

                                    if (bloodGroupSelect.value) {
                                        currentUrl.searchParams.set('blood_group', bloodGroupSelect.value);
                                    } else {
                                        currentUrl.searchParams.delete('blood_group');
                                    }

                                    if (genderSelect.value) {
                                        currentUrl.searchParams.set('gender', genderSelect.value);
                                    } else {
                                        currentUrl.searchParams.delete('gender');
                                    }

                                    window.location.href = currentUrl.toString();
                                }

                                searchInput.addEventListener('input', function() {
                                    clearButton.style.display = this.value.length > 0 ? 'block' : 'none';
                                    clearTimeout(searchTimeout);
                                    if (this.value.trim().length >= 10) {
                                        searchTimeout = setTimeout(updateSearch, 300);
                                    }
                                });

                                departmentSelect.addEventListener('change', updateSearch);
                                sessionSelect.addEventListener('change', updateSearch);
                                bloodGroupSelect.addEventListener('change', updateSearch);
                                genderSelect.addEventListener('change', updateSearch);

                                clearButton.addEventListener('click', function() {
                                    searchInput.value = '';
                                    this.style.display = 'none';
                                    updateSearch();
                                });
                            });
                        </script>
                            <div class="col-md-3">
                                <label for="department" class="form-label">Department</label>
                                <select id="department" name="department" class="form-select">
                                    <option value="">All Departments</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="session" class="form-label">Session</label>
                                <select id="session" name="session" class="form-select">
                                    <option value="">All Sessions</option>
                                    @foreach($sessions as $session)
                                        <option value="{{ $session }}" {{ request('session') == $session ? 'selected' : '' }}>{{ $session }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="blood_group" class="form-label">Blood Group</label>
                                <select id="blood_group" name="blood_group" class="form-select">
                                    <option value="">All Blood Groups</option>
                                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $blood)
                                        <option value="{{ $blood }}" {{ request('blood_group') == $blood ? 'selected' : '' }}>{{ $blood }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select id="gender" name="gender" class="form-select">
                                    <option value="">All Genders</option>
                                    @foreach(['male', 'female', 'other'] as $g)
                                        <option value="{{ $g }}" {{ request('gender') == $g ? 'selected' : '' }}>{{ ucfirst($g) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4 mt-3">
                        @foreach ($students as $student)
                            <div class="col">
                            <div class="card bg-primary bg-gradient shadow-lg border-0 text-white position-relative overflow-hidden">
                                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXRoIGQ9Ik0wIDI1QzIwIDI1IDIwIDc1IDQwIDc1QzYwIDc1IDYwIDI1IDgwIDI1QzEwMCAyNSAxMDAgNzUgMTIwIDc1QzE0MCA3NSAxNDAgMjUgMTYwIDI1QzE4MCAyNSAxODAgNzUgMjAwIDc1IiBmaWxsPSJub25lIiBzdHJva2U9XCJyZ2JhKDI1NSwyNTUsMjU1LDAuMSlcIiBzdHJva2Utd2lkdGg9XCIyXCIvPjwvc3ZnPg==')] opacity-20"></div>
                                <div class="p-6 relative z-10">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="flex-shrink-0">
                                        @if($student->photo)
                                            <img src="{{ $student->photo }}" alt="{{ $student->name }}" class="rounded-circle object-fit-cover" width="64" height="64">
                                        @else
                                            <div class="rounded-circle bg-white bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px">
                                                <svg class="text-white-50" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 min-width-0">
                                        <h3 class="h4 mb-1 text-white">{{ $student->name }}</h3>
                                        <p class="text-white-50 small mb-0">{{ $student->department }} ({{ $student->session }})</p>
                                    </div>
                                </div>
                                    <div class="mt-4 space-y-2">
                                        <p class="text-sm text-white/90 flex items-center">
                                            <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            {{ $student->email }}
                                        </p>
                                        @if($student->phone)
                                        <p class="text-sm text-white/90 flex items-center">
                                            <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            {{ $student->phone }}
                                        </p>
                                        @endif
                                        <div class="grid grid-cols-2 gap-4 mt-2">
                                            <div class="flex items-center text-sm text-white/90">
                                                <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                                </svg>
                                                {{ $student->blood_group }}
                                            </div>
                                            @if($student->gender)
                                            <div class="flex items-center text-sm text-white/90">
                                                <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                {{ ucfirst($student->gender) }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @if($student->employment_status)
                                    <div class="mt-4 pt-4 border-t border-white/10">
                                        <p class="text-sm text-white/90">
                                            <span class="text-white/70">Employment:</span> {{ ucfirst($student->employment_status) }}
                                            @if($student->company_name)
                                            at {{ $student->company_name }}
                                            @endif
                                            @if($student->position)
                                            as {{ $student->position }}
                                            @endif
                                        </p>
                                    </div>
                                    @endif
                                    @if($student->present_address)
                                    <div class="mt-2">
                                        <p class="text-sm text-white/90">
                                            <span class="text-white/70">Address:</span> {{ $student->present_address }}
                                        </p>
                                    </div>
                                    @endif
                                    <div class="mt-4 flex justify-end">
                                        <button onclick="showStudentDetails({{ $student->id }})" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg text-white/90 hover:text-white transition-colors text-sm font-medium">View Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    <div class="mt-6">
                        {{ $students->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Details Modal -->
        <div class="modal fade" id="studentDetailsModal" tabindex="-1" aria-labelledby="studentDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="studentDetailsModalLabel">Student Details</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 text-center mb-4 mb-md-0">
                                <div id="studentPhoto" class="mb-3">
                                    <!-- Photo will be inserted here -->
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h3 id="studentName" class="mb-3"><!-- Name will be inserted here --></h3>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <p><strong>Department:</strong> <span id="studentDepartment"></span></p>
                                        <p><strong>Session:</strong> <span id="studentSession"></span></p>
                                        <p><strong>Blood Group:</strong> <span id="studentBloodGroup"></span></p>
                                        <p><strong>Gender:</strong> <span id="studentGender"></span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Email:</strong> <span id="studentEmail"></span></p>
                                        <p><strong>Phone:</strong> <span id="studentPhone"></span></p>
                                        <p><strong>Address:</strong> <span id="studentAddress"></span></p>
                                    </div>
                                </div>
                                <div class="mt-4" id="employmentDetails">
                                    <h4 class="h5 mb-3">Employment Information</h4>
                                    <p><strong>Status:</strong> <span id="employmentStatus"></span></p>
                                    <p><strong>Company:</strong> <span id="companyName"></span></p>
                                    <p><strong>Position:</strong> <span id="position"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        // Handle search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchQuery = e.target.value.trim();
            const currentUrl = new URL(window.location.href);
            
            if (searchQuery) {
                currentUrl.searchParams.set('search', searchQuery);
            } else {
                currentUrl.searchParams.delete('search');
            }
            
            // Update the URL and reload the page with the search query
            window.location.href = currentUrl.toString();
        });

        function showStudentDetails(studentId) {
            // Fetch student details from the server
            fetch(`/api/students/${studentId}`)
                .then(response => response.json())
                .then(student => {
                    // Update modal content with student details
                    document.getElementById('studentName').textContent = student.name;
                    document.getElementById('studentDepartment').textContent = student.department;
                    document.getElementById('studentSession').textContent = student.session;
                    document.getElementById('studentBloodGroup').textContent = student.blood_group;
                    document.getElementById('studentGender').textContent = student.gender ? student.gender.charAt(0).toUpperCase() + student.gender.slice(1) : 'Not specified';
                    document.getElementById('studentEmail').textContent = student.email;
                    document.getElementById('studentPhone').textContent = student.phone || 'Not provided';
                    document.getElementById('studentAddress').textContent = student.present_address || 'Not provided';

                    // Update employment information
                    document.getElementById('employmentStatus').textContent = student.employment_status || 'Not specified';
                    document.getElementById('companyName').textContent = student.company_name || 'Not specified';
                    document.getElementById('position').textContent = student.position || 'Not specified';

                    // Update student photo
                    const photoContainer = document.getElementById('studentPhoto');
                    if (student.photo) {
                        photoContainer.innerHTML = `<img src="${student.photo}" alt="${student.name}" class="rounded-circle img-fluid" style="width: 150px; height: 150px; object-fit: cover;">`;
                    } else {
                        photoContainer.innerHTML = `
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px;">
                                <svg class="text-white" width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>`;
                    }

                    // Show the modal
                    const modal = new bootstrap.Modal(document.getElementById('studentDetailsModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Error fetching student details:', error);
                    alert('Error loading student details. Please try again.');
                });
        }
        </script>
    </body>
</html>
