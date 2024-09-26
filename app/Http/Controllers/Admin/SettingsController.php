<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class SettingsController extends Controller
{

    public function __invoke(Request $request)
    {
        $settings = Setting::get()->pluck('content', 'name')->toArray();

        if ($request->isMethod('POST')) {
            foreach ($request->all() as $key => $value) {
                if (array_key_exists($key, $settings)) {
                    $setting = Setting::where('name', $key)->first();

                    if ($setting) {
                        if ($key == 'services') {
                            $services = $value;
                            foreach ($services as $i => $service) {
                                $img = $service['image'];

                                if ($img instanceof UploadedFile) {
                                    $name = strtolower(str()->random(10)) . '-' . str_replace([' ', '_'], '-', $img->getClientOriginalName());

                                    $img->storeAs("/public/images/", $name);

                                    $services[$i]['image'] = "/storage/images/$name";
                                }
                            }
                            $setting->content = $services;
                            $setting->save();
                        } else {
                            $setting->content = $value;
                            $setting->save();
                        }
                    }
                }
            }

            return back()->with('success', __('Settings has been updated'));
        }

        return irender('Admin/Setting/index', compact('settings'));
    }

    /**
     * 
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
