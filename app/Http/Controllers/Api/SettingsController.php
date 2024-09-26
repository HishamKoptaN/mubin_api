<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use App\Models\Setting;
use App\Models\Task;
use App\Models\TaskUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class SettingsController extends Controller
{

    public function handleSettings(Request $request)
    {
        if ($request->setting_name) {
            if ($request->setting_name == "payment_methods") {
                return [
                    'status' => true,
                    'content' => Currency::get()
                ];
            }

            $setting = Setting::where('name', $request->setting_name)->first();

            return [
                'status' => true,
                'content' => $setting?->content
            ];
        }

        $settings = Setting::get()->pluck('content', 'name')->toArray();

        return [
            'status' => true,
            'settings' => $settings
        ];
    }
}
