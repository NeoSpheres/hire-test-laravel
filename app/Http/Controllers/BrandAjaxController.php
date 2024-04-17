<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class BrandAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('datatable.brands.index');
    }

    public function fetchBrand(Request $request)
    {
        $draw = $request->get('draw'); // Internal use
        $start = $request->get("start"); // where to start next records for pagination
        $rowPerPage = $request->get("length"); // How many recods needed per page for pagination

        $orderArray = $request->get('order');
        $columnNameArray = $request->get('columns'); // It will give us columns array

        $searchArray = $request->get('search');
        $columnIndex = $orderArray[0]['column'];  // This will let us know,
                                                            // which column index should be sorted
                                                            // 0 = id, 1 = name, 2 = country , 3 = created_at

        $columnName = $columnNameArray[$columnIndex]['data']; // Here we will get column name,
                                                                            // Base on the index we get
        $columnSortOrder = $orderArray[0]['dir']; // This will get us order direction(ASC/DESC)
        $searchValue = $searchArray['value']; // This is search value

        $brands = Brand::query()->select('id', 'name', 'country');
        $total = $brands->count();

        $totalFilterBrands = Brand::query();
        if (!empty($searchValue)) {
            $totalFilterBrands = $totalFilterBrands->where('name','like','%'.$searchValue.'%')
                ->orWhere('country','like','%'.$searchValue.'%');
        }
        $totalFilter = $totalFilterBrands->count();

        $arrData = Brand::query();
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName,$columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('name','like','%'.$searchValue.'%')
                ->orWhere('country','like','%'.$searchValue.'%');
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
            'name' => 'required',
            'country' => 'required'
        ]);

        if ($input->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $input->messages(),
            ]);
        } else {
            $brand = Brand::query()->create([
                'name' => $request->name,
                'country' => $request->country,
            ]);

            return response()->json([
                'status' => 200,
                'brand' => $brand,
                'message' => 'Brand created successfully !',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $id = $request->query('id');
        $brand = Brand::findOrFail($id);
        return response()->json([
            'data' => $brand
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $brand = Brand::query()->where($where)->first();
        return response()->json([
            'status' => 200,
            'data' => $brand,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->query('id');

        $input = validator::make($request-> all(), [
            'name' => 'required',
            'country' => 'required'
        ]);

        $brand = Brand::findOrFail($id);

        if ($input->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $input->messages(),
            ]);
        } else {
            $brand->update([
                'name' => $request->input('name'),
                'country' => $request->input('country'),
            ]);
            return response()->json([
                'status' => 200,
                'data' => $brand,
                'message' => 'Brand updated successfully !',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->query('id');
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return response()->json([
            //'data' => $brand,
            'message' => 'Brand deleted successfully'
        ]);
    }
}
