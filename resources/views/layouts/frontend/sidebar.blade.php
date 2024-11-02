<div class="list-group profile-sidebar-menu">
    <a href="{{ route('front.dashboard.profile') }}"
        class="list-group-item list-group-item-action menu-item {{ request()->routeIs('front.dashboard.profile') ? 'active' : '' }}"
        data-section="profile">
        <i class="fas fa-user"></i> Profile
    </a>
    {{-- <a href="{{ route('front.dashboard.notifications') }}"
        class="list-group-item list-group-item-action menu-item {{ request()->routeIs('front.dashboard.notifications') ? 'active' : '' }}"
        data-section="notifications">
        <i class="fas fa-bell"></i> Notifications
    </a> --}}
    <a href="{{ route('front.dashboard.setting.index') }}"
        class="list-group-item list-group-item-action menu-item {{ request()->routeIs('front.dashboard.setting.index') ? 'active' : '' }}"
        data-section="settings">
        <i class="fas fa-cog"></i> Settings
    </a>
</div>
