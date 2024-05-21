<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use App\Models\CarModel;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::latest()->paginate(5);
        return view('brands.index', compact('brands'))->with(request()->input('page'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request-> validate([
            'name' => 'required',
            'country' => 'required'
        ]);
        Brand::create($input);
        return redirect()->route('brands.index')->with('success', 'Brand created successfully !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return view('brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('brands.edit',compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $input = $request-> validate([
            'name' => 'required',
            'country' => 'required'
        ]);

        $brand->update($input);
        return redirect()->route('brands.index')->with('success','Brand updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $models = CarModel::where('brand_id', $brand->id)->get();
        foreach ($models as $model) {
            $cars = Car::where('model_id', $model->id)->get();
            foreach ($cars as $car) {
                if ($car->user) {
                    $brandFord = Brand::where('name', $brand->name)->first();
                    $brandName = $brandFord->name;
                    $availableCar = Car::where('model_id', '!=', $model->id)
                        ->whereDoesntHave('modele.brand', function ($query) use ($brandName) {
                            $query->where('name', $brandName);
                        })
                        ->inRandomOrder()
                        ->first();
                    if ($availableCar) {
                        $availableCar->user_id = $car->user->id;
                    } else if (!$brandFord) {
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

                        $availableCar = Car::query()->create([
                            'model_id' => $randomModel->id,
                            'user_id' => $car->user->id,
                            'color' => $car->color,
                            'matricule' => $car->matricule,
                        ]);
                    } else {
                        // Récupérer un modèle aléatoire avec le même brand_id que $brandFord
                        $randModel = CarModel::where('brand_id', $brandFord->id)->inRandomOrder()->first();
                        if (!$randModel) {
                            $randModel = CarModel::query()->create([
                                'nomModel' => 'Ranger',
                                'brand_id' => $brandFord->id,
                                'engine' => 'Hybrid',
                            ]);
                            $randModel->save();
                            $availableCar = Car::query()->create([
                                'model_id' =>$randModel->id,
                                'user_id' => $car->user->id,
                                'color' => $car->color,
                                'matricule' => $car->matricule,
                            ]);
                            $availableCar->save();

                        }
                        $availableCar = Car::query()->create([
                            'model_id' =>$randModel->id,
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

        $brand->delete();
        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully !');
    }
}
