<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name') }} | @yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Bootstrap News Template - Free HTML Templates" name="keywords" />

    {{-- Meta Description --}}
    <meta content="@yield('description')" name="description" />

    {{-- Meta Robots --}}
    <meta name="robots" content="index, follow">

    {{-- Canonical Link --}}
    <link rel="canonical" href="@yield('canonical')">

    <!-- Favicon -->
    <link href="{{ asset('assets/frontend/img/favicon.ico') }}" rel="icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600&display=swap" rel="stylesheet" />

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/frontend/lib/') }}/slick/slick.css" rel="stylesheet" />
    <link href="{{ asset('assets/frontend/lib/') }}/slick/slick-theme.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="{{ asset('assets/frontend/css/') }}/style.css" rel="stylesheet" />

    {{-- File Input --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/file-input/css/fileinput.min.css') }}">

    {{-- Summernote --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote-bs4.min.css') }}">

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">

    {{-- Auth User --}}
    @auth('web')
        <script>
            userId = "{{ auth()->user()->id }}";
            role = 'user';
            showPostRoute = "{{ route('front.post.show', ':slug') }}";
        </script>
    @endauth

    @stack('css')

    @vite('resources/js/app.js')
</head>

<body>
