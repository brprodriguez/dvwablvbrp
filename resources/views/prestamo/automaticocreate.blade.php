<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitar Préstamo Automático</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="mb-4 text-center">Formulario de Préstamo Automático</h2>

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
        <form method="POST" action="{{ route('prestamo.simularAutomatico') }}">
            @csrf
            <div class="mb-3">
                <strong class="form-label"> Restricciones para realizar un Prestamo Automático </strong><br>

                <strong class="form-label"> - Mi Minimarket ofrece Prestamos Automatico de S./ 1000, S./ 1500 y S./2000  </strong><br>
                <strong class="form-label"> - Mi Minimarket solo permite cuotas de 24 y 48 cuotas </strong><br>
                <strong class="form-label"> - La tasa de interes es calculada automática por nuestro sistema</strong><br>
                <strong class="form-label"> - Mi Minimarket utiliza la fecha de solicitud para simular el prestamo</strong><br>
                <strong class="form-label"> - Los prestamos automático se aprueban automaticamente dentro de 15 minutos y no necesita aprobación de un administrador.</strong><br>
                <strong class="form-label"> - Es necesario que confirme los terminos y condiciones.</strong><br>
            </div>
            <div class="mb-3">
                <label for="monto" class="form-label">Monto del Préstamo (S/)</label>
                <select name="monto" id="monto" class="form-select" required>
                    <option value="">Seleccione un monto</option>
                    <option value="1000">S/ 1000</option>
                    <option value="1500">S/ 1500</option>
                    <option value="2000">S/ 2000</option>                    
                </select>
            </div>

            <div class="mb-3">
                <label for="plazo" class="form-label">Número de cuotas</label>
                <select name="plazo" id="plazo" class="form-select" required>
                    <option value="">Seleccione cuotas</option>
                    <option value="24">24 meses</option>
                    <option value="48">48 meses</option>                    
                </select>
            </div>

            <!-- Fecha de inicio oculta -->
            <input type="hidden" name="fecha_inicio" value="{{ now()->toDateString() }}">
            <input type="hidden" name="perfil_riesgo" value="XX"> 
            <input type="hidden" name="termsycond" value="true"> 
            <button type="submit" class="btn btn-primary w-100">Simular Préstamo</button>
        </form>

</body>
</html>
