<?php

namespace App\Http\Controllers;

use App\Http\Requests\TireRequest;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Tire;
use Illuminate\Http\Request;

class TireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tires = Tire::select(['id', 'brand', "model", "type"])->with(['carFrontTire', 'carRearTire'])->latest()->paginate(5);

        return view('tires.index', compact('tires'))->with(request()->input('page'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tireTypes = config("data.tire_types");

        return view('tires.create', compact("tireTypes"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TireRequest $request)
    {
        Tire::create($request->all());

        return redirect()->route('tires.index')->with('success', 'Tire created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tire $tire)
    {
        return view('tires.show', compact('tire'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tire $tire)
    {
        $tireTypes = config("data.tire_types");
        return view('tires.edit',compact('tire', "tireTypes"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TireRequest $request, Tire $tire)
    {
        $tire->update($request->all());

        return redirect()->route('tires.index')
            ->with('success', 'Car tire updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tire $tire)
    {
        if ($tire->carFrontTire->count() > 0 || $tire->carRearTire->count() > 0) {
            return redirect()->route('tires.index')
                ->with('error', 'Unable to delete bound to car tire!');
        }

        $tire->delete();

        return redirect()->route('tires.index')
            ->with('success', 'Tire deleted successfully.');
    }
}
