<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ResponseHelper::success(Province::all(), 'Success Display List Province');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'unique:provinces,name'],
        ]);

        $province = Province::create($validator->validated());
        return ResponseHelper::success($province, 'Province Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $province = Province::find($id);

        if (!$province) {
            return ResponseHelper::notFound('Province Not Found');
        }

        return ResponseHelper::success($province, 'Province Found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $province = Province::find($id);

        if (!$province) {
            return ResponseHelper::notFound('Province Not Found');
        }
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'unique:provinces,name,' . $province->id],
        ]);

        $province->update($validator->validated());
        return ResponseHelper::success($province, 'Province Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $province = Province::find($id);

        if (!$province) {
            return ResponseHelper::notFound('Province Not Found');
        }

        $province->delete();
        return ResponseHelper::success(null, 'Province Deleted Successfully');
    }
}
