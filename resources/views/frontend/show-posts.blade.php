@extends('layouts.frontend.app')

@section('title')
    Show {{ $singlePost->title }}
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">{{ $singlePost->title }}</li>
@endsection

@section('content')
    <!-- Single News Start-->
    <div class="single-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Carousel -->
                    <div id="newsCarousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#newsCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#newsCarousel" data-slide-to="1"></li>
                            <li data-target="#newsCarousel" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            @foreach ($singlePost->images as $index => $image)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ asset($image->path) }}" class="d-block w-100"
                                        alt="Slide {{ $index + 1 }}" style="height: 500px; object-fit: cover;" />
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5 style="color: red">{{ $singlePost->title }}</h5>
                                    </div>
                                </div>
                            @endforeach
                            <!-- Add more carousel-item blocks for additional slides -->
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
                    <div class="alert alert-info d-flex align-items-center p-3 mt-3" style="background-color: #e9f7ff; border-left: 5px solid #007bff;">
                        <i class="bi bi-person-circle" style="font-size: 2rem; color: #007bff; margin-right: 15px;"></i>
                        <div>
                            <span style="font-weight: bold; font-size: 1.1rem; color: #333;">Publisher:</span>
                            <span style="font-weight: 500; font-size: 1.1rem; color: #007bff;">
                                {{ $singlePost->user->name ?? $singlePost->admin->name }}
                            </span>
                        </div>
                    </div>

                    <div class="sn-content text-break">{!! $singlePost->desc !!}</div>

                    <div style="display: none;font-size:20px" id="errorMessage" class="alert alert-danger">
                        {{-- Display Error --}}
                    </div>

                    <!-- Comment Section -->
                    @if ($singlePost->comment_able == true)
                        <div class="comment-section">
                            <!-- Comment Input -->
                            @auth
                                <form method="POST" action="" id="commentForm">
                                    <div class="comment-input">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        <input type="hidden" name="post_id" value="{{ $singlePost->id }}">
                                        <input id="commentInput" type="text" name="comment" placeholder="Add a comment..." />
                                        <button type="submit">Comment</button>
                                    </div>
                                </form>
                            @endauth


                            <!-- Display Comments -->
                            <div class="comments">
                                @foreach ($singlePost->comments as $comment)
                                    <div class="comment" style="display: flex;justify-content: center;align-items: center">
                                        <div class="image">
                                            <img src="{{ asset($comment->user->image) }}" alt="No image"
                                                class="comment-img" />
                                        </div>
                                        <div class="comment-content">
                                            <span class="username">{{ $comment->user->name }}</span>
                                            <p class="comment-text">{{ $comment->comment }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Show More Button -->
                            @if ($singlePost->comments->count() > 2)
                                <button id="showMoreBtn" class="show-more-btn">Show more</button>
                            @endif
                        </div>
                    @else
                        <div
                            class="alert alert-info text-center d-flex justify-content-center align-items-center mt-4 p-3 rounded-5 shadow-sm">
                            <h3 class="fw-bold" style="color: red;">
                                Comments are disabled for this post 😔
                            </h3>
                        </div>
                    @endif


                    <!-- Related News -->
                    <div class="sn-related">
                        <h2>Related News</h2>
                        <div class="row sn-slider">
                            @foreach ($postsRelated as $post)
                                <div class="col-md-4">
                                    <div class="sn-img">
                                        <img src="{{ asset($post->images->first()->path) }}" class="img-fluid"
                                            alt="{{ $post->title }}" />
                                        <div class="sn-title">
                                            <a title="{{ $post->title }}"
                                                href="{{ route('front.post.show', $post->slug) }}">{{ $post->title }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sidebar">
                        <div class="sidebar-widget">
                            <h2 class="sw-title">In This Category</h2>
                            <div class="news-list">
                                @foreach ($postsRelated as $post)
                                    <div class="nl-item">
                                        <div class="nl-img">
                                            <img src="{{ asset($post->images->first()->path) }}" />
                                        </div>
                                        <div class="nl-title">
                                            <a href="{{ route('front.post.show', $post->slug) }}">{{ $post->title }}</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="sidebar-widget">
                            <div class="tab-news">
                                <ul class="nav nav-pills nav-justified">
                                    {{-- Latest Posts --}}
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#latest">Latest</a>
                                    </li>
                                    {{-- Popular Posts --}}
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#popular">Popular</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    {{-- Latest Posts --}}
                                    <div id="latest" class="container tab-pane fade show active">
                                        @foreach ($latestPosts as $post)
                                            <div class="tn-news">
                                                <div class="tn-img">
                                                    <img src="{{ asset($post->images->first()->path) }}"
                                                        alt="{{ $post->title }}" />
                                                </div>
                                                <div class="tn-title">
                                                    <a href="{{ route('front.post.show', $post->slug) }}"
                                                        title="{{ $post->title }}">{{ $post->title }}</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Popular Posts --}}
                                    <div id="popular" class="container tab-pane fade">
                                        @foreach ($popularPosts as $post)
                                            <div class="tn-news">
                                                <div class="tn-img">
                                                    <img src="{{ asset($post->images->first()->path) }}"
                                                        alt="{{ $post->title }}" />
                                                </div>
                                                <div class="tn-title">
                                                    <a href="{{ route('front.post.show', $post->slug) }}">{{ $post->title }}
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-widget">
                            <h2 class="sw-title">News Category</h2>
                            <div class="category">
                                <ul>
                                    @foreach ($categories as $category)
                                        <li><a
                                                href="{{ route('front.category.posts', $category->slug) }}">{{ $category->name }}</a><span>({{ $category->posts->count() }})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="sidebar-widget">
                            <h2 class="sw-title">Tags Cloud</h2>
                            <div class="tags">
                                <a href="">National</a>
                                <a href="">International</a>
                                <a href="">Economics</a>
                                <a href="">Politics</a>
                                <a href="">Lifestyle</a>
                                <a href="">Technology</a>
                                <a href="">Trades</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single News End-->
@endsection

@push('js')
    <script>
        // Show More Comments
        $(document).on('click', '#showMoreBtn', function(event) {
            event.preventDefault();

            $.ajax({
                url: "{{ route('front.post.comments', $singlePost->slug) }}",
                type: 'GET',
                success: function(data) {
                    if (data.length > 0) {
                        $('.comments').empty(); // Clear existing comments
                        $.each(data, function(key, comment) {
                            $('.comments').append(
                                `<div class="comment">
                                <img src="{{ asset('') }}${comment.user.image}" alt="${comment.user.name}'s image" class="comment-img" />
                                <div class="comment-content">
                                    <span class="username">${comment.user.name}</span>
                                    <p class="comment-text">${comment.comment}</p>
                                </div>
                            </div>`
                            );
                        });

                        // Hide the "Show More" button if all comments are loaded
                        $('#showMoreBtn').hide();
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText); // Handle error
                }
            });
        });

        // Store Comment
        $(document).on('submit', '#commentForm', function(event) {
            event.preventDefault();

            var formData = new FormData($(this)[0]);
            $('#commentInput').val('');

            $.ajax({
                url: "{{ route('front.post.comment.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#errorMessage').hide();

                    if (response.comment) {
                        $('.comments').prepend(`
                        <div class="comment">
                            <img src="{{ asset('') }}${response.comment.user.image}" alt="${response.comment.user.name || 'User'}'s image" class="comment-img" />
                            <div class="comment-content">
                                <span class="username">${response.comment.user.name || 'User Name'}</span>
                                <p class="comment-text">${response.comment.comment}</p>
                            </div>
                        </div>
                    `);
                    }
                },
                error: function(data) {
                    var response = $.parseJSON(data.responseText);
                    $('#errorMessage').text(response.errors.comment).show();
                }
            });
        });
    </script>
@endpush
