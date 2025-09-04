@extends('layouts.apps')
@section('title', 'Edit Subject')
@section('page_title', 'Edit Subject')
@section('breadcrumb', 'Edit Subject')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Subject Details</h3>
                </div>
                <form method="POST" action="{{ route('school.subjects.update', $subject) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @include('school.subjects.form') {{-- Include the form partial --}}
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Subject</button>
                        <a href="{{ route('school.subjects.index') }}" class="btn btn-default float-right">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection