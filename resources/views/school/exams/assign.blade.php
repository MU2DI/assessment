@extends('layouts.apps')
@section('title', 'Assign Students to Exam')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Assign Students to Exam</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('school.exams.assignStore') }}">
                @csrf

                <!-- Exam Select -->
                <div class="form-group mb-3">
                    <label for="exam_id">Select Exam</label>
                    <select name="exam_id" id="exam_id" class="form-control" required>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->exam_id }}">
                                {{ $exam->exam_name }} ({{ $exam->academic_year }} - {{ $exam->term }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Students Select -->
                <div class="form-group mb-3">
                    <label>Select Students</label>

                    <!-- Select All Toggle -->
                    <div class="form-check mb-2">
                        <input type="checkbox" id="select_all" class="form-check-input">
                        <label class="form-check-label fw-bold" for="select_all">Select All</label>
                    </div>

                    <div class="border rounded p-2" style="max-height: 300px; overflow-y: auto;">
                        @foreach($students as $student)
                            <div class="form-check">
                                <input type="checkbox" name="student_ids[]" 
                                       value="{{ $student->student_id }}" 
                                       class="form-check-input student-checkbox" 
                                       id="student_{{ $student->student_id }}">
                                <label class="form-check-label" for="student_{{ $student->student_id }}">
                                    {{ $student->first_name }} {{ $student->last_name }}
                                    ({{ $student->level->level_name ?? 'N/A' }} - {{ $student->academic_year }})
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Assign</button>
                <a href="{{ route('school.students.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    // Select All toggle
    document.getElementById('select_all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.student-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>
@endsection
