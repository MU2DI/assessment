{{-- resources/views/school/subjects/form.blade.php --}}
<div class="form-group">
    <label for="subject_name">Subject Name *</label>
    <input type="text" name="subject_name" id="subject_name" class="form-control @error('subject_name') is-invalid @enderror" value="{{ old('subject_name', $subject->subject_name ?? '') }}" required>
    @error('subject_name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="short_name">Short Name</label>
    <input type="text" name="short_name" id="short_name" class="form-control @error('short_name') is-invalid @enderror" value="{{ old('short_name', $subject->short_name ?? '') }}">
    @error('short_name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="subject_code">Subject Code *</label>
    <input type="text" name="subject_code" id="subject_code" class="form-control @error('subject_code') is-invalid @enderror" value="{{ old('subject_code', $subject->subject_code ?? '') }}" required>
    @error('subject_code')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- CHANGED: Now a multiple select for levels --}}
<div class="form-group">
    <label for="level_ids">Levels *</label>
    <select name="level_ids[]" id="level_ids" class="form-control select2 @error('level_ids') is-invalid @enderror" multiple="multiple" required style="width: 100%;">
        @foreach($levels as $level)
            <option value="{{ $level->level_id }}"
                {{-- Check if this level is already associated (for edit) or was old input (for validation fail) --}}
                @if( (isset($currentLevelIds) && in_array($level->level_id, $currentLevelIds)) || in_array($level->level_id, old('level_ids', [])) )
                    selected
                @endif
            >
                {{ $level->level_name }}
            </option>
        @endforeach
    </select>
    @error('level_ids')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>