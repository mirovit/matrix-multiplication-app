<?php


namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\ArrayShape;

abstract class Response extends JsonResponse
{
    #[ArrayShape(['status' => "string", 'data' => "array|string"])]
    public function getSuccessBody(string|array $data): array
    {
        return [
            'status' => 'success',
            'data' => $data
        ];
    }

    #[ArrayShape(['status' => "string", 'error_code' => "string", 'errors' => "array|string"])]
    public function getErrorBody(
        string|array $errors,
        string $errorCode
    ): array {
        return [
            'status' => 'error',
            'error_code' => $errorCode,
            'errors' => $errors
        ];
    }
}
