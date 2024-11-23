@extends('layouts.dashboard.app')

@section('title', 'Create Role')

@push('css')
    <style>
        .form-check-label {
            font-weight: 500;
            color: #495057;
        }

        .form-check-input {
            cursor: pointer;
        }

        .form-control::placeholder {
            font-style: italic;
            color: #adb5bd;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-center mt-5">
        <form action="{{ route('dashboard.authorizations.store') }}" method="POST" class="card shadow-lg p-4"
            style="max-width: 800px; width: 100%; border-radius: 10px;">
            @csrf
            <div class="card-body">
                <!-- Header Section -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-primary mb-0">Add New Role</h2>
                    <a href="{{ route('dashboard.authorizations.index') }}" class="btn btn-outline-primary">Back to Roles</a>
                </div>

                <!-- Role Name Input -->
                <div class="mb-3">
                    <label for="role" class="form-label fw-bold">Role Name</label>
                    <input type="text" id="role" name="role" value="{{ old('role') }}"
                        placeholder="Enter Role Name" class="form-control">
                    @error('role')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Permissions Section -->
                <div class="mb-4">
                    <h5 class="fw-bold text-secondary">Permissions</h5>
                    <div class="row">
                        @foreach (config('authorization.permessions') as $key => $value)
                            <div class="col-md-4 col-sm-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input permession-checkbox" type="checkbox" name="permessions[]"
                                        id="permession-{{ $key }}" value="{{ $key }}"
                                        {{ in_array($key, old('permessions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="permession-{{ $key }}">{{ $value }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @error('permessions')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Choose All Button -->
                <div class="mb-3">
                    <button type="button" class="btn btn-secondary" id="selectAllBtn">Select All Permissions</button>
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Create New Role</button>
                </div>
            </div>
        </form>
    </div>

    @push('js')
        <script>
            // JavaScript to handle 'Select All' functionality
            document.getElementById('selectAllBtn').addEventListener('click', function() {
                // Get all permission checkboxes
                const checkboxes = document.querySelectorAll('.permession-checkbox');
                const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

                // If all are checked, uncheck them, else check them all
                checkboxes.forEach(checkbox => {
                    checkbox.checked = !allChecked;
                });
            });
        </script>
    @endpush
@endsection
