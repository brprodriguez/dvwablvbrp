<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Evaluar Préstamo</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" >
        <h2 class="mb-4 text-center"> Lista de Préstamo Solicitados</h2>

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



    @if($prestamos->isEmpty())
        <p>No hay préstamos registrados por los clientes</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Monto</th>
                    <th>Plazo (meses)</th>
                    <th>Fecha de solicitud</th>
                    <!--th>Fecha de inicio</th-->
                    <!--th>Perfil de riesgo</th-->
                    <th>Estado de Prestamo</th>
                    <th>Acciones</th> <!-- Columna para los botones -->

                </tr>
            </thead>
            <tbody>
                @foreach($prestamos as $prestamo)
                <tr>
                    <td>{{ $prestamo->user->name }}</td> <!-- Aquí accedes al nombre -->

                    <td>S/ {{ number_format($prestamo->monto, 2) }}</td>
                    <td>{{ $prestamo->plazo }}</td>
                    <td>{{ $prestamo->created_at->format('d/m/Y') }}</td>
                    <!--td>{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td-->
                    <!--td>{{ ucfirst($prestamo->perfil_riesgo) }}</td-->
                    <td>{{ $prestamo->estado }}</td>
                     
                     <td>
                            <form action="{{ route('prestamo.aprobar', $prestamo->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('PATCH')
                                <button 
                                    class="btn btn-success btn-sm" 
                                    title="Aprobar" 
                                    onclick="return confirm('¿Aprobar este préstamo?')"
                                    {{ $prestamo->estado !== 'Solicitado' ? 'disabled' : '' }}
                                >
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>

                            <form action="{{ route('prestamo.rechazar', $prestamo->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('PATCH')
                                <button 
                                    class="btn btn-danger btn-sm" 
                                    title="Rechazar" 
                                    onclick="return confirm('¿Rechazar este préstamo?')"
                                    {{ $prestamo->estado !== 'Solicitado' ? 'disabled' : '' }}
                                >
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif


     
    </div>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
