<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthHook {
    public function check_login()
    {
        $CI =& get_instance();
        $controller = $CI->router->fetch_class();
        $method = $CI->router->fetch_method();

        // Definir controladores y métodos que no requieren autenticación
        $excluded = array(
            'auth', // Controlador de autenticación
            'home', // Controlador de inicio
            'publico', // Controlador público
            // Puedes agregar más controladores o métodos aquí
        );

        // Definir métodos específicos que no requieren autenticación
        $excluded_methods = array(
            'login', // Método de inicio de sesión
            'register', // Método de registro
            // Puedes agregar más métodos aquí
        );

        // Verificar si el controlador actual está excluido
        if (in_array(strtolower($controller), $excluded)) {
            return;
        }

        // Verificar si el método actual está excluido
        if (in_array(strtolower($method), $excluded_methods)) {
            return;
        }

        // Verificar si el usuario está logueado
        if (!$CI->session->userdata('logged_in')) {
            // Redirigir al usuario a la página de inicio de sesión
            redirect('auth/login');
        }

        // Opcional: Verificar roles o permisos
        // if ($CI->session->userdata('role') !== 'admin') {
        //     show_error('No tienes permiso para acceder a esta página.', 403, 'Acceso Denegado');
        // }
    }
}
?>
