@extends('layouts.apps')

@section('title', 'Student Management')
@section('page_title', 'Student Management')
@section('breadcrumb', 'Students')

@section('content')
<div class="">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-content-md-end">
            <a href="{{ route('school.students.create') }}" class="btn btn-success">
                <i class="fas fa-plus mr-2"></i> Add New Student
            </a>

        </div>
    </div>

    <div class="p-6">
        @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
        @endif

        <!-- Filters Section -->
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Filter Students</h3>

            <form method="GET" action="{{ route('school.students.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Level Filter -->
                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700 mb-1">By Level:</label>
                        <select name="level" id="level" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Levels</option>
                            @foreach($levels as $level)
                            <option value="{{ $level->level_id }}" {{ request('level') == $level->level_id ? 'selected' : '' }}>
                                {{ $level->level_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Academic Year Filter -->
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-1">By Year:</label>
                        <select name="year" id="year" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Years</option>
                            @foreach($academicYears as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">By Status:</label>
                        <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Status</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- Filter Actions -->
                    <div class="flex items-end">
                        <button type="submit" class="btn btn-outline-primary">
                            Apply Filters
                        </button>
                        <a href="{{ route('school.students.index') }}" class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                            Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>


        <!-- Display Active Filters -->
        @if(request()->anyFilled(['level', 'year', 'status']))
        <div class="bg-blue-50 p-3 rounded-lg mb-4">
            <h4 class="text-sm font-medium text-blue-800 mb-2">Active Filters:</h4>
            <div>
                @if(request('level'))
                @php $filteredLevel = $levels->firstWhere('level_id', request('level')); @endphp
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                    Level: {{ $filteredLevel->level_name ?? request('level') }}
                </span>
                @endif

                @if(request('year'))
                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">
                    Year: {{ request('year') }}
                </span>
                @endif

                @if(request('status') !== null)
                <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded">
                    Status: {{ request('status') ? 'Active' : 'Inactive' }}
                </span>
                @endif
            </div>
        </div>
        @endif

        <table class="table table-bordered table-striped table-hover">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-center uppercase">S/No</th>
                    <th class="px-6 py-3 text-center uppercase">Student Name</th>
                    <th class="px-6 py-3 text-center uppercase">Gender</th>
                    <th class="px-6 py-3 text-center uppercase">Date Of Birth</th>
                    <th class="px-6 py-3 text-center uppercase">Level</th>
                    <th class="px-6 py-3 text-center uppercase">Year</th>
                    <th class="px-6 py-3 text-center uppercase">Status</th>
                    <th class="px-6 py-3 text-center uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                $i=1;

                @endphp

                @forelse($students as $student)

                <tr>
                    <td class="px-6 py-4 text-center text-gray-800">{{$i++}}</td>
                    <td class="px-6 py-4 text-left text-gray-800">{{$student->first_name. ' '. $student->last_name}}</td>
                    <td class="px-6 py-4 text-center text-gray-800">{{$student->gender}}</td>
                    <td class="px-6 py-4 text-center text-gray-800">{{ \Carbon\Carbon::parse($student->dob)->format('d-m-Y') }}</td>
                    <td class="px-6 py-4 text-center text-gray-800">{{$student->level->level_name ?? 'N/A'}}</td>
                    <td class="px-6 py-4 text-center text-gray-800">{{$student->academic_year}}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="badge {{ $student->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $student->is_active ? 'Active' : 'Not Active' }}
                        </span>
                    </td>

                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            @if(request('level') && request('year'))
                            <a href="{{ route('school.exams.assign', ['level' => request('level'), 'year' => request('year')]) }}" class="btn btn-primary ms-2">
                                <i class="fas fa-clipboard-check me-1"></i> Assign filtered to exam
                            </a>
                            @else
                            <button type="button" class="btn btn-secondary ms-2" disabled title="Choose Level & Year filters first">
                                <i class="fas fa-clipboard-check me-1"></i> Assign filtered to exam
                            </button>
                            @endif

                            {{-- <a href="{{ route('school.exams.assign', ['level' => $student->level_id, 'year' => $student->academic_year]) }}" class="btn btn-outline-success ms-2">
                            <i class="fas fa-clipboard-check"></i> Assign to Exam
                            </a> --}}

                            <a href="{{ route('school.students.edit', $student->student_id) }}" class="btn btn-outline-primary ms-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <form action="{{ route('school.students.destroy', $student->student_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        No students found. <a href="{{ route('school.students.create') }}" class="text-blue-600">Add the first student</a>.
                    </td>
                </tr>

                @endforelse
            </tbody>
        </table>

        @if($students->hasPages())
        <div class="mt-4">
            {{ $students->appends(request()->except('page'))->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
