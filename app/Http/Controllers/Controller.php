<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Hire Test API",
 *     description="API documentation for the Hire Test Laravel project"
 * )
 */
abstract class Controller
{
    /**
     * @param \Closure $closure
     * @return JsonResponse
     * @throws \Throwable
     */
    protected function callService(\Closure $closure): JsonResponse
    {
        DB::beginTransaction();

        try {
            $result = $closure();

            DB::commit();

            if ($result instanceof JsonResource || $result instanceof AnonymousResourceCollection) {
                return response()->json($result->toResponse(request())->getData(true));
            }

            return response()->json(['status' => 'success', 'data' => $result]);
        } catch (\Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
