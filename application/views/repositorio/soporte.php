<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soporte</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        }
        .chat-box {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            background-color: #fff;
            height: 400px;
            overflow-y: scroll;
        }
        .message {
            margin-bottom: 10px;
        }
        .message .user {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="container mt-4">
        <div class="header">
            <h2 class="text-center">Soporte</h2>
            <p class="text-center">En esta sección puedes comunicarte con el creador para resolver tus dudas o problemas.</p>
        </div>

        <!-- Chat Box -->
        <div class="chat-box" id="chat-box">
            <!-- Mensajes cargados dinámicamente -->
            <div class="message">
                <span class="user">Admin:</span>
                <span>¡Hola! ¿En qué puedo ayudarte?</span>
            </div>
            <?php if (!empty($mensajes)): ?>
                <?php foreach ($mensajes as $mensaje): ?>
                    <div class="message">
                        <span class="user"><?php echo htmlspecialchars($mensaje->usuario); ?>:</span>
                        <span><?php echo htmlspecialchars($mensaje->mensaje); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Formulario para enviar mensaje -->
        <div class="mt-3">
            <form action="<?php echo site_url('repositorio/enviar_mensaje'); ?>" method="POST" id="mensaje-form">
                <div class="form-group">
                    <label for="mensaje">Escribe tu mensaje:</label>
                    <textarea name="mensaje" id="mensaje" rows="3" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>

    <script>
        // Función para cargar mensajes de manera automática
        function cargarMensajes() {
            $.ajax({
                url: '<?php echo site_url("repositorio/obtener_mensajes"); ?>', // Asegúrate de crear este método en tu controlador
                method: 'GET',
                success: function(data) {
                    // Limpiar los mensajes actuales
                    $('#chat-box').empty();
                    // Recorrer los mensajes y agregarlos al chat
                    data.mensajes.forEach(function(mensaje) {
                        $('#chat-box').append(
                            '<div class="message"><span class="user">' + mensaje.usuario + ':</span><span>' + mensaje.mensaje + '</span></div>'
                        );
                    });
                    // Desplazar al final del chat
                    $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                }
            });
        }

        // Enviar un mensaje
        $('#mensaje-form').submit(function(e) {
            e.preventDefault();  // Prevenir el envío normal del formulario

            var mensaje = $('#mensaje').val();
            $.ajax({
                url: '<?php echo site_url("repositorio/enviar_mensaje"); ?>',
                method: 'POST',
                data: {
                    mensaje: mensaje
                },
                success: function(response) {
                    // Limpiar el campo de mensaje
                    $('#mensaje').val('');
                    // Volver a cargar los mensajes después de enviar uno nuevo
                    cargarMensajes();
                }
            });
        });

        // Cargar los mensajes cada 5 segundos
        setInterval(cargarMensajes, 5000);

        // Cargar los mensajes inicialmente
        $(document).ready(function() {
            cargarMensajes();
        });
    </script>
</body>
</html>
