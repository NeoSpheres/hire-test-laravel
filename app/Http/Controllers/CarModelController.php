<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModeleStore;
use App\Models\Brand;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Mod;

class CarModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = CarModel::latest()->paginate(5);
        return view('Modeles.index', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands=Brand::all();
        return view('Modeles.create',compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomModel' => 'required|string',
            'brand_id' => 'required',
            'engine' => 'required|in:Petrol,Hybrid,Electric',
        ]);

        CarModel::create([
            'nomModel' => $request->nomModel,
            'brand_id' => $request->brand_id,
            'engine' => $request->engine,
        ]);

        return redirect()->route('model.index')->with('success', 'Modèle créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $modele = CarModel::find($id);
        $brands=Brand::all();
        return view('Modeles.show', compact('modele','brands'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CarModel $model)
    {
        $brands = Brand::all();
        return view('Modeles.editModel', compact('model','brands'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarModel $model)
    {
        // Validation des données
        $validatedData = $request->validate([
            'nomModel' => 'required|string',
            'brand_id' => 'required',
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
    public function destroy(CarModel $model)
    {
        $cars = Car::where('model_id', $model->id)->get();

        if ($cars) {
            foreach ($cars as $car) {
                if ($car->user) {
                    $availableCar = Car::whereNull('user_id')->first();
                    if ($availableCar) {
                        $availableCar->user_id = $car->user->id;
                    } else {
                        // Récupérer un modèle aléatoire qui n'a pas l'ID spécifique de $model->id
                        $randomModel = CarModel::query()->whereNotIn('id', [$model->id])->inRandomOrder()->first();
                        if (!$randomModel) {
                            $brand = Brand::query()->where('name', 'Ford')->first();
                            if (!$brand) {
                                $newBrand = Brand::query()->create([
                                    'name' => 'Ford',
                                    'country' => 'US',
                                ]);
                                $newBrand->save();

                                $randomModel = CarModel::query()->create([
                                    'nomModel' => 'Ranger',
                                    'brand_id' => $newBrand->id,
                                    'engine' => 'Hybrid',
                                ]);
                                $randomModel->save();

                            } else {
                                $randomModel = CarModel::query()->create([
                                    'nomModel' => $brand->name,
                                    'brand_id' => $brand->id,
                                    'engine' => 'Hybrid',
                                ]);
                                $randomModel->save();
                            }

                        }

                        $availableCar = Car::query()->create([
                            'model_id' => $randomModel->id,
                            'user_id' => $car->user->id,
                            'color' => $car->color,
                            'matricule' => $car->matricule,
                        ]);
                    }
                    $availableCar->save();
                }

                // Supprimer la voiture ayant ce modèle
                //$car->delete();
            }
        }

        $model->delete();
        return redirect()->route('model.index')->with('success', 'Modèle supprimé avec succès.');

    }

    public function getModelsByBrand($brandId)
    {
        // Récupérer les modèles associés à la marque spécifiée
        $models = CarModel::where('brand_id', $brandId)->get();

        // Retourner les modèles au format JSON
        return response()->json($models);
    }
}
