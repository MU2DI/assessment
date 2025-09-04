@extends('layouts.apps')

@section('title', 'Create Exam')
@section('page_title', 'Create Exam')
@section('breadcrumb', 'Exams')

@section('content')
<div class="container">
    <h3>Create Exam</h3>
    <form action="{{ route('school.exams.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="exam_name">Exam Name *</label>
            <input type="text" name="exam_name" id="exam_name" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="academic_year">Academic Year *</label>
            <input type="text" name="academic_year" id="academic_year" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="term">Term</label>
            <input type="text" name="term" id="term" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="level_id">Level *</label>
            <select name="level_id" id="level_id" class="form-control" required>
                <option value="">Select Level</option>
                @foreach($levels as $level)
                    <option value="{{ $level->level_id }}">{{ $level->level_name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Create</button>
        <a href="{{ route('school.exams.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
