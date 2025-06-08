<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Actualizar datos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 500px;">
    <div class="text-center mb-5">
            <h1 class="display-4">¡Bienvenido a Mi Minimarket 🛒!</h1>
            <p class="lead">Ofertas, productos y mucho más al alcance de un clic.</p>
        </div>
    <h2 class="mb-4">Actualizar datos</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('actualizar.update') }}" method="POST">
    @csrf
    @method('PATCH')

    {{-- Mostrar el nombre pero deshabilitado --}}
    <div class="mb-3">
        <label for="name" class="form-label">Nombre completo</label>
        <input type="text" id="name" class="form-control" value="{{ Auth::user()->name }}" disabled>
    </div>

    {{-- Editar correo --}}
    <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
    </div>

    {{-- Mostrar tipo de usuario pero deshabilitado --}}
    <div class="mb-3">
        <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
        <input type="text" id="tipo_usuario" class="form-control"
               value="{{ Auth::user()->tipo_usuario == 1 ? 'Cliente' : 'Administrador' }}" disabled>
    </div>

    {{-- Cambiar contraseña opcionalmente --}}
    <div class="mb-3">
        <label for="password" class="form-label">Nueva contraseña (opcional)</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmar nueva contraseña</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary w-100">Actualizar Datos</button>
</form>
    
</div>
</body>
</html>
