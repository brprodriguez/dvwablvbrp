<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitar Préstamo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="mb-4 text-center">Formulario de Préstamo</h2>

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

        <!--form method="POST" action="{{ route('prestamo.store') }}"-->
        <form method="POST" action="{{ route('prestamo.simular') }}">
            @csrf
            <div class="mb-3">
                <strong class="form-label"> Restricciones para realizar un prestamo</strong><br>

                <strong class="form-label"> - Mi Minimarket solo ofrece prestamos de S./ 50, S./ 100, S./ 300, S./ 500  </strong><br>
                <strong class="form-label"> - Mi Minimarket solo permite cuotas de 6, 12 y 18 meses  </strong><br>
                <strong class="form-label"> - La tasa de interes es calculada automática por nuestro sistema</strong><br>
                <strong class="form-label"> - Mi Minimarket utiliza la fecha de solicitud para simular el prestamo</strong><br>
                <strong class="form-label"> - Solo un Administrador de Mi Minimarket puede aprobar o rechazar una solicitud de prestamo</strong><br>
            </div>
            <div class="mb-3">
                <label for="monto" class="form-label">Monto del Préstamo (S/)</label>
                <select name="monto" id="monto" class="form-select" required>
                    <option value="">Seleccione un monto</option>
                    <option value="50">S/ 50</option>
                    <option value="100">S/ 100</option>
                    <option value="300">S/ 300</option>
                    <option value="500">S/ 500</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="plazo" class="form-label">Número de cuotas</label>
                <select name="plazo" id="plazo" class="form-select" required>
                    <option value="">Seleccione cuotas</option>
                    <option value="6">6 meses</option>
                    <option value="12">12 meses</option>
                    <option value="18">18 meses</option>                    
                </select>
            </div>

            <!-- Fecha de inicio oculta -->
            <input type="hidden" name="fecha_inicio" value="{{ now()->toDateString() }}">
            <input type="hidden" name="perfil_riesgo" value="XX"> 

            <button type="submit" class="btn btn-primary w-100">Simular Préstamo</button>
        </form>

</body>
</html>
