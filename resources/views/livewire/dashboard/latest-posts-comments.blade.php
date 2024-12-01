<div class="row mt-3">
    <!-- Content Column: Last Posts -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Last Posts</h6>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Comments</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($latest_posts as $post)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @can('posts')
                                        <a href="{{ route('dashboard.posts.show', $post->id) }}" title="{{ $post->title }}">
                                            {{ Illuminate\Support\Str::limit($post->title, 20) }}
                                        </a>
                                    @else
                                        {{ Illuminate\Support\Str::limit($post->title, 20) }}
                                    @endcan
                                </td>
                                <td>{{ optional($post->category)->name }}</td>
                                <td>{{ $post->comments_count }}</td>
                                <td>{{ $post->status == 0 ? 'Not Active' : 'Active' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No posts available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Content Column: Last Comments -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Last Comments</h6>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Post</th>
                            <th>Comment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($latest_comments as $comment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $comment->user->name }}</td>
                                <td>
                                    @can('posts')
                                        <a href="{{ route('dashboard.posts.show', $comment->post->id) }}"
                                            title="{{ $comment->post->title }}">
                                            {{ Illuminate\Support\Str::limit($comment->post->title, 15) }}
                                        </a>
                                    @else
                                        {{ Illuminate\Support\Str::limit($comment->post->title, 15) }}
                                    @endcan
                                </td>
                                <td>{{ Illuminate\Support\Str::limit($comment->comment, 15) }}</td>
                                <td>{{ $comment->status == 0 ? 'Not Active' : 'Active' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No comments available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
