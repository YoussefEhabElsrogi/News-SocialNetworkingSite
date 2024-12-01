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
        $settings = Setting::firstOr(function () {
            return Setting::create([
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
                'small_desc' => 'Breaking news, updates, and in-depth articles covering global events, politics, entertainment, sports, and more. Stay informed with the latest trends and stories happening around the world.'
            ]);
        });

        $settings->whatsapp = "https://wa.me/" . $settings->phone;

        view()->share('settings', $settings);
    }
}
