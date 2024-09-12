<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class CheckSettingProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Setting::firstOr(function () {
            return Setting::create([
                'site_name' => 'News Website',
                'email' => 'info@example.com',
                'favicon' => 'default_favicon.ico',
                'logo' => 'default_logo.png',
                'facebook' => 'https://facebook.com/default',
                'twitter' => 'https://twitter.com/default',
                'instagram' => 'https://instagram.com/default',
                'youtube' => 'https://youtube.com/default',
                'phone' => '01124684262',
                'country' => 'Egypt',
                'city' => 'Cairo',
                'street' => 'Default Street',
            ]);
        });
    }
}
