<!DOCTYPE html>
<html>

<head>
    <title>Detalhes do Log</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container py-4">
    <h1>Detalhes do Log #{{ $log->id }}</h1>

    <table class="table">
        <tr>
            <th>ID</th>
            <td>{{ $log->id }}</td>
        </tr>
        <tr>
            <th>IP</th>
            <td>{{ $log->ip }}</td>
        </tr>
        <tr>
            <th>Método</th>
            <td>{{ $log->method }}</td>
        </tr>
        <tr>
            <th>Rota</th>
            <td>{{ $log->route }}</td>
        </tr>
        <tr>
            <th>Payload</th>
            <td>
                <pre>{{ is_array($log->payload) || is_object($log->payload) ? json_encode($log->payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $log->payload }}</pre>
            </td>
        </tr>
        <tr>
            <th>Criado em</th>
            <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
        </tr>
    </table>

    <a href="{{ url('/logs') }}" class="btn btn-secondary">Voltar</a>
</body>

</html>
