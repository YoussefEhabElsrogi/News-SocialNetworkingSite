@extends('layouts.frontend.app')

@section('title')
    Profile
@endsection

@section('content')
    <!-- Profile Start -->
    <div class="dashboard container">
        <!-- Sidebar -->
        <aside class="col-md-3 nav-sticky dashboard-sidebar">
            <!-- User Info Section -->
            <div class="user-info text-center p-3">
                <img src="{{ asset(Auth::user()->image) }}" alt="User Image" class="rounded-circle mb-2"
                    style="width: 80px; height: 80px; object-fit: cover" />
                <h5 class="mb-0" style="color: #ff6f61">{{ Auth::user()->name }}</h5>
            </div>

            <!-- Sidebar Menu -->
            @include('layouts.frontend.sidebar')

        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Profile Section -->
            <section id="profile" class="content-section active">
                <h2>User Profile</h2>
                <div class="user-profile mb-3">
                    <img src="{{ asset(Auth::user()->image) }}" alt="User Image" class="profile-img rounded-circle"
                        style="width: 100px; height: 100px" />
                    <span class="username">{{ Auth::user()->name }}</span>
                </div>
                <br />
                @if (session()->has('errors'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach (session('errors')->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Add Post Section -->
                <form action="{{ route('front.dashboard.post.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <section id="add-post" class="add-post-section mb-5">
                        <h2>Add Post</h2>
                        <div class="post-form p-3 border rounded">

                            <!-- Post Title -->
                            <input name="title" type="text" id="postTitle" class="form-control mb-2"
                                placeholder="Post Title" value="{{ old('title') }}" />

                            <!-- Small Description -->
                            <textarea name="small_desc" class="form-control mb-2" rows="3" placeholder="Enter Small Description"></textarea>

                            <!-- Post Content -->
                            <textarea name="desc" id="postContent" class="form-control mb-2" rows="3" placeholder="What's on your mind?">{{ old('desc') }}</textarea>

                            <!-- Image Upload -->
                            <input name="images[]" type="file" id="postImage" class="form-control mb-2" accept="image/*"
                                multiple />
                            <div class="tn-slider mb-2">
                                <div id="imagePreview" class="slick-slider"></div>
                            </div>

                            <!-- Category Dropdown -->
                            <select name="category_id" id="postCategory" class="form-control">
                                <option value="" selected>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select><br>

                            <!-- Enable Comments Checkbox -->
                            <div class="form-check mb-2">
                                <input name="comment_able" type="checkbox" id="commentableCheckbox" class="form-check-input"
                                    {{ old('comment_able') ? 'checked' : '' }} />
                                <label class="form-check-label" for="commentableCheckbox">Enable Comments</label>
                            </div><br />

                            <!-- Post Button -->
                            <button type="submit" class="btn btn-primary post-btn">Post</button>
                        </div>
                    </section>
                </form>

                <!-- Posts Section -->
                <section id="posts" class="posts-section">
                    <h2>Recent Posts</h2>
                    <div class="post-list">
                        <!-- Post Item -->
                        @forelse ($posts as $post)
                            <div class="post-item mb-4 p-3 border rounded">
                                <div class="post-header d-flex align-items-center mb-2">
                                    <img src="{{ asset(Auth::user()->image) }}" alt="User Image" class="rounded-circle"
                                        style="width: 50px; height: 50px" />
                                    <div class="ms-3">
                                        <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                                        <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <h4 class="post-title">{{ $post->title }}</h4>
                                <p class="post-content" style="word-wrap: break-word;">
                                    {!! $post->desc !!}
                                </p>

                                <div id="newsCarousel" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#newsCarousel" data-slide-to="0" class="active"></li>
                                        <li data-target="#newsCarousel" data-slide-to="1"></li>
                                        <li data-target="#newsCarousel" data-slide-to="2"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        @foreach ($post->images as $image)
                                            <div class="carousel-item @if ($loop->index == 0) active @endif ">
                                                <img src="{{ asset($image->path) }}" class="d-block w-100"
                                                    alt="First Slide" />
                                                <div class="carousel-caption d-none d-md-block">
                                                    <h5>{{ $post->title }}</h5>
                                                </div>
                                            </div>
                                        @endforeach

                                        <!-- Add more carousel-item blocks for additional slides -->
                                    </div>
                                    <a class="carousel-control-prev" href="#newsCarousel" role="button"
                                        data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#newsCarousel" role="button"
                                        data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>

                                <div class="post-actions d-flex justify-content-between">
                                    <div class="post-stats">
                                        <!-- View Count -->
                                        <span class="me-3"> <i class="fas fa-eye"></i>{{ $post->number_of_views }}
                                        </span>
                                    </div>

                                    <div style="margin-bottom:10px ">
                                        <a href="{{ route('front.dashboard.post.edit', $post->slug) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="javascript:void(0)"
                                            onclick="if(confirm('Are you sure you want to delete this post?')) { document.getElementById('delete-post-{{ $post->id }}').submit(); }"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-thumbs-up"></i> Delete
                                        </a>

                                        <form id="delete-post-{{ $post->id }}" method="POST"
                                            action="{{ route('front.dashboard.post.delete', $post->slug) }}"
                                            style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="slug" value="{{ $post->slug }}">
                                        </form>


                                        <button id="commentBtn-{{ $post->slug }}"
                                            class="get-comments btn btn-sm btn-outline-secondary"
                                            post-id="{{ $post->slug }}">
                                            <i class="fas fa-comment"></i> Comments
                                        </button>

                                        <button id="hideCommentBtn-{{ $post->slug }}"
                                            class="hide-comments btn btn-sm btn-outline-danger" style="display: none;"
                                            post-id="{{ $post->slug }}">
                                            <i class="fas fa-comment"></i> Hide Comments
                                        </button>

                                    </div>
                                </div>

                                <!-- Display Comments -->
                                <div class="comments" id="displayComments-{{ $post->slug }}" style="display: none;">
                                    <!-- Add more comments here for demonstration -->
                                </div>
                            </div>
                        @empty
                            <div class="alet alert-info">
                                No Posts Found
                            </div>
                        @endforelse

                        <!-- Add more posts here dynamically -->
                    </div>
                </section>
            </section>
        </div>
    </div>
    <!-- Profile End -->
@endsection

@push('js')
    <script>
        $(function() {
            $('#postImage').fileinput({
                theme: 'fa5',
                allowedFileTypes: ['image'],
                maxFileCount: 5,
                enableResumableUpload: false,
                showUpload: false,
            });
            $('#postContent').summernote({
                height: 300,
            });
        });

        // Get Comments
        $(document).on('click', '.get-comments', function(e) {
            e.preventDefault();

            var postSlug = $(this).attr('post-id');

            $.ajax({
                type: 'GET',
                url: '/user/post/get-comments/' + postSlug,
                success: function(response) {
                    var commentSection = $('#displayComments-' + postSlug);
                    commentSection.empty();

                    if (response.data.length > 0) {
                        $.each(response.data, function(key, comment) {
                            commentSection.append(`
                        <div class="comment">
                            <img src="{{ asset('') }}${comment.user.image}" alt="${comment.user.name || 'User'}'s image" class="comment-img" />
                            <div class="comment-content">
                                <span class="username">${comment.user.name}</span>
                                <p class="comment-text">${comment.comment}</p>
                            </div>
                        </div>
                    `);
                        });
                        commentSection.show();
                        $('#commentBtn-' + postSlug).hide();
                        $('#hideCommentBtn-' + postSlug).show();
                    }
                },
            });
        });
        // Hide Comments
        $(document).on('click', '.hide-comments', function(e) {
            e.preventDefault();

            var postSlug = $(this).attr('post-id');

            // 1- Hide Comments
            $('#displayComments-' + postSlug).hide();
            // 2- Hide Comment Button
            $('#hideCommentBtn-' + postSlug).hide();
            // 3- Show Comment Button
            $('#commentBtn-' + postSlug).show();
        })
    </script>
@endpush
