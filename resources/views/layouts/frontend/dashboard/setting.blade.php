@extends('layouts.frontend.app')

@section('title')
    Setting
@endsection

@section('content')
    <!-- Dashboard Start-->
    <div class="dashboard container">
        <!-- Sidebar -->
        <aside class="col-md-3 nav-sticky dashboard-sidebar">
            <!-- User Info Section -->
            <div class="user-info text-center p-3">
                <img src="{{ asset($user->image) }}" alt="User Image" class="rounded-circle mb-2"
                    style="width: 80px; height: 80px; object-fit: cover" />
                <h5 class="mb-0" style="color: #ff6f61">{{ $user->name }}</h5>
            </div>

            <!-- Sidebar Menu -->
            @include('layouts.frontend.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Settings Section -->
            <section id="settings" class="content-section active">
                <h2>Settings</h2>
                <form action="{{ route('front.dashboard.setting.update') }}" method="POST" class="settings-form"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                            class="form-control" />
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}"
                            class="form-control" />
                        @error('username')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                            class="form-control" />
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="profile-image">Profile Image:</label>
                        <input type="file" id="profile-image" name="image" accept="image/*" class="form-control" />
                        @error('profile_image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <img id="profile_image" class="img-thumbnail" src="{{ asset($user->image) }}" width="180px">
                    </div>

                    <div class="form-group">
                        <label for="country">Country:</label>
                        <input type="text" id="country" name="country" placeholder="Enter your country"
                            value="{{ old('country', $user->country) }}" class="form-control" />
                        @error('country')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="city">City:</label>
                        <input type="text" id="city" name="city" placeholder="Enter your city"
                            value="{{ old('city', $user->city) }}" class="form-control" />
                        @error('city')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" id="phone" name="phone" placeholder="Enter your phone"
                            value="{{ old('phone', $user->phone) }}" class="form-control" />
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="street">Street:</label>
                        <input type="text" id="street" name="street" placeholder="Enter your street"
                            value="{{ old('street', $user->street) }}" class="form-control" />
                        @error('street')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary save-settings-btn">
                        Save Changes
                    </button>
                </form>


                <!-- Form to change the password -->
                <form action="{{ route('front.dashboard.setting.change-password') }}" method="POST"
                    class="change-password-form">
                    @csrf
                    <h2>Change Password</h2>

                    <!-- Current Password -->
                    <div class="form-group">
                        <label for="current-password">Current Password:</label>
                        <input type="password" id="current-password" placeholder="Enter Current Password"
                            class="form-control" name="current_password">
                        @error('current_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="form-group">
                        <label for="new-password">New Password:</label>
                        <input type="password" id="new-password" name="password" placeholder="Enter New Password"
                            class="form-control " />
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm New Password -->
                    <div class="form-group">
                        <label for="confirm-password">Confirm New Password:</label>
                        <input type="password" id="confirm-password" name="password_confirmation"
                            placeholder="Confirm New Password" class="form-control" />
                        @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-secondary change-password-btn">
                        Change Password
                    </button>
                </form>

            </section>
        </div>
    </div>
    <!-- Dashboard End-->
@endsection

@push('js')
    <script>
        $(document).on('change', '#profile-image', function(e) {
            e.preventDefault();
            var file = this.files[0];

            if (file) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#profile_image').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
