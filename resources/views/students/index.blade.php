<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Students') }}</h2>
            <a href="{{ route('students.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Add New Student') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Search Filters -->
                <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <select id="session" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Select Session</option>
                        @foreach($sessions as $session)
                            <option value="{{ $session }}">{{ $session }}</option>
                        @endforeach
                    </select>
                    <select id="department" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department }}">{{ $department }}</option>
                        @endforeach
                    </select>
                    <select id="gender" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                    <select id="blood_group" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Select Blood Group</option>
                        @foreach($bloodGroups as $group)
                            <option value="{{ $group }}">{{ $group }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Students Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($students as $student)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <div class="p-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="h-12 w-12 rounded-full object-cover" src="{{ $student->photo ?? asset('images/default-avatar.png') }}" alt="{{ $student->name }}">
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $student->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $student->department }} ({{ $student->session }})</p>
                                    </div>
                                </div>
                                <div class="mt-4 space-y-2">
                                    <p class="text-sm text-gray-600"><span class="font-medium">Email:</span> {{ $student->email }}</p>
                                    <p class="text-sm text-gray-600"><span class="font-medium">Blood Group:</span> {{ $student->blood_group }}</p>
                                    @if($student->employment_status)
                                        <p class="text-sm text-gray-600"><span class="font-medium">Current Position:</span> {{ $student->position }} at {{ $student->company_name }}</p>
                                    @endif
                                </div>
                                <div class="mt-4 flex justify-end space-x-2">
                                    <button onclick="showStudentDetails({{ $student->id }})" class="text-blue-600 hover:text-blue-800">View Details</button>
                                    <a href="{{ route('students.edit', $student) }}" class="text-gray-600 hover:text-gray-800">Edit</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Student Details Modal -->
    <div id="studentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div id="studentModalContent"></div>
        </div>
    </div>

    @push('scripts')
    <script>
        function showStudentDetails(studentId) {
            fetch(`/students/${studentId}`)
                .then(response => response.json())
                .then(student => {
                    document.getElementById('studentModalContent').innerHTML = `
                        <div class="flex justify-between items-start">
                            <h2 class="text-xl font-bold mb-4">${student.name}</h2>
                            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <img class="w-full h-48 object-cover rounded" src="${student.photo || '/images/default-avatar.png'}" alt="${student.name}">
                                <div class="mt-4">
                                    <p><strong>Email:</strong> ${student.email}</p>
                                    <p><strong>Phone:</strong> ${student.phone || 'N/A'}</p>
                                    <p><strong>Blood Group:</strong> ${student.blood_group || 'N/A'}</p>
                                    <p><strong>Gender:</strong> ${student.gender}</p>
                                </div>
                            </div>
                            <div>
                                <p><strong>Session:</strong> ${student.session}</p>
                                <p><strong>Department:</strong> ${student.department}</p>
                                <p><strong>Present Address:</strong> ${student.present_address || 'N/A'}</p>
                                <p><strong>Permanent Address:</strong> ${student.permanent_address || 'N/A'}</p>
                                <p><strong>Employment Status:</strong> ${student.employment_status || 'N/A'}</p>
                                ${student.employment_status ? `
                                    <p><strong>Company:</strong> ${student.company_name}</p>
                                    <p><strong>Position:</strong> ${student.position}</p>
                                ` : ''}
                            </div>
                        </div>
                    `;
                    document.getElementById('studentModal').classList.remove('hidden');
                });
        }

        function closeModal() {
            document.getElementById('studentModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('studentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Filter functionality
        const filters = ['session', 'department', 'gender', 'blood_group'];
        filters.forEach(filter => {
            document.getElementById(filter).addEventListener('change', function() {
                applyFilters();
            });
        });

        function applyFilters() {
            const queryParams = filters
                .map(filter => `${filter}=${document.getElementById(filter).value}`)
                .filter(param => param.split('=')[1])
                .join('&');

            window.location.href = `${window.location.pathname}?${queryParams}`;
        }
    </script>
    @endpush
</x-app-layout>