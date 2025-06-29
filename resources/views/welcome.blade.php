<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido al Minimarket</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

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
            transition: transform 0.3s ease;
        }

        .credit-card:hover, .debit-card:hover {
            transform: scale(1.05);
        }

        .credit-card {
             background: linear-gradient(135deg, #2b2b2b, #4d4d4d);
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

        .card-footer-info {
            font-size: 0.75rem;
            margin-top: 1.5rem;
            opacity: 0.8;
        }

        .card-footer-info div {
            margin-bottom: 0.2rem;
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
        <div class="text-center mb-4">            
            @auth            
            <h1 class="display-4">¡Bienvenido a Mi Minimarket <i class="bi bi-cart"></i>!</h1>
            @endauth

            @auth
            @if(Auth::user()->tipo_usuario == 1)
                <div class="card-container">
                    <!-- Tarjeta de Débito -->
                    <div class="debit-card">
                        <div class="chip"></div>
                        <div class="title">Recarga débito</div>
                        <div class="amount">Total: S/. {{ number_format(Auth::user()->dinero_digital, 2) }}</div>
                        <div class="card-footer-info">
                            <div>**** **** **** ****</div>
                            <div>{{ Auth::user()->name }}</div>
                            <div>Exp: 12/28</div>
                        </div>
                    </div>

                    <!-- Tarjeta de Crédito -->
                    <div class="credit-card">
                        <div class="chip"></div>
                        <div class="title">Préstanos </div>
                        <div class="amount">Total: S/. {{ number_format(Auth::user()->dinero_credito, 2) }}</div>
                        <div class="card-footer-info">
                            <div>**** **** **** ****</div>
                            <div>{{ Auth::user()->name }}</div>
                            <div>Exp: 11/29</div>
                        </div>
                    </div>
                </div>
            @endif    
            @endauth

            <p class="text-muted mt-4">Ofertas, productos y mucho más al alcance de un clic.</p>
            <p class="text-muted small">Puedes usar tu dinero digital para realizar compras, solicitar préstamos o recargar en tiendas físicas.</p>
        </div>

        {{-- Mensaje de éxito --}}
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
                    <h2 class="mb-4"><i class="bi bi-tools"></i> Mantenimiento</h2>
                    <div class="d-flex flex-column gap-3">
                        @if(Auth::user()->tipo_usuario == 2)
                        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-lg w-100 d-flex justify-content-between align-items-center">
                            Mantenimiento Productos <i class="bi bi-box-seam"></i>
                        </a>
                        @endif
                        <a href="{{ route('actualizar.edit') }}" class="btn btn-secondary btn-lg w-100 d-flex justify-content-between align-items-center">
                            Actualizar tus datos <i class="bi bi-pencil-square"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Columna 2: Transacciones --}}
            <div class="col-md-6 mb-4">
                <div class="p-4 bg-white shadow rounded">
                    <h2 class="mb-4"><i class="bi bi-credit-card"></i> Transacciones</h2>
                    <div class="d-flex flex-column gap-3">
                        @if(Auth::user()->tipo_usuario == 1)
                            <a href="{{ route('products.comprar') }}" class="btn btn-success btn-lg w-100 d-flex justify-content-between align-items-center">
                                Comprar Productos <i class="bi bi-cart-check"></i>
                            </a>
                            <a href="{{ route('cart.index') }}" class="btn btn-success btn-lg w-100 d-flex justify-content-between align-items-center">
                                Ver Carrito <i class="bi bi-basket"></i>
                            </a>
                            <a href="{{ route('prestamo.index') }}" class="btn btn-success btn-lg w-100 d-flex justify-content-between align-items-center">
                                Pedir Préstamo Manual <i class="bi bi-cash-coin"></i>
                            </a>
                            <a href="{{ route('prestamo.indexautomatico') }}" class="btn btn-success btn-lg w-100 d-flex justify-content-between align-items-center">
                                Préstamo Automático <i class="bi bi-robot"></i>
                            </a>
                            <a href="#" class="btn btn-success btn-lg w-100 d-flex justify-content-between align-items-center">
                                Ver compras <i class="bi bi-robot"></i>
                            </a>

                        @endif
                        @if(Auth::user()->tipo_usuario == 2)
                            <a href="{{ route('prestamo.tramitar') }}" class="btn btn-success btn-lg w-100 d-flex justify-content-between align-items-center">
                                Evaluar Préstamo (Solo Manuales) <i class="bi bi-clipboard-check"></i>
                            </a>
                            <a href="{{ route('recarga.form') }}" class="btn btn-success btn-lg w-100 d-flex justify-content-between align-items-center">
                                Recargar Saldo <i class="bi bi-wallet2"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
