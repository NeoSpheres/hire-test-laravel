<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function store(Request $request)
    {
        // Only perform validation if you want to ensure that when a color is set, it meets certain criteria.
        $inputData = $request->only(['topbar_color', 'sidebar_color', 'title_color']);

        $setting = Setting::first() ?? new Setting();

        foreach ($inputData as $key => $value) {
            // Check if the value is not the default black color
            if ($value !== '#000000') {
                $setting->{$key} = $value;
            }
        }

        $setting->save();

        return redirect()->back()->with('success', 'Réglages sauvegardés avec succès!');
    }



}
