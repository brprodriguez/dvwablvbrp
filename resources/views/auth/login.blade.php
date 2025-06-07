<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

 

<div class="container mt-5" style="max-width: 400px;">
    <div class="text-center mb-5">
            <h1 class="display-4">¡Bienvenido a Mi Minimarket 🛒!</h1>
            <p class="lead">Ofertas, productos y mucho más al alcance de un clic.</p>
        </div>
    <h2>Iniciar Sesión</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" id="email" name="email" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">Iniciar sesión</button>
    </form>
    <div class="mt-3 text-center">
        <p>¿No tienes una cuenta? <a href="{{ route('register.form') }}">Regístrese aquí</a></p>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
