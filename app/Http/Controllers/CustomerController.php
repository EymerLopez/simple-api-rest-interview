<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Libraries\ApiResponse;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $regions = Customer::active()->get();
            $response = new ApiResponse(200, new CustomerCollection($regions), 'Lista de clientes activos');

            return $response->successResponse();
        } catch (\Throwable $e) {
            report($e);
            $response = new ApiResponse(500, null, $e->getMessage());

            return $response->errorResponse();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->only(['dni', 'id_com', 'email', 'name', 'last_name', 'address']);
            $customer = Customer::create($data);

            $response = new ApiResponse(200, new CustomerResource($customer), 'Cliente creado correctamente');

            return $response->successResponse();
        } catch (\Throwable $e) {
            report($e);
            $response = new ApiResponse(500, null, $e->getMessage());

            return $response->errorResponse(false);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($dniOrEmail)
    {
        try {
            $customer = Customer::active()
            ->where('dni', $dniOrEmail)
            ->orWhere('email', $dniOrEmail)
            ->first();

            $response = new ApiResponse(200, new CustomerResource($customer), 'Detalle de cliente');

            return $response->successResponse();
        } catch (\Throwable $e) {
            report($e);
            $response = new ApiResponse(500, null, $e->getMessage());

            return $response->errorResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($dniOrEmail)
    {
        try {
            $customer = Customer::where('dni', $dniOrEmail)
            ->orWhere('email', $dniOrEmail)
            ->first();
            $customer->delete();

            $response = new ApiResponse(200, null, 'Cliente Eliminado');

            return $response->successResponse();
        } catch (\Throwable $e) {
            report($e);
            $response = new ApiResponse(500, null, $e->getMessage());

            return $response->errorResponse();
        }
    }
}
