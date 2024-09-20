@extends('layouts.frontend.app')

@section('title', 'Contact Us')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Contact-Us</li>
@endsection

@section('content')
    <!-- Contact Start -->
    <div class="contact">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="contact-form">
                        <form action="{{ route('front.contact.store') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" placeholder="Your Name" name="name"
                                        value="{{ old('name') }}" />
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="email" class="form-control" placeholder="Your Email" name="email"
                                        value="{{ old('email') }}" />
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Subject" name="title"
                                    value="{{ old('title') }}" />
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="5" placeholder="Message" name="body">{{ old('body') }}</textarea>
                                @error('body')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Your Phone Number" name="phone"
                                    value="{{ old('phone') }}" />
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <button class="btn" type="submit">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info">
                        <h3>Get in Touch</h3>
                        <p class="mb-4">
                            The contact form is currently inactive. Get a functional and
                            working contact form with Ajax & PHP in a few minutes. Just copy
                            and paste the files, add a little code and you're done.
                        </p>
                        <h4><i class="fa fa-map-marker"></i> {{ $settings->street }}, {{ $settings->city }},
                            {{ $settings->country }}</h4>
                        <h4><i class="fa fa-envelope"></i> {{ $settings->email }}</h4>
                        <h4><i class="fa fa-phone"></i> {{ $settings->phone }}</h4>
                        <div class="social">
                            <a href="{{ $settings->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a>
                            <a href="{{ $settings->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{ $settings->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            <a href="{{ $settings->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a>
                            <a href="{{ $settings->youtube }}" target="_blank"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection
