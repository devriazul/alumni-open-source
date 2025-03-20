<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Students Management') }}
            </h2>
            <a href="{{ route('students.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Add Student
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Search Section -->
                    <div class="mb-6 space-y-4">
                        <form class="dashboard-search-form">
                            <div class="flex gap-4">
                            <div class="flex-1 relative">
                                <input type="text" id="search" name="search" placeholder="Search by name, email..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <button type="button" id="clearSearch" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" style="display: none;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <select id="department" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">All Departments</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept }}">{{ $dept }}</option>
                                @endforeach
                            </select>
                            <select id="session" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">All Sessions</option>
                                @foreach($sessions as $sess)
                                    <option value="{{ $sess }}">{{ $sess }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 text-center">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Session</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($students as $student)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($student->photo)
                                            <img src="{{ $student->photo }}" alt="{{ $student->name }}" class="h-10 w-10 rounded-full object-cover" width="80">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->department }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->session }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('students.edit', $student) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this student?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const departmentSelect = document.getElementById('department');
    const sessionSelect = document.getElementById('session');
    let searchTimeout;

    function updateFilters() {
        const currentUrl = new URL(window.location.href);
        
        const searchValue = searchInput.value.trim();
        const departmentValue = departmentSelect.value;
        const sessionValue = sessionSelect.value;

        if (searchValue) {
            currentUrl.searchParams.set('search', searchValue);
        } else {
            currentUrl.searchParams.delete('search');
        }

        if (departmentValue) {
            currentUrl.searchParams.set('department', departmentValue);
        } else {
            currentUrl.searchParams.delete('department');
        }

        if (sessionValue) {
            currentUrl.searchParams.set('session', sessionValue);
        } else {
            currentUrl.searchParams.delete('session');
        }

        window.location.href = currentUrl.toString();
    }

    searchInput.addEventListener('input', function() {
        const clearButton = document.getElementById('clearSearch');
        clearButton.style.display = this.value.length > 0 ? 'block' : 'none';
        clearTimeout(searchTimeout);
        if (this.value.trim().length >= 3) {
            searchTimeout = setTimeout(updateFilters, 300);
        }
    });

    departmentSelect.addEventListener('change', updateFilters);
    sessionSelect.addEventListener('change', updateFilters);

    document.getElementById('clearSearch').addEventListener('click', function() {
        searchInput.value = '';
        this.style.display = 'none';
        updateFilters();
    });
});
</script>
