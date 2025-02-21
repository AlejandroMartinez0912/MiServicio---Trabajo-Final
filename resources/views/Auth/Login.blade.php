<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiServicio | Login</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('Images/logo.png') }}" type="image/png">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>


    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

        * {
          font-family: "Montserrat", serif;
          margin: 0;
          padding: 0;
          box-sizing: border-box;
        }

        body {
            background: linear-gradient(to bottom, black, #333);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .login-header img {
            width: 150px;
            height: auto;
        }

        .login-header p {
            margin: 0;
            color: #fff;
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .login-box {
            width: 400px;
            padding: 40px;
            background: rgba(0, 0, 0, 0.9);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.6);
            border-radius: 10px;
        }

        .login-box p:first-child {
            margin: 0 0 30px;
            color: #fff;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .user-box {
            position: relative;
            margin-bottom: 20px;
        }
 

        .user-box input {
            border: 2px;
            width: 300px;
            height: 40px;
            margin-bottom: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            padding: 0 15px;
            background-color: #EEEEEE;
        }

        .user-box label {
            color: #fff;
            margin: 10px;
        }


        form a {
            display: inline-block;
            padding: 10px 20px;
            font-weight: bold;
            color: #fff;
            font-size: 16px;
            text-decoration: none;
            text-transform: uppercase;
            transition: .5s;
            margin-top: 40px;
            letter-spacing: 3px;
        }

        form a:hover {
            background: #fff;
            color: #272727;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            font-weight: bold;
            color: #fff;
            font-size: 16px;
            text-transform: uppercase;
            transition: .5s;
            margin-top: 40px;
            letter-spacing: 3px;
            cursor: pointer;
            background: linear-gradient(90deg, #ff00cc, #333399);
            animation: gradient 2s infinite alternate;
            border-radius: 5px;
            border: none;
        }

        p {
            color: #fff;
            text-align: center;
        }

        p a {
            color: #ff00cc;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        p a:hover {
            color: #ff66ff;
        }

        h3 {
            color: #fff;
            text-align: center;
            margin: 10px;
        }

        @keyframes gradient {
            0% { background-position: 0%; }
            100% { background-position: 100%; }
        }
    </style>
</head>
<body>
<div class="login-box">
    <div class="login-header">
        <img src="{{ asset('Images/logo.png') }}" alt="MiServicio">
    </div>
    <h3>Iniciar Sesión</h3>
    <form method="POST" action="{{ route('inicia-sesion') }}">
        @csrf
        <div class="user-box">
            <label><i class='bx bx-envelope'></i> Email</label>
            <input type="email" id="emailInput" name="email" value="{{ old('email') }}" required>

        </div>
        <div class="user-box">
            <label><i class='bx bx-lock-alt'></i> Contraseña</label>
            <input type="password" id="passwordInput" name="password" required>

        </div>
        <div class="user-box" alingn="center">
            <button type="submit" alingn="center">INICIAR SESIÓN</button>
        </div>
    </form>
    <p>¿No tienes una cuenta? <a href="{{ route('register') }}">¡Regístrate!</a></p>
</div>
    <!-- Script para alertas-->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'Aceptar'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'Aceptar'
                });
            @endif

            @if(session('info'))
                Swal.fire({
                    icon: 'info',
                    title: 'Información',
                    text: '{{ session('info') }}',
                    confirmButtonText: 'Aceptar'
                });
            @endif
        });
    </script>
</body>
   
</html>
