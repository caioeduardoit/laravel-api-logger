<?php

namespace App\Models\Swagger;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Log",
 *     type="object",
 *     title="Log",
 *     description="Representa um log de requisição",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="ip", type="string", example="192.168.0.1"),
 *     @OA\Property(property="method", type="string", example="POST"),
 *     @OA\Property(property="route", type="string", example="/api/clientes"),
 *     @OA\Property(property="payload", type="object", example={"nome": "Fulano"}),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-04T10:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-04T10:05:00Z"),
 * )
 */
class Log extends Model
{
    use HasFactory;
}
