@extends('layouts.apps')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('breadcrumb', 'Overview')

@section('content')
@if(!$school)
<div class="bg-white rounded-lg shadow p-6">
    <div class="text-center py-8">
        <i class="fas fa-school text-gray-400 text-6xl mb-4"></i>
        <h2 class="text-2xl font-semibold text-gray-700 mb-2">No School Assigned</h2>
        <p class="text-gray-600 mb-4">Your account is not associated with any school.</p>
        <p class="text-gray-500">Please contact the system administrator to assign you to a school.</p>
    </div>
</div>
@else
<!-- Your existing dashboard content here -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="p-3 rounded-full">
                    <i class="fas fa-graduation-cap text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">School</h3>
                    <p class="text-lg font-bold text-gray-900">{{ $school->school_name }}</p>
                    <p class="text-sm text-gray-500">{{ $school->center_code }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="p-3 rounded-full">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Total Students</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_students'] }}</p>
                </div>

                <a href="{{ route('school.students.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    View all students <i class="bi bi-link-45deg"></i>
                </a>

            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-danger">
                <div class="p-3 rounded-full">
                    <i class="fas fa-book text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Total Subjects</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_subjects'] }}</p>
                </div>
                <a href="{{ route('school.students.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    View all Subjects <i class="bi bi-link-45deg"></i>
                </a>
            </div>
        </div>
    </div>




    <!-- Recent Exams Section -->
    <div class="mt-8 bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Recent Exams</h3>
        </div>
        <div class="p-6">
            @if($stats['recent_exams']->count() > 0)
            {{-- <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Exam Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Marks</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($stats['recent_exams'] as $exam)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $exam->exam_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $exam->exam_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $exam->total_marks }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> --}}
            @else
            <div class="text-center py-8">
                <i class="fas fa-clipboard-list text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-600">No exams created yet.</p>
                <a href="{{ route('school.exams.create') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                    Create your first exam →
                </a>
            </div>
            @endif
        </div>
    </div>

</div>

@endif
@endsection
