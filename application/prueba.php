<?php
// Generar un hash de la contraseña
$stored_hashed_password = password_hash('12345', PASSWORD_BCRYPT);

// La contraseña ingresada por el usuario
$input_password = '12345'; // Asegúrate de eliminar espacios extra

// Verificar si la contraseña es válida
if (password_verify($input_password,$stored_hashed_password)) {
    echo 'La contraseña es válida.';
} else {
    echo 'La contraseña es incorrecta.';
}

// Mostrar el hash generado
echo "<br>Hash almacenado: " . $stored_hashed_password;
?>
