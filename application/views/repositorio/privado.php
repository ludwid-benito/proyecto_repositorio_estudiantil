<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Cursos Privados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f3ef;
            font-family: 'Arial', sans-serif;
        }
        .header {
            background: linear-gradient(60deg, #66bb6a, #43a047);
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .table th {
            color: #555;
        }
    </style>
</head>
<body>
    <!-- Contenedor Principal -->
    <div class="container mt-4">
        <!-- Encabezado -->
        <div class="header">
            <h2>Mis Cursos y Documentos Privados</h2>
            <p>Aquí puedes ver y gestionar tus cursos y documentos privados.</p>
            <a href="<?= site_url('repositorio/crear_curso'); ?>" class="btn btn-primary mt-3">
                <i class="fas fa-plus"></i> Crear Nuevo Curso
            </a>
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

        <!-- Tabla de Cursos Privados -->
        <?php if (!empty($cursos)): ?>
            <table class="table table-striped table-bordered mt-3">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha de Creación</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                        
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
                            <td><?php echo htmlspecialchars($curso->tipo); ?></td>
                            <td>
                                <!-- Acciones: Editar, Eliminar y Gestionar Documentos -->
                                <a href="<?= site_url('repositorio/editar/' . $curso->id); ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <a href="<?= site_url('repositorio/eliminar/' . $curso->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este curso?');">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </a>
                                <a href="<?= site_url('repositorio/gestionar_documentos/' . $curso->id); ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-folder-plus"></i> Documentos
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                No tienes cursos o documentos privados en este momento.
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
