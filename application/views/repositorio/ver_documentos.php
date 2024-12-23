<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos del Curso</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f3ef;
            font-family: 'Arial', sans-serif;
        }
        .header {
            background: linear-gradient(60deg, #4caf50, #43a047);
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .table th {
            color: #555;
        }
        .btn-download {
            background-color: #ff9800;
            color: #fff;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="container mt-4">
        <div class="header">
            <h2 class="text-center"><?= htmlspecialchars($curso->nombre); ?></h2>
            <p class="text-center"><?= htmlspecialchars($curso->descripcion); ?></p>
        </div>

        <!-- Tabla de Documentos del Curso -->
        <h3 class="mb-3">Documentos del Curso</h3>

        <?php if (!empty($documentos)): ?>
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre del Documento</th>
                        <th>Fecha de Subida</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($documentos as $index => $documento): ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= htmlspecialchars($documento->nombre); ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($documento->fecha_subida)); ?></td>
                            <td>
                                <a href="<?= base_url($documento->ruta); ?>" target="_blank" class="btn btn-sm btn-download">
                                    <i class="fas fa-download"></i> Descargar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                No hay documentos disponibles para este curso.
            </div>
        <?php endif; ?>
    </div>

    <!-- FontAwesome para iconos -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
