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
        $data = Modele::latest()->paginate(5);
        return view('Modeles.index', compact('data'));
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
    {
        $request->validate([
        'nomModel' => 'required|string',
        'idBrand' => 'required',
        'engine' => 'required|in:Petrol,Hybrid,Electric',
    ]);

        Modele::create([
            'nomModel' => $request->nomModel,
            'idBrand' => $request->idBrand,
            'engine' => $request->engine,
        ]);

        return redirect()->route('model.index')->with('success', 'Modèle créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $modele = Modele::find($id);
        $brands=Brand::all();
        return view('Modeles.show', compact('modele','brands'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modele $model)
    {
        $brands = Brand::all();
        return view('Modeles.editModel', compact('model','brands'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Modele $model)
    {
        // Validation des données
        $validatedData = $request->validate([
            'nomModel' => 'required|string',
            'idBrand' => 'required',
            'engine' => 'required|in:Petrol,Hybrid,Electric',
        ]);

        // Mise à jour du modèle dans la base de données
        $model->update($validatedData);

        // Redirection après la mise à jour
        return redirect()->route('model.index')->with('success', 'Modèle mis à jour avec succès.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modele $model)
    {
        $model->delete();
        return redirect()->route('model.index')->with('success', 'Modèle supprimé avec succès.');

    }

    public function getModelsByBrand($brandId)
    {
        // Récupérer les modèles associés à la marque spécifiée
        $models = Modele::where('idBrand', $brandId)->get();

        // Retourner les modèles au format JSON
        return response()->json($models);
    }
}
