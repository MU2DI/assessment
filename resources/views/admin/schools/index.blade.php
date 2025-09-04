@extends('layouts.app')
@section('title', 'Dash-Board')
@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Schools List</h1>
        <a href="{{ route('admin.schools.create') }}" class="btn btn-primary" aria-label="Add new school">
            <i class="fas fa-plus me-1"></i> Add New School
        </a>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Code</th>
                            <th scope="col">School Name</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <!-- Wrap the table in Alpine so we can open the modal from buttons -->
                    <div x-data="confirmDelete('')">

                        <table class="table table-striped table-hover mb-0">
                            <tbody>
                                @foreach ($schools as $school)
                                <tr>
                                    <td>{{ $school->center_code }}</td>
                                    <td>{{ $school->school_name }}</td>
                                    <td>
                                        <a href="tel:{{ $school->contact_phone }}">
                                            {{ $school->contact_phone }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill {{ $school->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $school->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.schools.edit', $school->center_code) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Pass center_code to modal -->
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-school-code="{{ $school->center_code }}" data-school-name="{{ $school->school_name }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete <strong><span id="schoolName"></span></strong>?</p>
                                        <p class="text-danger">This action cannot be undone.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form id="deleteForm" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete School</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @endsection
                    @push('scripts')
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const deleteModal = document.getElementById('deleteModal');

                            deleteModal.addEventListener('show.bs.modal', function(event) {
                                const button = event.relatedTarget;
                                const schoolCode = button.getAttribute('data-school-code');
                                const schoolName = button.getAttribute('data-school-name');

                                document.getElementById('schoolName').textContent = schoolName;
                                document.getElementById('deleteForm').action = `/admin/schools/${schoolCode}`;
                            });
                            form.action = "{{ url('/admin/schools') }}/" + code;

                        });

                    </script>
                    @endpush
