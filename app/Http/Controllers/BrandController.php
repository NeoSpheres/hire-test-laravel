<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Modele;
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
        $randomBrand = Brand::query()->whereNotNull('id')->inRandomOrder()->first();
        $newModel = new Modele();

        if(!$randomBrand) {
            $newBrand = Brand::query()->create([
                'name' => 'Ford',
                'country' => 'US',
            ]);
            $newBrand->save();

            $newModel = Modele::query()->create([
                'nomModel' => 'Ranger',
                'brand_id' => $newBrand->id,
                'engine' => 'Hybrid',
            ]);
            $newModel->save();
        } else {
            $randomModel = Modele::where('brand_id', $randomBrand->id)->get()->first();
            $newModel = $randomModel;
        }

        $models = Modele::where('brand_id', $brand->id)->get();
        foreach ($models as $model) {
            //$model->brand_id = $newBrand->id;
            $cars = Car::where('model_id', $model->id)->get();
            foreach ($cars as $car) {
                $car->update(['model_id' => $newModel->id]);
                $car->save();
            }
        }

        $brand->delete();
        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully !');
    }
}
