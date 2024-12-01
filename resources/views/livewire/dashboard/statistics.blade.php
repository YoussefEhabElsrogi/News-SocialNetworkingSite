<div class="row">
    <!-- Categories Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2" style="border-left: 5px solid #4e73df; border-radius: 10px;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Categories</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $active_categories_count }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2" style="border-left: 5px solid #1cc88a; border-radius: 10px;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Users</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $active_users_count }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Posts Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2" style="border-left: 5px solid #36b9cc; border-radius: 10px;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Posts</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $active_posts_count }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-folder fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Comments Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2" style="border-left: 5px solid #f6c23e; border-radius: 10px;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Comments</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $comments_count }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
