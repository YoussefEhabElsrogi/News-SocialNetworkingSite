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
        $settings = Setting::firstOrCreate(['site_name' => 'News Website'], [
            'site_name' => 'News Website',
            'email' => 'youssefelsrogi@gmail.com',
            'favicon' => 'default_favicon.ico',
            'logo' => 'logo.png',
            'facebook' => 'https://facebook.com/',
            'twitter' => 'https://twitter.com/',
            'instagram' => 'https://instagram.com/',
            'youtube' => 'https://youtube.com/',
            'phone' => '01124684262',
            'country' => 'Egypt',
            'city' => 'Alex',
            'street' => 'Elsarawy',
        ]);

        view()->share('settings', $settings);
    }
}
