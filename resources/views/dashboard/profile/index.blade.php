@extends('layouts.dashboard.app')

@section('title', 'Profile')

@push('css')
    <style>
        /* Custom styling for the form */
        .card-body {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
        }

        input.form-control {
            border-radius: 8px;
        }

        button.btn-primary {
            border-radius: 30px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        button.btn-primary:hover {
            background-color: #0056b3;
        }

        strong.text-danger {
            font-size: 0.9rem;
        }

        /* Full screen container to center the form */
        .centered-form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            /* Ensure the container takes the full height of the viewport */
            padding: 0 15px;
            /* Add some padding to avoid content sticking to the sides */
        }
    </style>
@endpush

@section('content')
    <div class="centered-form-container">
        <form action="{{ route('dashboard.profile.update') }}" method="POST" class="w-100">
            @method('PATCH')
            @csrf
            <div class="card shadow-lg border-light" style="border-radius: 15px;">
                <div class="card-body">
                    <h2 class="text-center mb-4">Update Profile</h2>

                    <!-- Name Field -->
                    <div class="form-group">
                        <label for="name" class="font-weight-bold">Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" id="name" value="{{ auth('admin')->user()->name }}" name="name"
                                placeholder="Enter your name" class="form-control">
                        </div>
                        @error('name')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>

                    <!-- Username Field -->
                    <div class="form-group">
                        <label for="username" class="font-weight-bold">Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                            </div>
                            <input type="text" id="username" value="{{ auth('admin')->user()->username }}"
                                name="username" placeholder="Enter your username" class="form-control">
                        </div>
                        @error('username')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="email" class="font-weight-bold">Email</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" id="email" value="{{ auth('admin')->user()->email }}" name="email"
                                placeholder="Enter your email" class="form-control">
                        </div>
                        @error('email')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password" class="font-weight-bold">Password (Leave empty if not changing)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" id="password" value="" name="password"
                                placeholder="Enter new password" class="form-control">
                        </div>
                        @error('password')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <button class="btn btn-primary px-4 py-2" type="submit">
                            Update Profile
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
