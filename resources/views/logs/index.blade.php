<!DOCTYPE html>
<html>

<head>
    <title>Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container py-4">

    <h1>Logs</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Formulário para criar log -->
    <form method="POST" action="/logs" class="mb-4">
        @csrf
        <div class="mb-3">
            <label for="ip" class="form-label">IP</label>
            <input type="text" name="ip" id="ip" class="form-control" value="{{ old('ip') }}">
        </div>
        <div class="mb-3">
            <label for="method" class="form-label">Método HTTP</label>
            <input type="text" name="method" id="method" class="form-control" value="{{ old('method') }}">
        </div>
        <div class="mb-3">
            <label for="route" class="form-label">Rota</label>
            <input type="text" name="route" id="route" class="form-control" value="{{ old('route') }}">
        </div>
        <div class="mb-3">
            <label for="payload" class="form-label">Payload (texto simples)</label>
            <textarea name="payload" id="payload" rows="3" class="form-control">{{ old('payload') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Criar Log</button>
    </form>

    <!-- Listagem de logs -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>IP</th>
                <th>Método</th>
                <th>Rota</th>
                <th>Payload</th>
                <th>Criado em</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->ip }}</td>
                    <td>{{ $log->method }}</td>
                    <td>{{ $log->route }}</td>
                    <td>
                        <td><pre>{{ is_array($log->payload) || is_object($log->payload) ? json_encode($log->payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $log->payload }}</pre></td>
                    </td>
                    <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginação -->
    {{ $logs->links() }}

</body>

</html>
