<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recargar Saldo</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />


</head>
<body class="p-5">



    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    @endif
    <div class="container">

  <div class="row justify-content-center">
    <div class="col-md-4">
        <h2>Recargar Saldo</h2>
        <form action="{{ route('recarga.procesar') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="usuario_id" class="form-label">Seleccionar usuario</label>
                <select id="usuario_id" name="usuario_id" class="form-select" style="width: 100%;"></select>
            </div>

            <div class="mb-3">
                <label for="monto" class="form-label">Monto a recargar</label>
                <input type="number" step="0.01" class="form-control" name="monto" id="monto" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ url('/') }}" class="btn btn-secondary">← Volver al inicio</a>
                <button type="submit" class="btn btn-primary">Recargar</button>
            </div>
        </form>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#usuario_id').select2({
            placeholder: 'Buscar usuario...',
            ajax: {
                url: '{{ route("usuarios.buscar") }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return { term: params.term };
                },
                processResults: function(data) {
                    return {
                        results: data.results
                    };
                }
            },
            minimumInputLength: 1
        });
    </script>
</body>
</html>
