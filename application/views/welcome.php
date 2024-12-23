<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <!-- Agregar estilos Bootstrap opcionalmente -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5 text-center">
        <h2>¡Bienvenido, <?= $username ?>!</h2>
        <p>Has iniciado sesión correctamente.</p>

        <!-- Botón para redirigir a la página principal -->
        

        <a href="http://20.110.94.55/mi_proyecto/index.php/repositorio" class="btn btn-primary">
            Ir a la Página Principal
        </a>



        <!-- Opción para cerrar sesión -->
        <a href="<?= site_url('auth/logout') ?>" class="btn btn-danger ml-2">
            Cerrar sesión
        </a>
    </div>
</body>
</html>
