<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\User;
use Illuminate\Http\Request;

include_once app_path().'/Helpers/MatriculeHelper.php';

class DatatableCarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::all();
        $models = CarModel::all();
        $brands = Brand::all(); // Récupère toutes les marques de la base de données
        $users = User::all();
        $matricule = generateMatricule();


        return view('datatable.cars.index', compact('cars', 'brands','users','matricule'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $models = CarModel::all();
        $brands = Brand::all();
        $users = User::all();
        $matricule = generateMatricule();
        return view('datatable.cars.create', compact('models','brands', 'users', 'matricule'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'model_id' => 'required|exists:modeles,id',
            'user_id' => 'nullable|exists:users,id',
            'color' => 'required',
            'matricule' => 'required|unique:cars,matricule',
        ]);

        // Logique d'insertion
        try {
            $car = new Car($request->all());
            $car->save();
            return response()->json(['status' => 'success', 'message' => 'Car created successfully','car'=>$car]);
        } catch (\Exception $e) {
            Log::error('Error creating car: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Error creating car'], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)  // Vous n'avez pas besoin de typer l'argument si vous utilisez `find`
    {
        $car = Car::find($id);
        $brand = Brand::find($car->modele->brand_id);
        $model = CarModel::find($car->model_id);
        if ($car) {
            return response()->json(['status' => 'success', 'car' => $car,'brand'=>$brand,'model'=>$model]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Car not found'], 404);
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        $brands = Brand::all();
        $models = CarModel::all();
        return view('datatable.cars.edit',compact('car', 'brands', 'models'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        if($car){
            $car['model_id'] = $request->model_id;
            $car['user_id'] = $request->user_id;
            $car['color'] = $request->color;
            $car['matricule'] = $request->matricule;
            $car->save();

            return response()->json(['status' => 'success', 'message' => 'Success! car is updated', 'car' => $car]);
        }
        return response()->json(['status' => 'failed', 'message' => 'Failed! Unable to update car']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        // Vérifier si un utilisateur est associé à la voiture
        if ($car->user) {
            $availableCar = Car::whereNull('user_id')->first();

            if ($availableCar) {
                $availableCar->user_id = $car->user->id;
            } else {
                $randomModel = CarModel::query()->whereNotNull('id')->inRandomOrder()->first();

                $availableCar = Car::query()->create([
                    'model_id' => $randomModel->id,
                    'user_id' => $car->user->id,
                    'color' => $car->color,
                    'matricule' => generateMatricule(),
                ]);
            }
            $availableCar->save();
        }

        $car->delete();
        return redirect('cars.index')->with('success', 'Car created successfully!');    }

    public function getModelsByBrand($brandId)
    {
        try {
            $models = CarModel::where('brand_id', $brandId)->get();
            return response()->json($models);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function generateMatricule()
    {
        return response()->json(['matricule' => generateMatricule()]);
    }



}
