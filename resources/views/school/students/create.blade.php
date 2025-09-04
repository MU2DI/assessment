@extends('layouts.apps')

@section('title', 'Add New Student')

@section('content')
<div class="container-fluid">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-800">Add New Student - {{ auth()->user()->school->school_name }}</h2>
            <p class="text-sm text-gray-600 mt-1">School Code: {{ auth()->user()->center_code }}</p>
        </div>

        <div class="p-6">
            <form action="{{ route('school.students.store') }}" method="POST">
                @csrf

                <!-- Hidden field for center_code (auto-filled) -->
                <input type="hidden" name="center_code" value="{{ auth()->user()->center_code }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name *</label>
                        <input type="text" name="first_name" id="first_name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ old('first_name') }}" placeholder="Enter first name">
                        @error('first_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name *</label>
                        <input type="text" name="last_name" id="last_name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ old('last_name') }}" placeholder="Enter last name">
                        @error('last_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">Gender *</label>
                        <select name="gender" id="gender" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Gender</option>
                            <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Male</option>
                            <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Female</option>

                        </select>
                        @error('gender')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth *</label>
                        <input type="date" name="dob" id="dob" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ old('dob') }}" max="{{ now()->subYears(4)->format('Y-m-d') }}" min="{{ now()->subYears(20)->format('Y-m-d') }}">
                        @error('dob')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Level Selection (Only levels offered by the school) -->
                    <div>
                        <label for="level_id" class="block text-sm font-medium text-gray-700">Level *</label>
                        <select name="level_id" id="level_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Level</option>
                            @forelse($levels as $level)
                            <option value="{{ $level->level_id }}" {{ old('level_id') == $level->level_id ? 'selected' : '' }}>
                                {{ $level->level_name }}
                            </option>
                            @empty
                            <option value="" disabled>No levels available for your school</option>
                            @endforelse
                        </select>
                        @error('level_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        @if($levels->isEmpty())
                        <p class="mt-1 text-sm text-yellow-600">
                            No levels found for your school. Please contact admin to assign levels to your school.
                        </p>
                        @endif
                    </div>

                    <!-- Year of Study -->
                    <div>
                        <label for="academic_year" class="block text-sm font-medium text-gray-700">Academic Year *</label>
                        <select name="academic_year" id="academic_year" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Academic Year</option>
                            @foreach($academicYears as $yearValue => $yearLabel)
                            <option value="{{ $yearValue }}" {{ old('academic_year') == $yearValue ? 'selected' : '' }}>
                                {{ $yearLabel }}
                            </option>
                            @endforeach
                        </select>
                        @error('academic_year')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Display school info (read-only) -->
                <div class="mt-6 p-4 bg-gray-50 rounded-md">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">School Information (Auto-filled)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium">School:</span>
                            {{ auth()->user()->school->school_name ?? 'Not assigned' }}
                        </div>
                        <div>
                            <span class="font-medium">School Code:</span>
                            {{ auth()->user()->center_code ?? 'Not assigned' }}
                        </div>
                    </div>
                </div>

                @error('duplicate')
                <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-md">
                    <p class="text-red-600">{{ $message }}</p>
                </div>
                @enderror

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('dashboard') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" style="font-family: sans-serif color-black;" class="ml-3 inline-flex justify-center py-2 px-4 border shadow-sm text-sm font-medium rounded-md text-gray-700 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" {{ $levels->isEmpty() ? 'disabled' : '' }}>
                        Add Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($levels->isEmpty())
<script>
    // Disable form submission if no levels available
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Cannot add student: No levels available for your school. Please contact administrator.');
        });
    });

</script>
@endif
@endsection
