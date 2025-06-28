<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    {{-- Botón Cerrar sesión solo si está autenticado --}}
        @auth
        <div class="d-flex justify-content-end mb-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Cerrar sesión</button>
            </form>
        </div>
    @endauth
    <h1>Lista de Productos</h1>

    <div class="d-flex justify-content-between mb-3">
    <a href="{{ route('products.create') }}" class="btn btn-success">Agregar Nuevo Producto</a>
 
</div>
   @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    @endif

    @if($products->isEmpty())
        <div class="alert alert-info">No hay productos registrados.</div>
    @else   
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Moneda</th>
                    <th>Stock</th>
                    <th>Fecha de ingreso</th>
     
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description ?? '-' }}</td>
                    <td>{{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->currency }}</td>
                    <td>{{ $product->stock }}</td>
                   <td>{{ \Carbon\Carbon::parse($product->entry_date)->format('d/m/Y H:i') }}</td>
                

                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<div class="container mt-4 text-start">
    <a href="{{ url('/') }}" class="btn btn-secondary">← Volver al inicio</a>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>
