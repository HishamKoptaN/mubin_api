<?php

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

function irender($component, $props = [])
{
    return Inertia::render($component, $props);
}

function getSetting($name, $default = null)
{
    $setting = Setting::where('name', $name)->first();

    if ($setting)
        return $setting->content;

    return $default;
}

function storage_url($path)
{
    return Storage::url($path);
}

function storage_exists($path)
{
    return Storage::fileExists('public/' . $path);
}

function user(): User
{
    return auth()->user();
}

function id()
{
    return user()->id;
}
