<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso</title>
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
            text-align: center;
        }
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Encabezado -->
        <div class="header">
            <h2>Crear Nuevo Curso</h2>
            <p>Completa el siguiente formulario para crear un curso.</p>
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

        <!-- Formulario para Crear Curso -->
        <div class="form-container">
            <?= form_open('repositorio/guardar_curso'); ?>
                <div class="form-group">
                    <label for="nombre">Nombre del Curso</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="<?= set_value('nombre'); ?>" required>
                    <?= form_error('nombre', '<small class="text-danger">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="5" class="form-control" required><?= set_value('descripcion'); ?></textarea>
                    <?= form_error('descripcion', '<small class="text-danger">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo de Curso</label>
                    <select name="tipo" id="tipo" class="form-control" required>
                        <option value="">Selecciona el tipo</option>
                        <option value="publico" <?= set_select('tipo', 'publico'); ?>>Público</option>
                        <option value="privado" <?= set_select('tipo', 'privado'); ?>>Privado</option>
                    </select>
                    <?= form_error('tipo', '<small class="text-danger">', '</small>'); ?>
                </div>
                <button type="submit" class="btn btn-success">Crear Curso</button>
                <a href="<?= site_url('repositorio/privado'); ?>" class="btn btn-secondary">Cancelar</a>
            <?= form_close(); ?>
        </div>
    </div>
</body>
</html>
