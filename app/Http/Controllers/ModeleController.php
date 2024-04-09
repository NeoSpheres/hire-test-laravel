<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModeleStore;
use App\Models\Modele;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Mod;

class ModeleController extends Controller
{
    /**
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
        $brand=Modele::all();
        return view('Modeles.create',compact('brand'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ModeleStore $request)
    {
        $input = $request-> validated();
        Modele::create($input);
        return redirect()->route('modeles.index')->with('success', 'model created successfully !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Modele $model)
    {
        return view('modeles.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modele $model)
    {
        return view('modeles.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Modele $model)
    {
        $input = $request-> validated();
        $model->update($input);
        return redirect()->route('modeles.update')->with('success', 'model updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modele $model)
    {
        $model->delete();
        return redirect()->route('modeles.index')->with('success', 'Modèle supprimé avec succès.');

    }
}
