<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido al Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-3">

        {{-- Botón Cerrar sesión solo si está autenticado --}}
        @auth
        <div class="d-flex justify-content-end mb-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Cerrar sesión</button>
            </form>
        </div>
        @endauth

        {{-- Texto de bienvenida --}}
        <div class="text-center mb-5">            
            @auth            
            <h1 class="display-4">¡Bienvenido  {{ Auth::user()->name }} a Mi Minimarket 🛒!</h1>
            @endauth
            <p class="lead">Ofertas, productos y mucho más al alcance de un clic.</p>

            <p class="lead">Usted tiene actualmente <strong>S./ {{ Auth::user()->dinero_digital }}</strong> en su cuenta digital</p>


            <p class="lead">Para realizar compras en nuestro Minimarket es necesario usar dinero digital por nuestros prestamos o recargar en tiendas físicas de forma presencial </p>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        {{-- División vertical en dos columnas --}}
        <div class="row">
            {{-- Columna 1: Mantenimiento --}}
            <div class="col-md-6 mb-4">
                <div class="p-4 bg-white shadow rounded">
                    <h2 class="mb-4">🔧 Mantenimiento</h2>
                     <div class="d-flex flex-column gap-3">
                    @if(Auth::user()->tipo_usuario == 2)
                    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-lg w-100">Ver Productos</a>
                    @endif
            
                    <a href="{{ route('actualizar.edit') }}" class="btn btn-secondary btn-lg w-100">Actualizar tus datos</a>
                     </div>
                </div>
            </div>

            {{-- Columna 2: Transacciones --}}
            <div class="col-md-6 mb-4">
                <div class="p-4 bg-white shadow rounded">
                    <h2 class="mb-4">💳 Transacciones</h2>
                    <div class="d-flex flex-column gap-3">
                    @if(Auth::user()->tipo_usuario == 1)
                        <a href="{{ route('products.comprar') }}" class="btn btn-success btn-lg">Comprar Productos</a>
                        <a href="{{ route('cart.show') }}" class="btn btn-success btn-lg">Ver Carrito</a>
                         <a href="{{ route('prestamo.index') }}" class="btn btn-success btn-lg">Pedir Prestamo</a>
                     @endif
                     @if(Auth::user()->tipo_usuario == 2)
                          <a href="{{ route('prestamo.tramitar') }}" class="btn btn-success btn-lg">Evaluar Préstamo</a>
                     @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
