@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Register New School</h3>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.schools.store') }}">
                        @csrf

                        <!-- School Name -->
                        <div class="form-group row mb-3">
                            <label for="school_name" class="col-md-4 col-form-label text-md-end">
                                School Name *
                            </label>
                            <div class="col-md-6">
                                <input id="school_name" type="text" 
                                    class="form-control @error('school_name') is-invalid @enderror" 
                                    name="school_name" value="{{ old('school_name') }}" 
                                    required autofocus>

                                @error('school_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="form-group row mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-end">
                                Address *
                            </label>
                            <div class="col-md-6">
                                <textarea id="address" class="form-control @error('address') is-invalid @enderror" 
                                    name="address" required>{{ old('address') }}</textarea>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact Phone -->
                        <div class="form-group row mb-3">
                            <label for="contact_phone" class="col-md-4 col-form-label text-md-end">
                                Contact Phone *
                            </label>
                            <div class="col-md-6">
                                <input id="contact_phone" type="text" 
                                    class="form-control @error('contact_phone') is-invalid @enderror" 
                                    name="contact_phone" value="{{ old('contact_phone') }}" required>

                                @error('contact_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">
                                Email
                            </label>
                            <div class="col-md-6">
                                <input id="email" type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    name="email" value="{{ old('email') }}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Register School
                                </button>
                                <a href="{{ route('admin.schools.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection