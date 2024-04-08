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
        // Validation des données reçues
        $validatedData = $request->validate([
            'topbar_color' => 'required|string',
            'sidebar_color' => 'required|string',
            'title_color' => 'required|string',
        ]);

        // Enregistrement ou mise à jour des réglages
        // Ici, j'utilise le premier enregistrement ou je crée un nouveau si aucun réglage n'existe
        $setting = Setting::first() ?? new Setting();
        $setting->fill($validatedData);
        $setting->save();

        return redirect()->back()->with('success', 'Réglages sauvegardés avec succès!');
    }

    public function getSettings()
    {
        return Setting::first();
    }


}
