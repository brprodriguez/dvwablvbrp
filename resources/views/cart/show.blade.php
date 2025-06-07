<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <h1>🛒 Carrito de Compras</h1>
    @if(!empty($rates))
    <div class="alert alert-secondary">
        <h5 class="mb-2">💱 Tipos de Cambio</h5>
        <ul class="mb-0">
            @foreach($rates as $moneda => $tipoCambio)
                <li>1 {{ strtoupper($moneda) }} = {{ number_format($tipoCambio, 2) }} S/.</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if(empty($cart) || count($cart) === 0)
        <div class="alert alert-info">Tu carrito está vacío.</div>
    @else
         <!-- Botón Limpiar carrito -->
        <div class="d-flex justify-content-end mb-3">
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Limpiar carrito</button>
            </form>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    
                    <th>Subtotal (Moneda)</th>
                    
                    <th>Subtotal (S/.)</th> <!-- nuevo -->
                </tr>
            </thead>
            <tbody>
                @php 
                    $total = 0; 
                    $totalSol = 0; // ← Esto es necesario para evitar "undefined variable"
                @endphp
                @foreach($cart as $item)
                    @php
                        
                        $subtotal = $item['price'] * $item['quantity'];
                        $rate = $rates[$item['currency']] ?? 1.0;
                        $subtotalSol = $subtotal * $rate;
                        $totalSol += $subtotalSol;
                    @endphp
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ number_format($item['price'], 2) }}</td>
                        
                        <td>{{ number_format($subtotal, 2) }} {{ $item['currency'] }}</td>
                        <td>{{ number_format($subtotalSol, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end"><strong>Total (S/.):</strong></td>
                    <td><strong>{{ number_format($totalSol, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>        
        

    @endif

    <div class="mt-4 d-flex justify-content-between align-items-center">
        <a href="{{ route('products.comprar') }}" class="btn btn-secondary">← Volver a Comprar productos</a>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#checkoutModal">
            Comprar
        </button>
    </div>
    
   </div>
   <div class="container mt-4 text-start">
    <a href="{{ url('/') }}" class="btn btn-secondary">← Volver al inicio</a>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Modal de Checkout -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('cart.checkout') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="checkoutModalLabel">Resumen de compra</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <h6>Productos en el carrito:</h6>
        <ul>
          @foreach($cart as $item)
            <li>{{ $item['quantity'] }} x {{ $item['name'] }} - S/. {{ number_format($item['price'] * $rates[$item['currency']] * $item['quantity'], 2) }}</li>
          @endforeach
        </ul>
        <hr>
        <p><strong>Total (S/.): {{ number_format($totalSol, 2) }}</strong></p>

        <h6>Datos para la compra:</h6>
        <div class="mb-3 row">
          <div class="col">
            <label for="name" class="form-label">Nombre completo</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="col">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
        </div>          

        <div class="mb-3">
          <label for="direccion" class="form-label">Dirección</label>
          <input type="direccion" class="form-control" id="direccion" name="direccion" required>
        </div>

        <div class="mb-3">
          <label for="tarjeta" class="form-label">Tarjeta</label>
          <input type="tarjeta" class="form-control" id="tarjeta" name="tarjeta" required>
        </div>

       <div class="mb-3 row">
          <div class="col">
            <label for="fecha_expiracion" class="form-label">Fecha Expiración</label>
            <input type="text" class="form-control" id="fecha_expiracion" name="fecha_expiracion" required>
          </div>
          <div class="col" style="max-width: 150px;">
            <label for="cvv" class="form-label">CVV</label>
            <input type="text" class="form-control" id="cvv" name="cvv" required>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Confirmar compra</button>
      </div>
    </form>
  </div>
</div>

</body>
</html>
