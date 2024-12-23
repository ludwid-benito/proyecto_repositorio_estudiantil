<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Documentos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f3ef;
            font-family: 'Arial', sans-serif;
        }
        .header {
            background: linear-gradient(60deg, #ffa726, #fb8c00);
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .document-list th {
            color: #555;
        }
        .upload-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Encabezado -->
        <div class="header">
            <h2>Gestionar Documentos del Curso: <?= htmlspecialchars($curso->nombre); ?></h2>
            <p><?= htmlspecialchars($curso->descripcion); ?></p>
        </div>

        <!-- Mensajes de Éxito o Error -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <!-- Lista de Documentos -->
        <div class="document-list">
            <h4>Documentos Subidos</h4>
            <?php if (!empty($documentos)): ?>
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Fecha de Subida</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $contador = 1; ?>
                        <?php foreach ($documentos as $documento): ?>
                            <tr>
                                <td><?php echo $contador++; ?></td>
                                <td>
                                    <a href="<?= base_url($documento->ruta); ?>" target="_blank">
                                        <?= htmlspecialchars($documento->nombre); ?>
                                    </a>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($documento->fecha_subida)); ?></td>
                                <td>
                                    <a href="<?= site_url('repositorio/eliminar_documento/' . $documento->id . '/' . $curso->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este documento?');">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-warning text-center" role="alert">
                    No hay documentos subidos para este curso.
                </div>
            <?php endif; ?>
        </div>

        <!-- Formulario para Subir Documentos -->
        <div class="upload-section">
            <h4>Subir Nuevo Documento</h4>
            <?= form_open_multipart('repositorio/guardar_documento/' . $curso->id); ?>
                <div class="form-group">
                    <label for="documento">Selecciona el Documento</label>
                    <input type="file" name="documento" id="documento" class="form-control-file" required>
                </div>
                <button type="submit" class="btn btn-success">Subir Documento</button>
            <?= form_close(); ?>
        </div>

        <!-- Botón para Volver a la Lista de Cursos -->
        <div class="mt-4">
            <a href="<?= site_url('repositorio/privado'); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Mis Cursos
            </a>
        </div>
    </div>
</body>
</html>
