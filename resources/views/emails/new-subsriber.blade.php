<x-mail::message>
    <x-slot name="header">
        <img src="{{ asset('assets/frontend/img/') }}{{ $settings->logo }}" alt="{{ config('app.name') }}"
            style="width: 200px;">
    </x-slot>

    # Welcome to Our Newsletter

    Thank you for subscribing to our newsletter! We're excited to have you on board.

    <x-mail::button :url="route('front.index')" style="background-color: #007bff; color: #fff;">
        Visit Our Website
    </x-mail::button>


    Thanks,<br>
    <strong>{{ config('app.name') }}</strong>

    <x-slot name="footer">
        <p style="font-size: 12px; color: #999;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights
            reserved.</p>
    </x-slot>
</x-mail::message>
