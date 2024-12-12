@extends('layouts.frontend.app')

@section('title', 'Home')

@section('canonical', url()->full())

@section('description', $settings->small_desc)

@section('breadcrumb')
    @parent
@endsection

@section('content')
    {{-- Return LatestThree Post --}}
    @php
        $latestThree = $posts->take(3);
    @endphp

    <!-- Top News Start-->
    <div class="top-news">
        <div class="container">
            <div class="row">
                <div class="col-md-6 tn-left">
                    <div class="row tn-slider">
                        @foreach ($latestThree as $post)
                            <div class="col-md-6">
                                <div class="tn-img">
                                    <img style="height: 383px;width:540px" src="{{ $post->images->first()->path }}" />
                                    <div class="tn-title">
                                        <a href="{{ route('front.post.show', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6 tn-right">
                    <div class="row">
                        @php
                            $fourPost = $posts->take(4);
                        @endphp
                        @foreach ($fourPost as $post)
                            <div class="col-md-6">
                                <div class="tn-img">
                                    <img width="280px" height="195px" src="{{ asset($post->images->first()->path) }}" />
                                    <div class="tn-title">
                                        <a href="{{ route('front.post.show', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top News End-->

    <!-- Category News Start-->
    <div class="cat-news">
        <div class="container">
            <div class="row">
                @foreach ($categories_with_posts as $category)
                    <div class="col-md-6">
                        <h2>{{ $category->name }}</h2>
                        <div class="row cn-slider">
                            @foreach ($category->posts as $post)
                                <div class="col-md-6">
                                    <div class="cn-img">
                                        <img src="{{ asset($post->images->first()->path) }}" class="img-fluid"
                                            style="width: 300px; height: 200px; object-fit: cover;" alt="No Image" />
                                        <div class="cn-title">
                                            <a href="{{ route('front.post.show', $post->slug) }}">{{ $post->title }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Category News End-->

    <!-- Tab News Start-->
    <div class="tab-news">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ul class="nav nav-pills nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#featured">Popular News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#popular">Oldest News</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="featured" class="container tab-pane active">
                            @foreach ($popularPosts as $post)
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="{{ asset($post->images->first()->path) }}" alt="{{ $post->title }}" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="{{ route('front.post.show', $post->slug) }}">{{ $post->title }}
                                            comment({{ $post->comments_count }})</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div id="popular" class="container tab-pane fade">
                            @foreach ($oldestPosts as $post)
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="{{ $post->images->first()->path ?? '' }}" alt="{{ $post->title }}" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="{{ route('front.post.show', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <ul class="nav nav-pills nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#m-viewed">Latest News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#m-read">Most Read</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        {{-- content latest news --}}
                        <div id="m-viewed" class="container tab-pane active">
                            @foreach ($latestThree as $post)
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="{{ $post->images->first()->path ?? '' }}" alt="{{ $post->title }}" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="{{ route('front.post.show', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div id="m-read" class="container tab-pane fade">
                            @foreach ($greatestPostsViews as $post)
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="{{ $post->images->first()->path ?? '' }}" alt="{{ $post->title }}" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="{{ route('front.post.show', $post->slug) }}">{{ $post->title }}
                                            ({{ $post->number_of_views }})
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tab News End-->


    <!-- Main News Start-->
    <div class="main-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        @forelse ($posts as $post)
                            <div class="col-md-4">
                                <div class="mn-img">
                                    <img width="260px" height="150px" src="{{ asset($post->images->first()->path) }}"
                                        alt="{{ $post->title }}" />
                                    <div class="mn-title">
                                        <a href="{{ route('front.post.show', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="no-posts">
                                <h2 class="no-posts-message">No Posts Available</h2>
                                <p class="no-posts-description" style="width: 90%">It looks like there are no posts
                                    available at the moment.
                                    Please check back later or explore other sections of the site.</p>
                            </div>
                        @endforelse

                        {{ $posts->links() }}
                    </div>
                </div>

                {{-- Use Caching --}}
                <div class="col-lg-3">
                    <div class="mn-list">
                        <h2>Read More</h2>
                        <ul>
                            @foreach ($read_more_posts as $post)
                                <li>
                                    <a href="{{ route('front.post.show', $post->slug) }}">{{ $post->title }}</a>
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
