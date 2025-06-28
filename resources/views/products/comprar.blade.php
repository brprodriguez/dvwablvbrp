<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">  <!-- TODO: botón y tabla dentro del mismo container -->
    {{-- Botón Cerrar sesión solo si está autenticado --}}
        @auth
        <div class="d-flex justify-content-end mb-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Cerrar sesión</button>
            </form>
        </div>
    @endauth
    <h1>Comprar Productos</h1>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('cart.index') }}" class="btn btn-warning">
            Ver carrito 🛒
        </a>
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
        <div class="alert alert-info">Ingrese la cantidad de productos y luego agréguelo a su carrito.</div>   
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Moneda</th>
                    <th>Stock</th>
                    <th>Fecha de ingreso</th>
                    <th>Acción</th>
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
                    <td>
                        <form method="POST" action="{{ route('cart.add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="number" name="quantity" value="1" min="1" max="5" style="width: 60px;">
                            <button type="submit" class="btn btn-primary btn-sm">Agregar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>
<div class="container mt-4 text-start">
    <a href="{{ url('/') }}" class="btn btn-secondary">← Volver al inicio</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
