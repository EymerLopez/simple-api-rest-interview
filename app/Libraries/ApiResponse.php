<?php

namespace App\Libraries;

class ApiResponse
{
    private $data;
    private $message;
    private $statusCode;

    public function __construct(int $statusCode, $data = null, string $message = null)
    {
        $this->data = $data;
        $this->statusCode = $statusCode;
        $this->message = $message;
    }

    public function response()
    {
        $body = $this->body();
        if ($this->data) {
            $body['data'] = $this->data;
        }

        return response()->json($body, $this->statusCode);
    }

    public function successResponse()
    {
        $body = $this->body();
        if (!is_null($this->data)) {
            $body['data'] = $this->data;
        }

        return response()->json($body, 200);
    }

    public function badResponse()
    {
        $body = $this->body();
        if (!is_null($this->data)) {
            $body['error'] = $this->data;
        }

        return response()->json($body, 400);
    }

    public function invalidResponse()
    {
        $body = $this->body();
        if (!is_null($this->data)) {
            $body['errors'] = $this->data;
        }

        return response()->json($body, 422);
    }

    public function errorResponse(bool $isProduction = true)
    {
        $body = $this->body();
        if (!is_null($this->data)) {
            $body['error'] = $this->data;
        }
        if ($isProduction) {
            $body['message'] = '¡Ocurrió un error interno!';
        }

        return response()->json($body, 500);
    }

    public function unauthorizedResponse()
    {
        $body = $this->body();

        return response()->json($body, 401);
    }

    public function notFoundResponse()
    {
        $body = $this->body();

        return response()->json($body, 404);
    }

    private function body(): array
    {
        return [
            'success' => $this->getStatus(),
            'message' => $this->message,
        ];
    }

    private function getStatus()
    {
        if ($this->statusCode >= 200 && $this->statusCode <= 299) {
            return true;
        } else {
            return false;
        }
    }

    // setters
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    // getters
    public function getMessage()
    {
        return $this->message;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
