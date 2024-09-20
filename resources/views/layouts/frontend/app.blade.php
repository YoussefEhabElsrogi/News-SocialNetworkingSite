@include('layouts.frontend.head')

@include('layouts.frontend.navbar')

<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <div class="container">
        <ul class="breadcrumb">
            @section('breadcrumb')
                <li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
            @show
        </ul>
    </div>
</div>
<!-- Breadcrumb End -->

@yield('content')

@include('layouts.frontend.footer')

@include('layouts.frontend.scripts')
