<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registrar Producto</title>
    <!-- Bootstrap CDN -->
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
    <h1>Registrar Producto</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nombre del producto</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required />
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" id="description" rows="3" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ old('price') }}" required />
        </div>

        <div class="mb-3">
            <label for="currency" class="form-label">Tipo de moneda (ej: USD)</label>
            <input type="text" name="currency" id="currency" class="form-control" value="{{ old('currency') }}" maxlength="3" required />
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock') }}" required />
        </div>

        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>
</body>
</html>
