<!-- Top Bar Start -->
<div class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="tb-contact">
                    @if ($settings->email)
                        <p><i class="fas fa-envelope"></i> {{ $settings->email }}</p>
                    @endif
                    @if ($settings->phone)
                        <p><i class="fas fa-phone-alt"></i> {{ $settings->phone }}</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="tb-menu text-right">
                    <a href="#">About</a>
                    @guest
                        <a href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Register</a>
                        <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
                    @endguest

                    @auth
                        <a href="javascript:void(0)" onclick="confirmLogout()">Logout</a>
                        <form id="formLogout" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Top Bar End -->

<!-- Brand Start -->
<div class="brand">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4">
                <div class="b-logo">
                    <a href="#">
                        <img src="{{ asset($settings->logo) }}" alt="Logo" class="img-fluid" />
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-4">
                <div class="b-ads text-center">
                    <!-- Placeholder for ads or any additional content -->
                </div>
            </div>
            <div class="col-lg-3 col-md-4">
                <form action="{{ route('front.search') }}" method="POST">
                    @csrf
                    <div class="b-search d-flex">
                        <input type="text" name="search" placeholder="Search" class="form-control" />
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    </div>
                    @error('search')
                        <small class="text-danger">{{ $message }}</small>
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
                    <a href="{{ route('front.index') }}"
                        class="nav-item nav-link {{ request()->routeIs('front.index') ? 'active' : '' }}">Home</a>

                    <div class="nav-item dropdown">
                        <a href="#"
                            class="nav-link dropdown-toggle {{ request()->is('category/*') ? 'active' : '' }}"
                            data-toggle="dropdown">Categories</a>
                        <div class="dropdown-menu">
                            @foreach ($categories as $category)
                                <a href="{{ route('front.category.posts', $category->slug) }}"
                                    class="dropdown-item {{ request()->is('category/' . $category->slug) ? 'active' : '' }}">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ route('front.contact.create') }}"
                        class="nav-item nav-link {{ request()->routeIs('front.contact.create') ? 'active' : '' }}">Contact
                        Us</a>

                    @auth
                        <a href="{{ route('front.dashboard.profile') }}"
                            class="nav-item nav-link {{ request()->routeIs('front.dashboard.profile') ? 'active' : '' }}">Dashboard</a>
                    @endauth
                </div>

                <div class="social ml-auto">
                    @auth
                        <a href="#" class="nav-link dropdown-toggle" id="notificationDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span id="notification-count"
                                class="badge badge-danger">{{ Auth::user()->unreadNotifications->count() }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown"
                            style="width: 300px;">
                            <h6 class="dropdown-header">Notifications</h6>
                            @forelse (auth()->user()->unreadNotifications()->take(5)->get() as $notification)
                                <div id="push-notification">
                                    <div class="dropdown-item d-flex justify-content-between align-items-center">
                                        <span>Post:
                                            <span>{{ \Illuminate\Support\Str::limit($notification->data['post_title'], 20) }}</span>
                                            <a href="{{ $notification->data['link'] }}?notify={{ $notification->id }}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                    </div>
                                </div>
                            @empty
                                <div class="dropdown-item text-center text-danger">No notifications</div>
                            @endforelse

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

                    <!-- Social Media Icons -->
                    <a href="{{ $settings->twitter }}" rel="nofollow" target="_blank" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="{{ $settings->facebook }}" rel="nofollow" target="_blank" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="{{ $settings->instagram }}" rel="nofollow" target="_blank" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="{{ $settings->youtube }}" rel="nofollow" target="_blank" title="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Nav Bar End -->

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Are you sure you want to logout?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout!',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formLogout').submit();
            }
        });
    }
</script>
