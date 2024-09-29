<!DOCTYPE html>
<html lang="es">
<head>
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">

</head>
<body>
    <main class="container align-center p-5">
        <form method="POST" action="{{route('inicia-sesion')}}">
            @csrf
            <div class="mb-3">
                <label for="emailInput" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="emailInput" name="email" required>
            </div>
            <div class="mb-3">
                <label for="passwordInput" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="passwordInput" name="password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="rememberCheck" name="remember">
                <label class="form-check-label" for="rememberCheck">Mantener sesión iniciada</label>
            </div>
            <div>
                <p>¿No tienes cuenta? <a href="{{route('registro')}}">Regístrate</a></p>
            </div>
            <button type="submit" class="btn btn-primary">Acceder</button>
        </form>
    </main>
</body>
</html>