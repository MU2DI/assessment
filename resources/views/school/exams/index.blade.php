@extends('layouts.apps')

@section('title', 'Manage Exams')
@section('page_title', 'Manage Exams')
@section('breadcrumb', 'Exams')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h3>Exams</h3>
        <a href="{{ route('school.exams.create') }}" class="btn btn-primary">+ New Exam</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Exam Name</th>
                <th>Academic Year</th>
                <th>Term</th>
                <th>Level</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($exams as $exam)
                <tr>
                    <td>{{ $exam->exam_id }}</td>
                    <td>{{ $exam->exam_name }}</td>
                    <td>{{ $exam->academic_year }}</td>
                    <td>{{ $exam->term ?? '-' }}</td>
                    <td>{{ $exam->level->level_name }}</td>
                    <td>
                        <a href="{{ route('school.exams.edit', $exam) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('school.exams.destroy', $exam) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">No exams found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
