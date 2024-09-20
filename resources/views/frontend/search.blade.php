@extends('layouts.frontend.app')

@section('title', 'Search')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Search</li>
@endsection

@section('content')
    <!-- Main News Start-->
    <div class="main-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        @foreach ($posts as $post)
                            <div class="col-md-4">
                                <div class="mn-img">
                                    <img src="{{ $post->images->first()->path ?? 'default-image.jpg' }}"
                                        alt="{{ $post->title }}" />
                                    <div class="mn-title">
                                        <a href="{{ route('front.post.show', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- Main News End-->
@endsection
