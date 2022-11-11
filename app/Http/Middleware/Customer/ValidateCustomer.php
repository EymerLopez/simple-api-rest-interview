<?php

namespace App\Http\Middleware\Customer;

use App\Libraries\ApiResponse;
use App\Models\Commune;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;

class ValidateCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, \Closure $next, $action)
    {
        switch ($action) {
            case 'create':
                $rules = [
                    'dni' => 'required|string|min:1|max:45|unique:App\Models\Customer,dni',
                    'id_com' => 'required|integer|min:1|exists:App\Models\Commune,id_com',
                    'email' => 'required|email|max:120|unique:App\Models\Customer,email',
                    'name' => 'required|string|min:2|max:45',
                    'last_name' => 'required|string|min:2|max:45',
                    'address' => 'nullable|string|min:2',
                ];

                $data = $request->only(['dni', 'id_com', 'email', 'name', 'last_name', 'address']);
                $validator = Validator::make($data, $rules);

                if ($validator->fails()) {
                    $response = new ApiResponse(422, $validator->errors(), 'Datos inválidos');

                    return $response->invalidResponse();
                }

                if (!$this->validateCommune($data['id_com'])) {
                    $response = new ApiResponse(422, 'Comuna es inválida', 'Datos inválidos');

                    return $response->invalidResponse();
                }
                break;

            case 'show':
            case 'destroy':
                $customer = Customer::active()
                ->where('dni', $request->route()[2]['dniOrEmail'])
                ->orWhere('email', $request->route()[2]['dniOrEmail'])
                ->first();

                if (!$customer) {
                    $response = new ApiResponse(404, null, 'Cliente no existe');

                    return $response->notFoundResponse();
                }
                break;

            default:
                $response = new ApiResponse(500, [], 'Action es inválido');

                return $response->errorResponse();
                break;
        }

        $response = $next($request);

        // Post-Middleware Action

        return $response;
    }

    private function validateCommune(int $id)
    {
        $commune = Commune::find($id);
        if ($commune->status != 'A') {
            return false;
        }

        $region = $commune->region;
        if (!$region) {
            return false;
        }

        if ($region->status != 'A') {
            return false;
        }

        return true;
    }
}
