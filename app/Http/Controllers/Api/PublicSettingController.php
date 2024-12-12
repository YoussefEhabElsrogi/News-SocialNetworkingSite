<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\RelatedNewsSite;
use App\Models\Setting;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class PublicSettingController extends Controller
{
    use ApiResponseTrait;

    public function getSettings()
    {
        $setting = Setting::first();
        $relatedSites = $this->relatedSites();

        if (!$setting) {
            return ApiResponseTrait::sendResponse(404, 'Settings not found', null);
        }

        $data = [
            'setting' => SettingResource::make($setting),
            'related_sites' => $relatedSites,
        ];

        return ApiResponseTrait::sendResponse(200, 'This is Site Setting', $data);
    }
    private function relatedSites()
    {
        $relatedSite = RelatedNewsSite::select('name', 'url')->get();

        if (!$relatedSite) {
            return ApiResponseTrait::sendResponse(404, 'Related Sites not found', null);
        }

        return $relatedSite;
    }
}
