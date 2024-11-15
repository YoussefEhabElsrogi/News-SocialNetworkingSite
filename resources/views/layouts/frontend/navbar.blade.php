<!-- Top Bar Start -->
<div class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="tb-contact">
                    <p><i class="fas fa-envelope"></i>{{ $settings->email }}</p>
                    <p><i class="fas fa-phone-alt"></i>{{ $settings->phone }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tb-menu">
                    <a href="">About</a>
                    @guest
                        <a href="{{ route('register') }}">Register</a>
                        <a href="{{ route('login') }}">Login</a>
                    @endguest

                    @auth
                        <a href="javascript:void(0)"
                            onclick="event.preventDefault(); if(confirm('Do You Want To Logout?')) document.getElementById('formLogout').submit();">Logout</a>
                    @endauth

                    <form id="formLogout" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Top Bar Start -->

<!-- Brand Start -->
<div class="brand">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4">
                <div class="b-logo">
                    <a href="index.html">
                        <img src="{{ asset('assets/frontend/img/') }}/{{ $settings->logo }}" alt="Logo" />
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-4">
                <div class="b-ads">
                    {{-- Favicon Website --}}
                </div>
            </div>
            <div class="col-lg-3 col-md-4">
                <form action="{{ route('front.search') }}" method="POST">
                    @csrf
                    <div class="b-search">
                        <input type="text" name="search" placeholder="Search" />
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </div>
                    @error('search')
                        <div style="color: red;margin-top:10px">{{ $message }}</div>
                    @enderror
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Brand End -->

<!-- Nav Bar Start -->
<div class="nav-bar">
    <div class="container">
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <a href="#" class="navbar-brand">MENU</a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav mr-auto">
                    <a href="{{ route('front.index') }}" class="nav-item nav-link active">Home</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                        <div class="dropdown-menu">
                            {{-- Categories --}}
                            @foreach ($categories as $category)
                                <a href="{{ route('front.category.posts', $category->slug) }}"
                                    title="{{ $category->name }}" class="dropdown-item">{{ $category->name }}</a>
                            @endforeach
                        </div>
                    </div>
                    <a href="{{ route('front.contact.create') }}" class="nav-item nav-link">Contact Us</a>
                    @auth
                        <a href="{{ route('front.dashboard.profile') }}" class="nav-item nav-link">Dashboard</a>
                    @endauth
                </div>
                <div class="social ml-auto">

                    @auth
                        <a href="#" class="nav-link dropdown-toggle" id="notificationDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span class="badge badge-danger">
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown"
                            style="width: 300px;">
                            <h6 class="dropdown-header">Notifications</h6>

                            @forelse (auth()->user()->unreadNotifications as $notification)
                                <div class="dropdown-item d-flex justify-content-between align-items-center">
                                    <span>Post Comment : {{ substr($notification->data['post_title'], 0, 9) }}...</span>
                                    <a href="{{ $notification->data['link'] }}?notify={{ $notification->id }}"><i
                                            class="fa fa-eye"></i></a>
                                </div>
                            @empty
                                <div class="dropdown-item text-center text-danger notify">No notifications</div>
                            @endforelse

                            <!-- Mark All as Read Button -->
                            @if (Auth::user()->unreadNotifications->count() > 0)
                                <div class="dropdown-item text-center">
                                    <form action="{{ route('front.dashboard.notifications.readAll') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Mark All as Read</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endauth

                    <!-- Notification Dropdown -->

                    <a href="{{ $settings->twitter }}" target="_blank" title="Follow us on Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="{{ $settings->facebook }}" target="_blank" title="Like us on Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="{{ $settings->instagram }}" target="_blank" title="Follow us on Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="{{ $settings->youtube }}" target="_blank" title="Subscribe to our YouTube channel">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>

            </div>
        </nav>
    </div>
</div>
<!-- Nav Bar End -->
