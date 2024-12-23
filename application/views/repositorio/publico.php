<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos Públicos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f3ef;
            font-family: 'Arial', sans-serif;
        }
        .header {
            background: linear-gradient(60deg, #26c6da, #00acc1);
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .table th {
            color: #555;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="container mt-4">
        <div class="header">
            <h2 class="text-center">Cursos y Documentos Públicos</h2>
            <p class="text-center">Aquí puedes ver los cursos y documentos compartidos por otros usuarios.</p>
        </div>

        <!-- Tabla de Cursos Públicos -->
        <?php if (!empty($cursos)): ?>
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha de Creación</th>
                        <th>Documentos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $contador = 1; ?>
                    <?php foreach ($cursos as $curso): ?>
                        <tr>
                            <td><?php echo $contador++; ?></td>
                            <td><?php echo htmlspecialchars($curso->nombre); ?></td>
                            <td><?php echo htmlspecialchars($curso->descripcion); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($curso->fecha_creacion)); ?></td>
                            <td>
                                <!-- Enlace para Ver Documentos -->
                                <a href="<?php echo site_url('repositorio/ver_documentos/' . $curso->id); ?>" class="btn btn-sm btn-view">
                                    <i class="fas fa-file-alt"></i> Ver Documentos
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                No hay cursos o documentos públicos disponibles en este momento.
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
