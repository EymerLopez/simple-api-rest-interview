<?php

namespace App\Http\Controllers;

use App\Http\Resources\RegionCollection;
use App\Libraries\ApiResponse;
use App\Models\Region;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $regions = Region::active()->get();
            $response = new ApiResponse(200, new RegionCollection($regions), 'Lista de regiones activas');

            return $response->successResponse();
        } catch (\Throwable $e) {
            report($e);
            $response = new ApiResponse(500, null, $e->getMessage());

            return $response->errorResponse();
        }
    }
}
