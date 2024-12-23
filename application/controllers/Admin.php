<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
        $this->load->model('Mensaje_model'); // Cargar modelos necesarios

        // Verificar si el usuario está logueado y es administrador
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        if ($this->session->userdata('role') !== 'admin') {
            show_error('No tienes permiso para acceder a esta página.', 403, 'Acceso Denegado');
        }
    }

    // Método para el dashboard de administración
    public function dashboard()
    {
        // Cargar la vista del dashboard
        $this->load->view('admin/dashboard');
    }

    // Otros métodos administrativos...
}
?>
