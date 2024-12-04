<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            width: 120px;
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
            width: 700px;
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
            width: 100%;
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

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .col-md-6 {
            flex: 0 0 48%;
            max-width: 48%;
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
            width: 100%;
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
    <!-- Vista de Registro -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="login-box">
                    <div class="login-header">
                        <img src="{{ asset('Images/logo.png') }}" alt="MiServicio">
                    </div>
                    <h3>Registrarse</h3>
                    <!-- Formulario de registro -->
                    <form id="registrationForm" method="POST" action="{{ route('validar-registro') }}">
                        @csrf
                        <div class="row">
                            <!-- Datos personales -->
                            <div class="col-md-6">
                                <div class="user-box">
                                    <label for="emailRegister">Correo electrónico</label>
                                    <input type="email" class="form-control" id="emailRegister" name="email" required placeholder="Ingresa tu correo">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="user-box">
                                    <label for="passwordRegister">Contraseña</label>
                                    <input type="password" class="form-control" id="passwordRegister" name="password" required placeholder="Crea una contraseña">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="user-box">
                                    <label for="nombreRegister">Nombre</label>
                                    <input type="text" class="form-control" id="nombreRegister" name="nombre" required placeholder="Ingresa tu nombre">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="user-box">
                                    <label for="apellidoRegister">Apellido</label>
                                    <input type="text" class="form-control" id="apellidoRegister" name="apellido" required placeholder="Ingresa tu apellido">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="user-box">
                                    <label for="documentoRegister">Documento</label>
                                    <input type="number" class="form-control" id="documentoRegister" name="documento" required placeholder="Ingresa tu documento">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="user-box">
                                    <label for="telefonoRegister">Teléfono</label>
                                    <input type="text" class="form-control" id="telefonoRegister" name="telefono" required placeholder="Ingresa tu teléfono">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="user-box">
                                    <label for="domicilioRegister">Domicilio</label>
                                    <input type="text" class="form-control" id="domicilioRegister" name="domicilio" required placeholder="Ingresa tu domicilio">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="user-box">
                                    <label for="fechaNacimientoRegister">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" id="fechaNacimientoRegister" name="fecha_nacimiento" required>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit">Registrarse</button>
                    </form>

                    <p class="mt-3 text-center">¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
                </div>
            </div>
        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
