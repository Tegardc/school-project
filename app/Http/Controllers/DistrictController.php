<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $district = District::all();
        return response()->json(['success' => true, 'data' => $district]);

        //
    }
    public function getByProvince($provinceId)
    {
        $districts = District::where('provinceId', $provinceId)->get();
        return ResponseHelper::success($districts, 'Districts retrieved');
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
        $validated = $request->validate([
            'name' => 'required|string',
            'provinceId' => 'required|exists:provinces,id'
        ]);
        DB::beginTransaction();
        try {
            $district = District::create(['name' => $validated['name'], 'provinceId' => $validated['provinceId']]);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Add Successfully', 'data' => [
                'id' => $district->id,
                'name' => $district->name,
                'provinceId' => $district->provinceId
            ]]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return ResponseHelper::error('Something went wrong: ' . $e->getMessage());
        }

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(District $district)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(District $district)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, District $district, $id)
    {
        $district = District::find($id);
        if (!$district) {
            return ResponseHelper::notFound('District Not Found');
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'provinceId' => 'required|exists:provinces,id'
        ]);
        $district->update($validated);

        return ResponseHelper::success($district, 'District Update Success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $district = District::find($id);
        if (!$district) {
            return ResponseHelper::notFound('District not found');
        }

        $district->delete();

        return ResponseHelper::success(null, 'District deleted successfully');
    }
}
