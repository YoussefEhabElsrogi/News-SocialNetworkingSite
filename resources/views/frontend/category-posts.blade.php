@extends('layouts.frontend.app')

@section('title')
    Category {{ $category->name }}
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">{{ $category->name }}</li>
@endsection

@section('content')
    <br>
    <br>
    <br>
    <!-- Main News Start-->
    <div class="main-news">
        <div class="container">
            <div class="row">

                <div class="col-lg-9">
                    <div class="row">
                        @forelse ($posts as $post)
                            <div class="col-md-4">
                                <div class="mn-img">
                                    <img src="{{ $post->images->first()->path }}" />
                                    <div class="mn-title">
                                        <a href="{{ route('front.post.show', $post->slug) }}"
                                            title="{{ $post->title }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert-info">Category Is Empty</div>
                        @endforelse
                    </div>
                    {{ $posts->links() }}
                </div>

                <div class="col-lg-3">
                    <div class="mn-list">
                        <h2 style="white-space: nowrap">Other Categories</h2>
                        <ul>
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ route('front.category.posts', $category->slug) }}"
                                        title="{{ $category->name }}">{{ $category->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main News End-->
@endsection
