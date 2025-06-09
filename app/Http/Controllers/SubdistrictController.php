<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Subdistrict;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubdistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subdistrict = SubDistrict::all();
        return response()->json(['success' => true, 'data' => $subdistrict]);
        //
    }
    // SubDistrictController.php
    public function getByDistrict($districtId)
    {
        $subDistricts = Subdistrict::where('districtId', $districtId)->get();
        return ResponseHelper::success($subDistricts, 'Sub-districts retrieved');
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
            'districtId' => 'required|exists:districts,id',
        ]);

        DB::beginTransaction();
        try {
            $subDistrict = Subdistrict::create([
                'name' => $validated['name'],
                'districtId' => $validated['districtId']
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Add Successfully',
                'data' => $subDistrict
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return ResponseHelper::error('Something went wrong: ' . $e->getMessage());
        }



        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Subdistrict $subdistrict)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subdistrict $subdistrict)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subdistrict $subdistrict, $id)
    {
        $subDistrict = Subdistrict::find($id);
        if (!$subDistrict) {
            return ResponseHelper::notFound('Sub District Not Found');
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'districtId' => 'required|exists:districts,id'
        ]);
        $subDistrict->update($validated);

        return ResponseHelper::success($subDistrict, 'Sub District Update Success');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subDistrict = Subdistrict::find($id);
        if (!$subDistrict) {
            return ResponseHelper::notFound('Sub District not found');
        }

        $subDistrict->delete();

        return ResponseHelper::success(null, 'Sub District deleted successfully');
        //
    }
}
