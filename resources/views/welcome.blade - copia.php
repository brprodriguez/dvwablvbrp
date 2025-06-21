<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido al Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            justify-content: center;
            margin-top: 3rem;
        }

        .credit-card, .debit-card {
            color: white;
            padding: 1.5rem 2rem;
            border-radius: 1rem;
            width: 320px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
        }

        .credit-card {
            background: linear-gradient(135deg, #8e44ad, #9b59b6);
        }

        .debit-card {
            background: linear-gradient(135deg, #2c3e50, #3498db);
        }

        .title {
            font-size: 0.9rem;
            text-transform: uppercase;
            margin-bottom: 1rem;
            letter-spacing: 1px;
            opacity: 0.9;
        }

        .amount {
            font-size: 1.6rem;
            font-weight: 600;
        }

        .chip {
            width: 40px;
            height: 30px;
            background: linear-gradient(to right, #bdc3c7, #ecf0f1);
            border-radius: 6px;
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
        }
    </style>
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
            <h1 class="display-4">¡Bienvenido a Mi Minimarket 🛒!</h1>
            @endauth

           @auth
                <div class="card-container">
                    <!-- Tarjeta de Débito -->
                    <div class="debit-card">
                        <div class="chip"></div>
                        <div class="title">Tarjeta de Débito</div>
                        <div class="amount">S/. {{ number_format(Auth::user()->dinero_digital, 2) }}</div>
                    </div>

                    <!-- Tarjeta de Crédito -->
                    <div class="credit-card">
                        <div class="chip"></div>
                        <div class="title">Tarjeta de Crédito</div>
                        <div class="amount">S/. {{ number_format(Auth::user()->dinero_digital, 2) }}</div>
                    </div>
                </div>
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
                         <a href="{{ route('prestamo.index') }}" class="btn btn-success btn-lg">Pedir Préstamo Manual</a>
                              <a href="{{ route('prestamo.indexautomatico') }}" class="btn btn-success btn-lg">Pedir Préstamo Automático</a>
                     @endif
                     @if(Auth::user()->tipo_usuario == 2)
                          <a href="{{ route('prestamo.tramitar') }}" class="btn btn-success btn-lg">Evaluar Préstamo</a>
                          <a href="{{ route('recarga.form') }}" class="btn btn-success btn-lg">Recargar Saldo</a>
                     @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
