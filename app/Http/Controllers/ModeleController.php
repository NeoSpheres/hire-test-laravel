<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModeleStore;
use App\Models\Brand;
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
        $brands=Brand::all();
        $matricule = generateMatricule();
        return view('Modeles.create',compact('brands','matricule'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { $request->validate([
        'nomModel' => 'required|string',
        'idBrand' => 'required',
        'matricule_hidden' => 'required|string',
        'color' => 'required|string',
        'engine' => 'required|in:Petrol,Hybrid,Electric',
    ]);

        $matricule = $request->input('matricule_hidden');

        Modele::create([
            'nomModel' => $request->nomModel,
            'idBrand' => $request->idBrand,
            'matricule' => $matricule,
            'color' => $request->color,
            'engine' => $request->engine,
        ]);

        return redirect()->route('model.index')->with('success', 'Modèle créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Modele $model)
    {
        return view('Modeles.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modele $model)
    {
        return view('Modeles.edit', compact('model'));
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
