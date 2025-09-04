@extends('layouts.apps')
@section('title', 'Create New Subject')
@section('page_title', 'Create New Subject')
@section('breadcrumb', 'Create Subject')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Subject Details</h3>
                </div>
                <form method="POST" action="{{ route('school.subjects.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="subject_name">Subject Name *</label>
                            <input type="text" name="subject_name" id="subject_name"
                                class="form-control @error('subject_name') is-invalid @enderror"
                                value="{{ old('subject_name') }}" required>
                            @error('subject_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="short_name">Short Name</label>
                            <input type="text" name="short_name" id="short_name"
                                class="form-control @error('short_name') is-invalid @enderror"
                                value="{{ old('short_name') }}">
                            @error('short_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="subject_code">Subject Code *</label>
                            <input type="text" name="subject_code" id="subject_code"
                                class="form-control @error('subject_code') is-invalid @enderror"
                                value="{{ old('subject_code') }}" required>
                            @error('subject_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="level_ids">Levels *</label>
                            <select name="level_ids[]" id="level_ids"
                                class="form-control select2 @error('level_ids') is-invalid @enderror"
                                multiple required style="width: 100%;">
                                @foreach($levels as $level)
                                    <option value="{{ $level->level_id }}"
                                        @if(in_array($level->level_id, old('level_ids', []))) selected @endif>
                                        {{ $level->level_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('level_ids')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create Subject</button>
                        <a href="{{ route('school.subjects.index') }}" class="btn btn-default float-right">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Select2 fix --}}
@push('styles')
<style>
    .select2-container {
        width: 100% !important;
    }
    .select2-dropdown {
        width: 100% !important;
    }
</style>
@endpush

@section('scripts')
@parent
<script>
    $(document).ready(function () {
        $('#level_ids').select2({
            placeholder: "Select one or more levels",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#level_ids').closest('.form-group') // keep inside card
        });
    });
</script>
@endsection
