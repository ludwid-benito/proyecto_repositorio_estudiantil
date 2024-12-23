<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes de Soporte</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f3ef;
            font-family: 'Arial', sans-serif;
        }
        .header {
            background: linear-gradient(60deg, #FF5722, #E64A19);
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .table th {
            color: #555;
        }
        .modal-header {
            background-color: #FF5722;
            color: #fff;
        }
        .btn-primary {
            background-color: #FF5722;
            border-color: #E64A19;
        }
        .btn-secondary {
            background-color: #E64A19;
            border-color: #FF5722;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Encabezado -->
        <div class="header">
            <h2>Mensajes de Soporte</h2>
            <p>Aquí puedes ver y responder a los mensajes enviados por los usuarios.</p>
        </div>

        <!-- Mensajes Flash de Éxito o Error -->
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <!-- Tabla de Mensajes de Soporte -->
        <?php if(!empty($mensajes)): ?>
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Usuario</th>
                        <th>Mensaje</th>
                        <th>Fecha de Envío</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $contador = 1; ?>
                    <?php foreach($mensajes as $mensaje): ?>
                        <tr>
                            <td><?php echo $contador++; ?></td>
                            <td><?php echo htmlspecialchars($mensaje->usuario); ?></td>
                            <td><?php echo htmlspecialchars($mensaje->mensaje); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($mensaje->fecha_envio)); ?></td>
                            <td>
                                <?php if($mensaje->estado == 'pendiente'): ?>
                                    <span class="badge badge-warning">Pendiente</span>
                                <?php else: ?>
                                    <span class="badge badge-success">Atendido</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($mensaje->estado == 'pendiente'): ?>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#respuestaModal<?php echo $mensaje->id; ?>">
                                        Responder
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-secondary btn-sm" disabled>
                                        Respondido
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- Modal para Responder -->
                        <?php if($mensaje->estado == 'pendiente'): ?>
                            <div class="modal fade" id="respuestaModal<?php echo $mensaje->id; ?>" tabindex="-1" role="dialog" aria-labelledby="respuestaModalLabel<?php echo $mensaje->id; ?>" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="respuestaModalLabel<?php echo $mensaje->id; ?>">Responder al Mensaje</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <form action="<?php echo site_url('repositorio/responder_mensaje/' . $mensaje->id); ?>" method="POST">
                                      <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                                      <div class="modal-body">
                                          <div class="form-group">
                                              <label for="respuesta">Respuesta:</label>
                                              <textarea name="respuesta" rows="4" class="form-control" placeholder="Escribe tu respuesta aquí..." required></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Enviar Respuesta</button>
                                      </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                No hay mensajes de soporte en este momento.
            </div>
        <?php endif; ?>
    </div>

    <!-- jQuery y Bootstrap JS para manejar los modales -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
