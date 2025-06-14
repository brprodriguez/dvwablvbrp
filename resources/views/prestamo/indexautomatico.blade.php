<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitar Préstamo Automático</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" >
        <h2 class="mb-4 text-center"> Lista de Préstamo Automatico </h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

<a href="{{ route('prestamoautomatico.create') }}" class="btn btn-primary mb-3">➕ Nuevo Préstamo</a>

    @if(empty($prestamos))
        <p>No tienes préstamos registrados.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Monto</th>
                    <th>Plazo (meses)</th>
                    <th>Fecha de solicitud</th>
                    <!--th>Fecha de inicio</th-->
                    <!--th>Perfil de riesgo</th-->
                    <th>Estado de Prestamo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prestamos as $prestamo)
                <tr>
                    <td>S/ {{ number_format($prestamo->monto, 2) }}</td>
                    <td>{{ $prestamo->plazo }}</td>
                    <td>{{ $prestamo->created_at->format('d/m/Y') }}</td>
                    <!--td>{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td-->
                    <!--td>{{ ucfirst($prestamo->perfil_riesgo) }}</td-->
                    <td>{{ $prestamo->estado }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif


     
    </div>
</body>
</html>
