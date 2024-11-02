@extends('layouts.frontend.app')

@section('title')
    Edit : {{ $post->title }}
@endsection

@section('content')
    <div class="dashboard container">
        <!-- Sidebar -->
        <aside class="col-md-3 nav-sticky dashboard-sidebar">
            <!-- User Info Section -->
            <div class="user-info text-center p-3">
                <img src="{{ asset(auth()->user()->image) }}" alt="{{ auth()->user()->name }}" class="rounded-circle mb-2"
                    style="width: 80px; height: 80px; object-fit: cover" />
                <h5 class="mb-0" style="color: #ff6f61">{{ auth()->user()->name }}</h5>
            </div>

            <!-- Sidebar Menu -->
            @include('layouts.frontend.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="main-content col-md-9">

            @if (session()->has('errors'))
                <div class="alert alert-danger">
                    <ul>
                        @foreach (session('errors')->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Show/Edit Post Section -->
            <form action="{{ route('front.dashboard.post.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <section id="posts-section" class="posts-section">
                    <h2>Your Posts</h2>
                    <ul class="list-unstyled user-posts">
                        <li class="post-item">
                            <input hidden name="post_id" value="{{ $post->id }}">
                            <!-- Editable Title -->
                            <input type="text" class="form-control mb-2 post-title" name="title"
                                value="{{ old('title', $post->title) }}" />

                            <!-- Editable Content -->
                            <textarea id="desc" class="form-control mb-2 post-content" name="desc">{{ old('desc', $post->desc) }}</textarea>

                            <!-- Image Upload Input for Editing -->
                            <input id="images" type="file" class="form-control mt-2 edit-post-image" name="images[]"
                                accept="image/*" multiple />

                            <br>

                            <!-- Editable Category Dropdown -->
                            <select name="category_id" class="form-control mb-2 post-category">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected($category->id == old('category_id', $post->category_id))>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Editable Enable Comments Checkbox -->
                            <div class="form-check mb-2">
                                <input class="form-check-input enable-comments" name="comment_able" type="checkbox"
                                    @checked(old('comment_able', $post->comment_able == 1)) />
                                <label class="form-check-label">
                                    Enable Comments
                                </label>
                            </div>

                            <!-- Post Meta: Views and Comments -->
                            <div class="post-meta d-flex justify-content-between">
                                <span class="views">
                                    <i class="fa fa-eye"></i> {{ $post->number_of_views }}
                                </span>
                                <span class="post-comments">
                                    <i class="fa fa-comment"></i> {{ $post->comments->count() }}
                                </span>
                            </div>

                            <!-- Post Actions -->
                            <div class="post-actions mt-2">
                                <button type="submit" class="btn btn-primary edit-post-btn">Save Changes</button>
                                <a href="{{ route('front.dashboard.profile') }}"
                                    class="btn btn-danger delete-post-btn">Cancel</a>
                            </div>
                        </li>
                    </ul>
                </section>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('#images').fileinput({
            theme: 'fa5',
            allowedFileTypes: ['image'],
            maxFileCount: 5,
            showUpload: false,
            initialPreview: [
                @if ($post->images->isNotEmpty())
                    @foreach ($post->images as $image)
                        "{{ asset($image->path) }}",
                    @endforeach
                @endif
            ],
            initialPreviewAsData: true,
            initialPreviewConfig: [
                @if ($post->images->isNotEmpty())
                    @foreach ($post->images as $image)
                        {
                            caption: "{{ basename($image->path) }}",
                            width: '120px',
                            url: "{{ route('front.dashboard.post.image.delete', ['id' => $image->id, '_token' => csrf_token()]) }}",
                            key: {{ $image->id }},
                        },
                    @endforeach
                @endif
            ]
        });

        $('#desc').summernote({
            height: 300,
        });
    </script>
@endpush
