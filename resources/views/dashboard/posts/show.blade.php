@extends('layouts.dashboard.app')

@section('title', 'Show Post')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/style.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-center">
        <div class="card-body shadow mb-4" style="max-width: 100ch">
            <a class="btn btn-primary" href="{{ route('dashboard.posts.index', ['page' => request()->page]) }}">
                Back To Posts
            </a>
            <br><br>

            <!-- Post Images Carousel -->
            <div id="newsCarousel" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach ($post->images as $index => $image)
                        <li data-target="#newsCarousel" data-slide-to="{{ $index }}"
                            class="{{ $index == 0 ? 'active' : '' }}"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner" style="height: 70ch">
                    @foreach ($post->images as $index => $image)
                        <div class="carousel-item @if ($index == 0) active @endif">
                            <img src="{{ asset($image->path) }}" class="d-block w-100" alt="Slide {{ $index + 1 }}">
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#newsCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#newsCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <br>

            <!-- Post Details -->
            <div class="row">
                <div class="col-4">
                    <div>
                        <span style="font-weight: bold; font-size: 1.1rem; color: #333;">Publisher:</span>
                        <span style="font-weight: 500; font-size: 1.1rem; color: #007bff;">
                            {{ $post->user->name ?? $post->admin->name }}
                        </span>
                    </div>
                </div>
                <div class="col-4">
                    <h6>Views: {{ $post->number_of_views }} <i class="fa fa-eye"></i></h6>
                </div>
                <div class="col-4">
                    <h6>Created At: {{ $post->created_at->format('Y-m-d h:m') }} <i class="fa fa-edit"></i></h6>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <h6>Comments: {{ $post->comment_able == 1 ? 'Active' : 'Not Active' }} <i class="fa fa-comment"></i>
                    </h6>
                </div>
                <div class="col-4">
                    <h6>Status:
                        <i class="fa @if ($post->status == 0) fa-plane status-inactive @else fa-wifi status-active @endif"
                            title="{{ $post->status == 0 ? 'Inactive' : 'Active' }}"></i>
                    </h6>
                </div>
                <div class="col-4">
                    <h6>Small Description: {{ $post->small_desc }} <i class="fa fa-share-square"></i></h6>
                </div>
            </div>
            <br>
            <hr>
            <br>

            <!-- Post Content -->
            <div class="sn-content">
                <h3>{{ $post->title }}</h3>
                <div class="description">{!! $post->desc !!}</div>
            </div>
            <br><br>

            <!-- Comments Section -->
            <div class="comments-section">
                <h5 id="comment-count">Comments ({{ $post->comments->count() }})</h5>
                <div id="comments-container">
                    @php
                        $comments = $post->comments()->take(8)->get();
                    @endphp
                    <div id="comments">
                        @forelse ($comments as $comment)
                            <div id="comment-{{ $comment->id }}" class="comment-item">
                                <img src="{{ asset($comment->user->image) }}" alt="{{ $comment->user->name }}">
                                <div class="comment-content">
                                    <h6>
                                        <a
                                            href="{{ route('dashboard.users.show', $comment->user->id) }}">{{ $comment->user->name }}</a>
                                        <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                                    </h6>
                                    <p>{{ $comment->comment }}</p>
                                </div>
                                <div class="comment-actions">
                                    <button class="btn btn-link text-danger delete-comment" data-id="{{ $comment->id }}">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="no-comments">No comments yet. Be the first to comment!</div>
                        @endforelse
                    </div>
                </div>

                <!-- Show More Button -->
                @if ($post->comments->count() > 8)
                    <button id="showMoreComments" class="show-more-btn">
                        <span>Show More</span>
                        <i class="bi bi-arrow-down"></i>
                    </button>
                @endif

            </div>

        </div>
    </div>
@endsection

@push('js')
    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Delete Comment
        $(document).on('click', '.delete-comment', function() {
            const commentId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/dashboard/posts/comment/delete/${commentId}`, // Endpoint with dynamic comment ID
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === true) {
                                // Remove the deleted comment from the DOM
                                $(`#comment-${commentId}`).remove();

                                // Update the comment count
                                let currentCount = parseInt($('#comment-count').text().match(
                                    /\d+/)) || 0;
                                let updatedCount = Math.max(currentCount - 1, 0);
                                $('#comment-count').text(`Comments (${updatedCount})`);

                                // Show "No comments" message if count is zero
                                if (updatedCount === 0) {
                                    $('#comments-container').html(
                                        '<div class="no-comments">No comments yet. Be the first to comment!</div>'
                                    );
                                }

                                // Show a success notification
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message ??
                                        'Comment deleted successfully.',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                        },
                        error: function() {
                            // Handle server or network errors
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'An unexpected error occurred. Please try again later.',
                            });
                        }
                    });
                }
            });
        });

        // Get All Comments
        $(document).on('click', '#showMoreComments', function(event) {
            event.preventDefault();

            $.ajax({
                url: "/dashboard/posts/comments/" + {{ $post->id }}, // Correct URL
                type: 'GET',
                success: function(data) {
                    if (data.status === true) {
                        $('#comments').empty(); // Clear existing comments

                        $.each(data.comments, function(key, comment) {
                            $('#comments').append(`
                        <div id="comment-${comment.id}" class="comment-item">
                            <img src="{{ asset('') }}${comment.user.image}" alt="${comment.user.name}'s image" />
                            <div class="comment-content">
                                <h6>
                                    <a href="/dashboard/users/show/${comment.user.id}">${comment.user.name}</a>
                                    <span class="comment-time">${moment(comment.created_at).fromNow()}</span>
                                </h6>
                                <p>${comment.comment}</p>
                            </div>
                            <div class="comment-actions">
                                <button class="btn btn-link text-danger delete-comment" data-id="${comment.id}">
                                    Delete
                                </button>
                            </div>
                        </div>`);
                        });

                        // Hide the "Show More" button if all comments are loaded
                        $('#showMoreComments').hide();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Try again later.',
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An unexpected error occurred. Please try again later.',
                    });
                }
            });
        });
    </script>
@endpush
