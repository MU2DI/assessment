@extends('layouts.apps')

@section('title', 'Edit Exam')
@section('page_title', 'Edit Exam')
@section('breadcrumb', 'Exams')

@section('content')
<div class="container">
    <h3>Edit Exam</h3>
    <form action="{{ route('school.exams.update', $exam) }}" method="POST">
        @csrf @method('PUT')

        <div class="form-group mb-3">
            <label for="exam_name">Exam Name *</label>
            <input type="text" name="exam_name" id="exam_name" class="form-control" value="{{ old('exam_name', $exam->exam_name) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="academic_year">Academic Year *</label>
            <input type="text" name="academic_year" id="academic_year" class="form-control" value="{{ old('academic_year', $exam->academic_year) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="term">Term</label>
            <input type="text" name="term" id="term" class="form-control" value="{{ old('term', $exam->term) }}">
        </div>

        <div class="form-group mb-3">
            <label for="level_id">Level *</label>
            <select name="level_id" id="level_id" class="form-control" required>
                @foreach($levels as $level)
                    <option value="{{ $level->level_id }}" {{ $exam->level_id == $level->level_id ? 'selected' : '' }}>
                        {{ $level->level_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('school.exams.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
