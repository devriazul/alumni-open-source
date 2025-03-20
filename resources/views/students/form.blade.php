<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($student) ? __('Edit Student') : __('Add New Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ isset($student) ? route('students.update', $student) : route('students.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @if(isset($student))
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $student->name ?? '')" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $student->email ?? '')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="phone" :value="__('Phone')" />
                                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $student->phone ?? '')" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="photo" :value="__('Photo')" />
                                <input type="file" id="photo" name="photo" class="mt-1 block w-full" accept="image/*" />
                                @if(isset($student) && $student->photo)
                                    <div class="mt-2">
                                        <img src="{{ $student->photo }}" alt="Current photo" class="h-20 w-20 object-cover rounded">
                                    </div>
                                @endif
                                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Academic Information -->
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="session" :value="__('Session')" />
                                <x-text-input id="session" name="session" type="text" class="mt-1 block w-full" :value="old('session', $student->session ?? '')" required />
                                <x-input-error :messages="$errors->get('session')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="department" :value="__('Department')" />
                                <x-text-input id="department" name="department" type="text" class="mt-1 block w-full" :value="old('department', $student->department ?? '')" required />
                                <x-input-error :messages="$errors->get('department')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="gender" :value="__('Gender')" />
                                <select id="gender" name="gender" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', $student->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $student->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $student->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="blood_group" :value="__('Blood Group')" />
                                <select id="blood_group" name="blood_group" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Select Blood Group</option>
                                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group)
                                        <option value="{{ $group }}" {{ old('blood_group', $student->blood_group ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('blood_group')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="present_address" :value="__('Present Address')" />
                                <textarea id="present_address" name="present_address" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="3">{{ old('present_address', $student->present_address ?? '') }}</textarea>
                                <x-input-error :messages="$errors->get('present_address')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="permanent_address" :value="__('Permanent Address')" />
                                <textarea id="permanent_address" name="permanent_address" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="3">{{ old('permanent_address', $student->permanent_address ?? '') }}</textarea>
                                <x-input-error :messages="$errors->get('permanent_address')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Employment Information -->
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="employment_status" :value="__('Employment Status')" />
                                <select id="employment_status" name="employment_status" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Select Status</option>
                                    <option value="employed" {{ old('employment_status', $student->employment_status ?? '') == 'employed' ? 'selected' : '' }}>Employed</option>
                                    <option value="unemployed" {{ old('employment_status', $student->employment_status ?? '') == 'unemployed' ? 'selected' : '' }}>Unemployed</option>
                                    <option value="student" {{ old('employment_status', $student->employment_status ?? '') == 'student' ? 'selected' : '' }}>Student</option>
                                </select>
                                <x-input-error :messages="$errors->get('employment_status')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="company_name" :value="__('Company Name')" />
                                <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full" :value="old('company_name', $student->company_name ?? '')" />
                                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="position" :value="__('Position')" />
                                <x-text-input id="position" name="position" type="text" class="mt-1 block w-full" :value="old('position', $student->position ?? '')" />
                                <x-input-error :messages="$errors->get('position')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button class="ml-3">
                            {{ isset($student) ? __('Update Student') : __('Create Student') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>