<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LogApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/logs",
     *     summary="Listar logs com filtros opcionais",
     *     tags={"Logs"},
     *     security={{"api_token":{}}},
     *     @OA\Parameter(name="ip", in="query", description="Filtrar por IP", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="method", in="query", description="Filtrar por método HTTP", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="route", in="query", description="Filtrar por rota", required=false, @OA\Schema(type="string")),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de logs",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Log")),
     *             @OA\Property(property="meta", type="object") 
     *         )
     *     ),
     *     @OA\Response(response=401, description="Token inválido ou ausente")
     * )
     */
    public function index(Request $request)
    {
        $query = Log::query();

        // filtros dinâmicos
        if ($request->filled('ip')) {
            $query->where('ip', 'like', '%' . $request->ip . '%');
        }

        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        if ($request->filled('route')) {
            $query->where('route', 'like', '%' . $request->route . '%');
        }

        if ($request->filled('payload')) {
            $query->where('payload', 'like', '%' . $request->payload . '%');
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(10);

        // busca logs ordenando pelo mais recente ao mais antigo, paginando 10 itens por página
        // $logs = Log::orderBy('created_at', 'desc')->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $logs
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/logs",
     *     summary="Criar um novo log",
     *     tags={"Logs"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"ip", "method", "route", "payload"},
     *             @OA\Property(property="ip", type="string", example="192.168.0.1"),
     *             @OA\Property(property="method", type="string", example="POST"),
     *             @OA\Property(property="route", type="string", example="/api/teste"),
     *             @OA\Property(property="payload", type="object", example={"foo":"bar"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Log criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Log")
     *     ),
     *     @OA\Response(response=422, description="Erro de validação"),
     *     @OA\Response(response=401, description="Token inválido ou ausente")
     * )
     */
    public function store(Request $request)
    {
        // Validação simples
        $validator = Validator::make($request->all(), [
            'ip' => 'required|ip',
            'method' => 'required|string|max:10',
            'route' => 'required|string|max:255',
            'payload' => 'nullable|array',  // ou string, depende de como vai armazenar
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro de valicação.',
                'errors' => $validator->errors()
            ], 422);
        }

        // cria o log
        $log = Log::create([
            'ip' => $request->input('ip'),
            'method' => $request->input('method'),
            'route' => $request->input('route'),
            'payload' => $request->input('payload'),
        ]);

        return response()->json([
            'message' => 'Log criado com sucesso!',
            'data' => $log
        ], 201);
    }

    public function export(Request $request)
    {
        $query = Log::query();

        // filtros dinâmicos
        if ($request->filled('ip')) {
            $query->where('ip', 'like', '%' . $request->ip . '%');
        }

        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        if ($request->filled('route')) {
            $query->where('route', 'like', '%' . $request->route . '%');
        }

        if ($request->filled('payload')) {
            $query->where('payload', 'like', '%' . $request->payload . '%');
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->get();

        $format = $request->query('format', 'csv');

        if ($format === 'csv') {
            $response = new StreamedResponse(function () use ($logs) {
                $handle = fopen('php://output', 'w');

                fputcsv($handle, ['id', 'ip', 'method', 'route', 'payload', 'created_at']);

                foreach ($logs as $log) {
                    fputcsv($handle, [
                        $log->id,
                        $log->ip,
                        $log->method,
                        $log->route,
                        is_array($log->payload) || is_object($log->payload) ? json_encode($log->payload, JSON_UNESCAPED_UNICODE) : $log->payload,
                        $log->created_at,
                    ]);
                }

                fclose($handle);
            });

            $response->headers->set('Content-Type', 'text/csv');
            $response->headers->set('Content-Disposition', 'attachment; filename="logs.csv"');

            return $response;
        }

        return response()->json($logs);
    }

    /**
     * @OA\Get(
     *     path="/api/logs/{id}",
     *     summary="Visualizar log específico",
     *     tags={"Logs"},
     *     security={{"api_token":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do log",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Log encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Log")
     *     ),
     *     @OA\Response(response=404, description="Log não encontrado"),
     *     @OA\Response(response=401, description="Token inválido ou ausente")
     * )
     */

    public function show($id)
    {
        $log = Log::find($id);

        if (!$log) {
            return response()->json([
                'error' => 'Log não encontrado',
            ], 404);
        }

        return response()->json($log);
    }
}
