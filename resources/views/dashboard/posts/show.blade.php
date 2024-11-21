@extends('layouts.dashboard.app')

@section('title', 'Show Post')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/style.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-center">
        <div class="card-body shadow mb-4" style="max-width: 100ch">
            <a class="btn btn-primary" href="{{ route('dashboard.posts.index', ['page' => request()->page]) }}">Back To
                Posts</a>
            <br><br>
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
                    <h6>Views : {{ $post->number_of_views }} <i class="fa fa-eye"></i></h6>
                </div>
                <div class="col-4">
                    <h6>Created At : {{ $post->created_at->format('Y-m-d h:m') }} <i class="fa fa-edit"></i></h6>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <h6>Comments : {{ $post->comment_able == 1 ? 'Active' : 'Not Active' }} <i class="fa fa-comment"></i>
                    </h6>
                </div>
                <div class="col-4">
                    <h6>Status :
                        <i class="fa @if ($post->status == 0) fa-plane status-inactive @else fa-wifi status-active @endif"
                            title="{{ $post->status == 0 ? 'Inactive' : 'Active' }}"></i>
                    </h6>
                </div>
                <div class="col-4">
                    <h6>Slug : {{ $post->slug }} <i class="fa fa-share-square"></i></h6>
                </div>
            </div>

            <br>
            <hr>
            <br>
            <div class="sn-content">
                <h3>{{ $post->title }}</h3>
                <div class="description">{!! $post->desc !!}</div>
            </div>

            <br><br>

            <!-- Comments Section -->
            <div class="comments-section">
                <h5>Comments ({{ $post->comments->count() }})</h5>
                @forelse ($post->comments as $comment)
                    <div class="comment-item">
                        <img src="{{ asset($comment->user->image) }}" alt="{{ $comment->user->name }}">
                        <div class="comment-content">
                            <h6>{{ $comment->user->name }} <span
                                    class="comment-time">{{ $comment->created_at->diffForHumans() }}</span></h6>
                            <p>{{ $comment->comment }}</p>
                        </div>
                        <div class="comment-actions">
                            <a href="" class="text-danger">Delete</a>
                        </div>
                    </div>
                @empty
                    <div class="no-comments">No comments yet. Be the first to comment!</div>
                @endforelse
            </div>

        </div>
    </div>
@endsection
