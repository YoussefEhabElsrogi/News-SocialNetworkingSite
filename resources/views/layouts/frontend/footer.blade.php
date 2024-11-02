<!-- Footer Start -->
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h3 class="title">Get in Touch</h3>
                    <div class="contact-info">
                        <p><i
                                class="fa fa-map-marker"></i>{{ $settings->street }},{{ $settings->city }},{{ $settings->country }}
                        </p>
                        <p><i class="fa fa-envelope"></i>{{ $settings->email }}</p>
                        <p><i class="fa fa-phone"></i>{{ $settings->phone }}</p>
                        <div class="social">
                            <a href="{{ $settings->twitter }}" target="_blank" title="Follow us on Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="{{ $settings->facebook }}" target="_blank" title="Like us on Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="{{ $settings->instagram }}" target="_blank" title="Follow us on Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="{{ $settings->youtube }}" target="_blank" title="Subscribe to our YouTube channel">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h3 class="title">Useful Links</h3>
                    <ul>
                        @foreach ($related_sites as $site)
                            <li><a href="{{ $site->url }}"
                                    title="{{ $site->name }}"target="_blank">{{ $site->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h3 class="title">Quick Links</h3>
                    <ul>
                        <li><a href="#">Lorem ipsum</a></li>
                        <li><a href="#">Pellentesque</a></li>
                        <li><a href="#">Aenean vulputate</a></li>
                        <li><a href="#">Vestibulum sit amet</a></li>
                        <li><a href="#">Nam dignissim</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h3 class="title">Newsletter</h3>
                    <div class="newsletter">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Vivamus sed porta dui. Class aptent taciti sociosqu
                        </p>
                        <form action="{{ route('front.news.subscribe.store') }}" method="POST">
                            @csrf
                            <input class="form-control" type="email" name="email" placeholder="Your email here"
                                value="{{ old('email') }}" />
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <button class="btn">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Footer Bottom Start -->
<div class="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-6 copyright">
                <p>
                    Copyright &copy; <a href="">{{ config('app.name') }}</a>. All Rights
                    Reserved
                </p>
            </div>

            <div class="col-md-6 template-by">
                <p>Designed By <a href="{{ route('front.index') }}">Youssef Elsrogi</a></p>
            </div>
        </div>
    </div>
</div>
<!-- Footer Bottom End -->
