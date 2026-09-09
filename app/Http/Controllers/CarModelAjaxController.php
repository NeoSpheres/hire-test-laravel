<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CarModel;
use App\Models\EngineType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarModelAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        $engineTypes = EngineType::all();

        return view('datatable.models.index', compact('brands', 'engineTypes'));

    }

    public function fetchModel(Request $request)
    {
        $draw = $request->get('draw'); // Internal use
        $start = $request->get("start"); // where to start next records for pagination
        $rowPerPage = $request->get("length"); // How many recods needed per page for pagination

        $orderArray = $request->get('order');
        //dd($orderArray);
        $columnNameArray = $request->get('columns'); // It will give us columns array

        $searchArray = $request->get('search');
        $columnIndex = $orderArray[0]['column'];  // This will let us know,
                                                // which column index should be sorted
                                                // 0 = id, 1 = nomModel, 2 = brand_id , 3 = engine

        $columnName = [
            'id' => 'modeles.id',
            'nomModel' => 'modeles.nomModel',
            'brand_id' => 'modeles.brand_id',
            'engine_type_name' => 'engine_types.name',
        ][$columnNameArray[$columnIndex]['data'] ?? 'id'];

        $columnSortOrder = $orderArray[0]['dir']; // This will get us order direction(ASC/DESC)
        $searchValue = $searchArray['value']; // This is search value

        $models = CarModel::query()->select('modeles.id', 'modeles.nomModel', 'modeles.brand_id', 'modeles.engine_type_id', 'engine_types.name as engine_type_name')
            ->leftJoin('brands', 'modeles.brand_id', '=', 'brands.id')
            ->leftJoin('engine_types', 'modeles.engine_type_id', '=', 'engine_types.id');
        $total = $models->count();

        $totalFilterModels = CarModel::query()
            ->leftJoin('brands', 'modeles.brand_id', '=', 'brands.id')
            ->leftJoin('engine_types', 'modeles.engine_type_id', '=', 'engine_types.id');
        if (!empty($searchValue)) {
            $totalFilterModels = $totalFilterModels->where(function($query) use ($searchValue) {
                $query->where('modeles.nomModel', 'like', '%' . $searchValue . '%')
                    ->orWhere('engine_types.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('brands.name', 'like', '%' . $searchValue . '%');
            });
        }
        $totalFilter = $totalFilterModels->count();

        $arrData = CarModel::query()->select('modeles.id', 'modeles.nomModel', 'modeles.brand_id', 'modeles.engine_type_id', 'engine_types.name as engine_type_name')
            ->leftJoin('brands', 'modeles.brand_id', '=', 'brands.id')
            ->leftJoin('engine_types', 'modeles.engine_type_id', '=', 'engine_types.id')
            ->skip($start)
            ->take($rowPerPage)
            ->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where(function($query) use ($searchValue) {
                $query->where('modeles.nomModel', 'like', '%' . $searchValue . '%')
                    ->orWhere('engine_types.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('brands.name', 'like', '%' . $searchValue . '%');
            });
        }
        $arrData = $arrData->get();

        $response = array(
            'draw' => intval($draw),
            'recordsTotal' => $total,
            'recordsFiltered' => $totalFilter,
            'data' => $arrData,
        );

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = validator::make($request-> all(), [
            'nomModel' => 'required|string',
            'brand_id' => 'required',
            'engine_type_id' => 'required|exists:engine_types,id',
        ]);

        if ($input->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $input->messages(),
            ]);
        } else {
            $model = CarModel::query()->create([
                'nomModel' => $request->nomModel,
                'brand_id' => $request->brand_id,
                'engine_type_id' => $request->engine_type_id,
            ]);

            return response()->json([
                'status' => 200,
                'model' => $model,
                'message' => 'Model created successfully !',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $id = $request->query('id');
        $model = CarModel::with('engineType')->findOrFail($id);
        $brand = Brand::query()->findOrFail($model->brand_id);
        return response()->json([
            'data' => $model,
            'brand' => $brand,
            'engineType' => $model->engineType,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $model = CarModel::query()->with('engineType')->where($where)->firstOrFail();
        $brand = Brand::query()->findOrFail($model->brand_id);
        return response()->json([
            'status' => 200,
            'data' => $model,
            'brand' => $brand,
            'engineType' => $model->engineType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->query('id');

        $input = validator::make($request-> all(), [
            'nomModel' => 'required|string',
            'brand_id' => 'required',
            'engine_type_id' => 'required|exists:engine_types,id',
        ]);

        $model = CarModel::findOrFail($id);

        if ($input->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $input->messages(),
            ]);
        } else {
            $model->update([
                'nomModel' => $request->input('nomModel'),
                'brand_id' => $request->input('brand_id'),
                'engine_type_id' => $request->input('engine_type_id'),
            ]);
            return response()->json([
                'status' => 200,
                'data' => $model,
                'message' => 'Model updated successfully !',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->query('id');
        $model = CarModel::findOrFail($id);
        $model->delete();
        return response()->json([
            //'data' => $model,
            'message' => 'Model deleted successfully'
        ]);
    }
}
