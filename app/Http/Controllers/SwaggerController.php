<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="Mini Logger Web para APIs",
 *         version="1.0.0",
 *         description="API para registro e visualização de logs de requisições de APIs."
 *     ),
 *     @OA\Server(
 *         url=L5_SWAGGER_CONST_HOST,
 *         description="API Server"
 *     )
 * )
 */
class SwaggerController extends Controller
{
    //
}
