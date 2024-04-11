<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Modele;
use App\Models\User;
use Illuminate\Http\Request;

include_once app_path().'/Helpers/MatriculeHelper.php';

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::latest()->paginate(5);
        return view('cars.index', compact('cars'))->with(request()->input('page'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $models = Modele::all();
        $brands = Brand::all();
        $users = User::all();
        $matricule = generateMatricule();
        return view('cars.create', compact('models','brands', 'users', 'matricule'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'model_id' => 'required|exists:modeles,id',
            'color' => 'required|string|max:25',
        ]);

        $matricule = $request->input('matricule_hidden');

        Car::create([
            'model_id' => $request->model_id,
            'color' => $request->color,
            'matricule' => $matricule,
        ]);

        return redirect()->route('cars.index')->with('success', 'Car created successfully !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        $brand = Brand::find($car->modele->brand_id);
        return view('cars.show', compact('car', 'brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        $brands = Brand::all();
        $models = Modele::all();
        return view('cars.edit',compact('car', 'brands', 'models'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $input = $request->except('matricule');

        $car->update($input);
        return redirect()->route('cars.index')->with('success','Car updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('cars.index')->with('success', 'Car deleted successfully !');
    }
}
