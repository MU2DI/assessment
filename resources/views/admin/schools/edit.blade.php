@extends('layouts.app')

@section('title', 'Edit School')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-2xl font-semibold text-gray-800">Edit School: {{ $school->center_code }}</h2>
    </div>

    <!-- Add hidden field for center_code -->
    <input type="hidden" name="center_code" value="{{ $school->center_code }}">

    <div class="p-6">
        <form action="{{ route('admin.schools.update', $school->center_code) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 mt-4">
                <!-- School Name -->
                <div>
                    <label class="block text-gray-700">School Name</label>
                    <input type="text" name="school_name" value="{{ old('school_name', $school->school_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    @error('school_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-gray-700">Address</label>
                    <textarea name="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('address', $school->address) }}</textarea>
                    @error('address')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Toggle -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ $school->is_active ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700">Active School</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('admin.schools.index') }}" class="ml-3 px-3 py-2 text-warning-600 hover:text-warning-900 btn btn-sm btn-outline-warning">
                    Cancel
                </a>
                <button type="submit" class="ml-3 px-4 py-2 text-success-600 hover:text-success btn btn-sm btn-outline-success">

                    Update School

                </button>
            </div>
        </form>

        
    </div>
</div>
@endsection
