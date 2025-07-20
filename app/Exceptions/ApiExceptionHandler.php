<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class ApiExceptionHandler
{
    public function __invoke(Request $request, Throwable $e): JsonResponse
    {
        if ($e instanceof ValidationException) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }

        if ($e instanceof HttpExceptionInterface) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'HTTP error',
            ], $e->getStatusCode());
        }

        if ($e instanceof StateConflictException) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'HTTP error',
            ], $e->getCode());
        }

        // Generic fallback
        return response()->json([
            'status' => 'error',
            'message' => sprintf('Message: %s; Trace: %s', $e->getMessage(), $e->getTraceAsString()),
        ], 500);
    }
}
