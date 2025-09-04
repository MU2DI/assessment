@extends('layouts.apps')

@section('title', 'Edit Student')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-2xl font-semibold text-gray-800">Edit Student: {{ $student->first_name }} {{ $student->last_name }}</h2>
    </div>

    <div class="p-6">
        <form action="{{ route('school.students.update', $student->student_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name *</label>
                    <input type="text" name="first_name" id="first_name" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('first_name', $student->first_name) }}"
                           placeholder="Enter first name">
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name *</label>
                    <input type="text" name="last_name" id="last_name" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('last_name', $student->last_name) }}"
                           placeholder="Enter last name">
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender *</label>
                    <select name="gender" id="gender" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Gender</option>
                        <option value="M" {{ old('gender', $student->gender) == 'M' ? 'selected' : '' }}>Male</option>
                        <option value="F" {{ old('gender', $student->gender) == 'F' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date of Birth -->
                <div>
                    <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth *</label>
                    <input type="date" name="dob" id="dob" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('dob', $student->dob->format('Y-m-d')) }}"
                           max="{{ now()->subYears(4)->format('Y-m-d') }}">
                    @error('dob')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Level Selection -->
                <div>
                    <label for="level_id" class="block text-sm font-medium text-gray-700">Level *</label>
                    <select name="level_id" id="level_id" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Level</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->level_id }}" {{ old('level_id', $student->level_id) == $level->level_id ? 'selected' : '' }}>
                                {{ $level->level_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('level_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Academic Year -->
                <div>
                    <label for="academic_year" class="block text-sm font-medium text-gray-700">Academic Year *</label>
                    <select name="academic_year" id="academic_year" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Academic Year</option>
                        @php
                            $currentYear = now()->year;
                            $academicYears = [
                                $currentYear - 1 => ($currentYear - 1) . ' (Previous Year)',
                                $currentYear => $currentYear . ' (Current Year)'
                            ];
                        @endphp
                        @foreach($academicYears as $yearValue => $yearLabel)
                            <option value="{{ $yearValue }}" {{ old('academic_year', $student->academic_year) == $yearValue ? 'selected' : '' }}>
                                {{ $yearLabel }}
                            </option>
                        @endforeach
                    </select>
                    @error('academic_year')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" 
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                               {{ old('is_active', $student->is_active) ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700">Active Student</span>
                    </label>
                    @error('is_active')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('school.students.index') }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </a>
                <button type="submit" style="font-family: sans-serif color-black;"
                        class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Student
                </button>
            </div>
        </form>
    </div>
</div>
@endsection