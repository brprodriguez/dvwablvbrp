<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 500px;">
    <div class="text-center mb-5">
            <h1 class="display-4">¡Bienvenido a Mi Minimarket 🛒!</h1>
            <p class="lead">Ofertas, productos y mucho más al alcance de un clic.</p>
        </div>
    <h2 class="mb-4">Registro de Usuario</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf        
        <div class="mb-3">
            <label for="name" class="form-label">Nombre completo</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required autofocus>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
            <select name="tipo_usuario" id="tipo_usuario" class="form-control" required>
                <option value="">Seleccione un tipo</option>
                <option value="1" {{ old('tipo_usuario') == '1' ? 'selected' : '' }}>Cliente</option>
                <option value="2" {{ old('tipo_usuario') == '2' ? 'selected' : '' }}>Administrador</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
    </form>

    <div class="mt-3 text-center">
        <a href="{{ route('login.form') }}">¿Ya tienes cuenta? Inicia sesión</a>
    </div>
</div>
</body>
</html>
