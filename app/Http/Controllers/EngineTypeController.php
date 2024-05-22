<?php

namespace App\Http\Controllers;

use App\Http\Requests\EngineTypeRequest;
use App\Models\EngineType;
use Illuminate\Http\Request;

class EngineTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = EngineType::latest()->paginate(5);
        return view('engineTypes.index', compact('data'))->with($request->input('page'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('engineTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EngineTypeRequest $request)
    {
        $payload = $request->validated();
        EngineType::create($payload);
        return redirect()->route('engine-type.index')->with('success', 'Engine créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EngineType $engineType)
    {
        return view('engineTypes.show', compact('engineType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EngineType $engineType)
    {
        return view('engineTypes.edit', compact('engineType'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(EngineTypeRequest $request, EngineType $engineType)
    {
        // Validation des données

        // Mise à jour du modèle dans la base de données
        $engineType->update($request->validated());

        // Redirection après la mise à jour
        return redirect()->route('engine-type.index')->with('success', 'Engine mis à jour avec succès.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EngineType $engineType)
    {
        $engineType->delete();
        return redirect()->route('engine-type.index')->with('success', 'Engine supprimé avec succès.');

    }
}
