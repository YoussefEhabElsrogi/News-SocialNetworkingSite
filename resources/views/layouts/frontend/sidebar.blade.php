<div class="list-group profile-sidebar-menu">
    <!-- Profile Link -->
    <a href="{{ route('front.dashboard.profile') }}"
        class="list-group-item list-group-item-action menu-item {{ request()->routeIs('front.dashboard.profile') ? 'active' : '' }}"
        data-section="profile">
        <i class="fas fa-user"></i> Profile
    </a>

    <!-- Notifications Link -->
    <a href="{{ route('front.dashboard.notifications.index') }}"
        class="list-group-item list-group-item-action menu-item {{ request()->routeIs('front.dashboard.notifications.index') ? 'active' : '' }}"
        data-section="notifications">
        <i class="fas fa-bell"></i> Notifications
    </a>

    <!-- Settings Link -->
    <a href="{{ route('front.dashboard.setting.index') }}"
        class="list-group-item list-group-item-action menu-item {{ request()->routeIs('front.dashboard.setting.index') ? 'active' : '' }}"
        data-section="settings">
        <i class="fas fa-cog"></i> Settings
    </a>

    <!-- Whatsapp Link -->
    <a href="{{ $settings->whatsapp }}" target="_blank" class="list-group-item list-group-item-action menu-item"
        data-section="support">
        <i class="fa fa-question-circle" aria-hidden="true"></i> Support
    </a>

    <!-- Logout Link -->
    <a href="javascript:void(0)" onclick="confirmLogout()" class="list-group-item list-group-item-action menu-item"
        data-section="logout">
        <i class="fa fa-power-off" aria-hidden="true"></i> Logout
    </a>

    <!-- Logout Form (Hidden) -->
    <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>

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
                document.getElementById('logoutForm').submit(); // Submit the logout form
            }
        });
    }
</script>
