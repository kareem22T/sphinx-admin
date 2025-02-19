<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function getHomeAd()
    {
        $settings = Setting::first();

        return response()->json([
            "ad" => [
                'thumbnail_path' => $settings->ad_image,
                'title_ar' => $settings->ad_title_ar,
                'title_en' => $settings->ad_title_en,
                'text_ar' => $settings->ad_description_ar,
                'text_en' => $settings->ad_description_en
            ],
            "ad2" => [
                'thumbnail_path' => $settings->ad2_image,
                'title_ar' => $settings->ad2_title_ar,
                'title_en' => $settings->ad2_title_en,
                'text_ar' => $settings->ad2_description_ar,
                'text_en' => $settings->ad2_description_en
            ],
            "main_image" => $settings->main_image,
        ], 200);
    }
}
