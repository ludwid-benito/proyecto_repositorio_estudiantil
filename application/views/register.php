<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <!-- Agregar Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            font-family: 'Arial', sans-serif;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Registrarse</h4>
                    </div>
                    <div class="card-body">
                        <!-- Formulario de registro -->
                        <form action="<?= site_url('auth/process_register') ?>" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de usuario</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="text" class="form-control" id="dni" name="dni" maxlength="8" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombres" class="form-label">Nombres</label>
                                <input type="text" class="form-control" id="nombres" name="nombres" readonly required>
                            </div>
                            <div class="mb-3">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" readonly required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                        </form>

                        <!-- Enlace para ir al inicio de sesión -->
                        <div class="mt-3 text-center">
                            <p>¿Ya tienes cuenta? <a href="<?= site_url('auth/login') ?>">Inicia sesión aquí</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('dni').addEventListener('blur', function() {
            const dni = this.value;
            if (dni.length === 8) { // Verificar que tenga 8 dígitos
                fetch('<?= site_url("auth/consultar_dni") ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ dni: dni })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('nombres').value = data.nombres;
                        document.getElementById('apellidos').value = data.apellidos;
                    } else {
                        alert('No se encontraron datos para el DNI ingresado.');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    </script>

    <!-- Agregar Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>