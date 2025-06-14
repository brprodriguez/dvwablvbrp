<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitar Préstamo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
    <div class="container mt-4">
    <h3>Simulación de Préstamo</h3>
    <p><strong>Monto:</strong> S/ {{ $monto }}</p>
    <p><strong>Plazo:</strong> {{ $plazo }} meses</p>
    <p><strong>Cuota mensual:</strong> S/ {{ $cuotaMensual }}</p>
    <div class="d-flex align-items-center justify-content-between">
    <p class="mb-0">
        <strong>Tasa de interés anual:</strong> {{ $tasaAnual *100 }}%
    </p>

        <form method="POST" action="{{ route('prestamoautomatico.store') }}" class="mb-0">
            @csrf
            <input type="hidden" name="monto" value="{{ $monto }}">
            <input type="hidden" name="plazo" value="{{ $plazo }}">
            <input type="hidden" name="fecha_inicio" value="{{ now()->toDateString() }}">
            <input type="hidden" name="perfil_riesgo" value="XX"> 
            <input type="hidden" name="termsycond" value="true"> 
            
            <button type="submit" class="btn btn-primary">Solicitar Préstamo</button>
        </form>
    </div>

    <table class="table table-bordered mt-4">
        <thead>
             <tr>
                <th>Cuota</th>
                <th>Fecha</th>
                <th>Cuota Total</th>
                <th>Interés</th>
                <th>Amortización</th>
                <th>Saldo Restante</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cronograma as $cuota)
                <tr>
                    <td>{{ $cuota['nro_cuota'] }}</td>
                    <td>{{ $cuota['fecha_pago'] }}</td>
                    <td>S/ {{ number_format($cuota['monto'], 2) }}</td>
                    <td>S/ {{ number_format($cuota['interes'], 2) }}</td>
                    <td>S/ {{ number_format($cuota['amortizacion'], 2) }}</td>
                    <td>S/ {{ number_format($cuota['saldo_restante'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
