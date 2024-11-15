@extends('layouts.frontend.app')

@section('title', 'Notification')

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
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <h2 class="mb-4">Notifications</h2>
                    </div>
                    <div class="col-6">
                        <!-- Delete All Notifications Form -->
                        @if (auth()->user()->notifications()->count() > 1)
                            <form action="{{ route('front.dashboard.notifications.deleteAll') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm float-right">Delete All</button>
                            </form>
                        @endif
                    </div>
                </div>

                @forelse (auth()->user()->notifications as $notification)
                    <a href="{{ $notification->data['link'] }}?notify={{ $notification->id }}" class="text-decoration-none">
                        <div class="notification alert alert-info d-flex justify-content-between align-items-center">
                            <div>
                                <strong>You have a notification from
                                    @if ($notification->data['userMakeCommentName'] === auth()->user()->name)
                                        {{ $notification->data['userMakeCommentName'] }} (You)
                                    @else
                                        {{ $notification->data['userMakeCommentName'] }}
                                    @endif
                                </strong>
                                <br>
                                Post title: {{ $notification->data['post_title'] }}
                                <p class="text-muted mb-0">
                                    <small>Since {{ $notification->created_at->diffForHumans() }}</small>
                                </p>
                            </div>

                            <!-- Individual Delete Form -->
                            <div>
                                <form action="{{ route('front.dashboard.notifications.delete') }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="notification_id" value="{{ $notification->id }}">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="alert alert-info text-center">
                        <span style="display: inline-block" class="notify">You have no notifications at the moment. Stay
                            tuned for updates!</span>
                    </div>
                @endforelse

            </div>
        </div>

    </div>
    <!-- Dashboard End-->

@endsection
