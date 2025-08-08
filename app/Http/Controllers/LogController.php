<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;

class LogController extends Controller
{
    // lista os logs com paginação simples
    public function index()
    {
        $logs = Log::orderBy('created_at', 'desc')->paginate(10);

        return response()->json($logs);
    }

    // Cria um novo log
    public function store(Request $request)
    {
        $data = $request->validate([
            'ip' => 'nullable|ip',
            'method' => 'nullable|string|max:10',
            'route' => 'nullable|string|max:255',
            'payload' => 'nullable|array',
        ]);

        $log = Log::create($data);

        return response()->json($log, 201);
    }

    // Mostrar página com logs paginados
    public function showLogsPage()
    {
        $logs = Log::orderBy('created_at', 'desc')->paginate(10);

        return view('logs.index', compact('logs'));
    }

    // Cria log a partir do formulário web
    public function storeFromWeb(Request $request)
    {
        $data = $request->validate([
            'ip' => 'nullable|ip',
            'method' => 'nullable|string|max:10',
            'route' => 'nullable|string|max:255',
            'payload' => 'nullable|string' // Aqui o payload será texto simples no formulário
        ]);

        Log::create($data);

        return redirect('/logs')->with('success', ' Log criado com sucesso!');
    }

    public function show($id)
    {
        $log = Log::findOrFail($id);

        return view('logs.show', compact('log'));
    }
}
