@extends('layouts.dashboard.app')

@section('title', 'Show User: ' . $user->name)

@push('css')
    <style>
        .profile-image {
            transition: transform 0.3s ease, border 0.3s ease;
        }

        .profile-image:hover {
            transform: scale(1.2);
            border: 3px solid #007bff;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="text-center mb-0">User Details: {{ $user->name }}</h3>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    @if ($user->image)
                        <a href="{{ asset($user->image) }}" target="_blank">
                            <img src="{{ asset($user->image) }}" alt="Image of {{ $user->name }}"
                                class="img-thumbnail rounded-circle profile-image"
                                style="width: 230px; height: 230px; object-fit: cover;">
                        </a>
                    @else
                        <span class="text-muted">No image available for this user</span>
                    @endif
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Name</strong></label>
                            <input type="text" value="{{ $user->name }}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Username</strong></label>
                            <input type="text" value="{{ $user->username }}" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Email</strong></label>
                            <input type="email" value="{{ $user->email }}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Phone</strong></label>
                            <input type="text" value="{{ $user->phone }}" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Status</strong></label>
                            <input type="text" value="{{ $user->status == 1 ? 'Active' : 'Not Active' }}"
                                class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Email Status</strong></label>
                            <input type="text" value="{{ $user->email_verified_at ? 'Active' : 'Not Active' }}"
                                class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Country</strong></label>
                            <input type="text" value="{{ $user->country }}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>City</strong></label>
                            <input type="text" value="{{ $user->city }}" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><strong>Street</strong></label>
                            <input type="text" value="{{ $user->street }}" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('dashboard.users.changeStatus', $user->id) }}"
                        class="btn btn-{{ $user->status == 1 ? 'warning' : 'success' }} mx-2">
                        {{ $user->status == 1 ? 'Block' : 'Activate' }}
                    </a>
                    <a href="javascript:void(0)"
                        onclick="if(confirm('Do you want to delete this user?')) { document.getElementById('delete_user').submit(); }"
                        class="btn btn-danger mx-2">
                        Delete
                    </a>
                </div>
            </div>
        </div>

        <form id="delete_user" action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection
