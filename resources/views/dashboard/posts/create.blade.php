@extends('layouts.dashboard.app')

@section('title', 'Create Post')

@section('content')
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Create New Post</h2>
            <a href="{{ route('dashboard.posts.index') }}" class="btn btn-primary">Show Posts</a>
        </div>

        <form action="{{ route('dashboard.posts.store') }}" method="POST" enctype="multipart/form-data"s class="mt-4">
            @csrf

            {{-- Error Messages --}}
            @if (session()->has('errors'))
                <div class="alert alert-danger">
                    <ul>
                        @foreach (session('errors')->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow p-4">
                <!-- Post Title -->
                <div class="form-group">
                    <label for="title">Post Title</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}"
                        placeholder="Enter Post Title">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Post Small Description -->
                <div class="form-group">
                    <label for="small_desc">Post Small Description</label>
                    <textarea id="small_desc" name="small_desc" class="form-control" placeholder="Enter Description">{{ old('small_desc') }}</textarea>
                    @error('small_desc')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Post Description -->
                <div class="form-group">
                    <label for="postContent">Post Description</label>
                    <textarea id="postContent" name="desc" class="form-control" placeholder="Enter Description">{{ old('desc') }}</textarea>
                    @error('desc')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Post Images -->
                <div class="form-group">
                    <label for="postImage">Post Images</label>
                    <input type="file" id="postImage" name="images[]" multiple class="form-control">
                    @error('images')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Post Status -->
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="" selected>Select Status</option>
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Not Active</option>
                    </select>
                    @error('status')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Post Category -->
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category_id" id="category" class="form-control">
                        <option value="" selected>Select Category</option>
                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"{{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Comment Able Status -->
                <div class="form-group">
                    <label for="commentAble">Comment Ability</label>
                    <select name="comment_able" id="commentAble" class="form-control">
                        <option value="" selected>Select Comment Able Status</option>
                        <option value="1" {{ old('comment_able') == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('comment_able') === '0' ? 'selected' : '' }}>Not Active</option>
                    </select>
                    @error('comment_able')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary mt-3">Create Post</button>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            // Initialize File Input Plugin
            $('#postImage').fileinput({
                theme: 'fa5',
                allowedFileTypes: ['image'],
                maxFileCount: 5,
                showUpload: false
            });

            // Initialize Summernote Editor
            $('#postContent').summernote({
                height: 300
            });
        });
    </script>
@endpush
