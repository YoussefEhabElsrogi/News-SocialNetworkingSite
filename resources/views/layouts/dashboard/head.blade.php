<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="{{ config('app.name') }}">

    <title>Dashboard | @yield('title')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/dashboard/vendor') }}/fontawesome-free/css/all.min.css" rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/dashboard/css') }}/sb-admin-2.min.css" rel="stylesheet">

    {{-- File Input --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/file-input/css/fileinput.min.css') }}">

    {{-- Summernote --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote-bs4.min.css') }}">

    {{-- Moment --}}
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">

    {{-- Auth User --}}
    @auth('admin')
        <script>
            adminId = "{{ auth('admin')->user()->id }}";
            role = 'admin'
        </script>
    @endauth

    {{-- Vite --}}
    @vite('resources/js/app.js')

    @stack('css')

    {{-- Livewire CSS --}}
    @livewireStyles

</head>


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
