@extends('layouts.dashboard.app')

@section('title', 'Edit Post')

@section('content')
    <div class="container mt-4">
        <form action="{{ route('dashboard.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h2>Update Post</h2>
                        <a class="btn btn-primary" href="{{ route('dashboard.posts.index') }}">Show Posts</a>
                    </div>

                    @if (session()->has('errors'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach (session('errors')->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group mb-3">
                        <label for="title">Post Title</label>
                        <input type="text" value="{{ @old('title', $post->title) }}" name="title"
                            placeholder="Enter Post Title" class="form-control">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="postContent">Post Content</label>
                        <textarea id="postContent" name="desc" placeholder="Enter Description" class="form-control">{!! $post->desc !!}</textarea>
                        @error('desc')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="small_desc">Post Small Description</label>
                        <textarea id="small_desc" name="small_desc" class="form-control" placeholder="Enter Small Description">{{ old('small_desc', $post->small_desc) }}</textarea>
                        @error('small_desc')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="post-images">Upload Post Images</label>
                        <input type="file" multiple id="post-images" name="images[]" class="form-control">
                        @error('images')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="1" @selected($post->status == 1)>Active</option>
                            <option value="0" @selected($post->status == 0)>Not Active</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="category_id">Category</label>
                            <select name="category_id" class="form-control">
                                <option selected>Select Category</option>
                                @foreach ($categories as $category)
                                    <option @selected($category->id == $post->category_id) value="{{ $category->id }}">{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="comment_able">Comment Status</label>
                            <select name="comment_able" class="form-control">
                                <option selected>Select Comment Status</option>
                                <option value="1" @selected($post->comment_able == 1)>Active</option>
                                <option value="0" @selected($post->comment_able == 0)>Not Active</option>
                            </select>
                            @error('comment_able')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">Update Post</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            $('#post-images').fileinput({
                theme: 'fa5',
                allowedFileTypes: ['image'],
                maxFileCount: 5,
                enableResumableUpload: false,
                showUpload: false,
                initialPreviewAsData: true,
                initialPreview: [
                    @if ($post->images->count() > 0)
                        @foreach ($post->images as $image)
                            "{{ asset($image->path) }}",
                        @endforeach
                    @endif
                ],
                initialPreviewConfig: [
                    @if ($post->images->count() > 0)
                        @foreach ($post->images as $image)
                            {
                                caption: "{{ $image->path }}",
                                width: '120px',
                                url: "{{ route('dashboard.posts.image.delete', [$image->id, '_token' => csrf_token()]) }}",
                                key: "{{ $image->id }}",
                            },
                        @endforeach
                    @endif
                ]
            });
            $('#postContent').summernote({
                height: 300,
            });
        });
    </script>
@endpush
