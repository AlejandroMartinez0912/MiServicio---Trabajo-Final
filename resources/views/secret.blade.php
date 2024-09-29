<!DOCTYPE html>
<html lang="es"> <head>
    <title>Página Privada</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">

</head>
<body>
    <div class="container">
        <header class="d-flex flex-wrap align-items-center justify-content-center py-3 mb-4 border-bottom">
            <a class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
                Página Privada
            </a>
            <div class="col-md-3 text-end">
                <a href="{{route('logout')}}"><button type="button" class="btn btn-outline-primary me-2">Salir</button></a>
            </div>
        </header>
        <article class="container">
            <h2>Tu pagina principal</h2>
        </article>
    </div>
</body>
</html>