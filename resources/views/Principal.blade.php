<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MiServicio| Iniciar Sesión</title>
    <link rel="stylesheet" href="css/estilo.css"> </head>

<body>
    <main>
        <div class="contenedorTodo">
            <div class="cajaTrasera">
                <div class="cajaTraseraLogin">
                    <h3>¿Ya tienes cuenta?</h3>
                    <p>Inicia sesión para entrar a MiServicio</p>
                    <button id="btnIniciarSesion">Iniciar Sesión</button>
                </div>

                <div class="cajaTraseraRegister">
                    <h3>¿Aún no tienes cuenta?</h3>
                    <p>Registrate para entrar a MiServicio</p>
                    <button id="btnRegistrar">Registrar</button>
                </div>
                <!-- Formularios de registro y login-->
                <div class="contenedorLoginRegister">
                    <!-- Login-->
                    <form action="" class="FormularioLogin">
                        <h2>Iniciar Sesión</h2>
                        <input type="text" placeholder="Correo Electrónico">
                        <input type="password" placeholder="Contraseña">
                        <button>Entrar</button>
                    </form>
                    <!-- Registro -->
                    <div class="form FormularioRegister">
                         <h2>Registrarse</h2>
                         <input type="text" placeholder="Nombre">
                         <input type="text" placeholder="Apellido">
                         <input type="text" placeholder="Correo Electrónico">
                         <input type="password" placeholder="Contraseña">
                        <button>Registrarse</button>
                    </div>

                </div>

            </div>
        </div>

    </main>
</body>
</html>