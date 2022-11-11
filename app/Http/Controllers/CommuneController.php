<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommuneCollection;
use App\Libraries\ApiResponse;
use App\Models\Commune;

class CommuneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $communes = Commune::active()->get();
            $response = new ApiResponse(200, new CommuneCollection($communes), 'Lista de comunas activas');

            return $response->successResponse();
        } catch (\Throwable $e) {
            report($e);
            $response = new ApiResponse(500, null, $e->getMessage());

            return $response->errorResponse();
        }
    }
}
