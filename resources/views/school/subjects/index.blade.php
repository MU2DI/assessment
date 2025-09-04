@extends('layouts.apps')
@section('title', 'Manage Subjects')
@section('page_title', 'Manage Subjects')
@section('breadcrumb', 'Subjects')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List of Subjects</h3>
                    <div class="card-tools">
                        <a href="{{ route('school.subjects.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Add New Subject
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Short Name</th>
                                <th class="text-center">Levels</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=0;
                            @endphp
                            @forelse($subjects as $subject)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $subject->subject_code }}</td>
                                <td>{{ $subject->subject_name }}</td>
                                <td>{{ $subject->short_name ?? '-' }}</td>
                                <td class="px-6 py-4 text-center text-gray-800">
                                    @if($subject->levels->count())
                                    @foreach($subject->levels as $level)
                                    {{ $level->level_name }}@if(!$loop->last), @endif
                                    @endforeach
                                    @else
                                    N/A
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('school.subjects.edit', $subject) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form action="{{ route('school.subjects.destroy', $subject) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this subject?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No subjects found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
