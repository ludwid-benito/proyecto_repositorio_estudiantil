<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
    }

    // Página de registro
    public function register() {
        // Cargar la vista de registro
        $this->load->view('register');
    }

    // Procesar el registro
    public function process_register() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $dni = $this->input->post('dni');
        $nombres = $this->input->post('nombres');
        $apellidos = $this->input->post('apellidos');

        // Registrar al usuario
        $this->User_model->register($username, $password,$dni,$nombres,$apellidos);

        // Redirigir a la página de inicio de sesión
        redirect('auth/login');
    }

    // Página de inicio de sesión
    public function login() {
        // Cargar la vista de inicio de sesión
        $this->load->view('login');
    }

    // Procesar el inicio de sesión
    public function process_login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
    
        // Intentar iniciar sesión
        $user = $this->User_model->login($username, $password);
    
        if ($user) {
            // Si el inicio de sesión es exitoso, establecer datos de sesión
            $sesion_data = array(
                'user_id'   => $user->id,           // Asegúrate de que el campo 'id' existe en la tabla 'usuarios'
                'username'  => $user->username,
                'rol'=> $user->rol,
                'logged_in' => TRUE
                
            );
            $this->session->set_userdata($sesion_data);
            if($user->rol == 'administrador'){
                redirect('repositorio/ver_mensajes');
            } else {
                redirect('repositorio/soporte');
            }
            // Redirigir a la página de bienvenida o repositorio
            redirect('auth/welcome'); // O 'repositorio' según tu flujo
        } else {
            // Si falla el inicio de sesión, mostrar mensaje de error
            $this->load->view('login', ['error' => 'Usuario o contraseña incorrectos']);
        }
    }
    
    public function consultar_dni() {
        // Obtener el DNI del POST
        $input = json_decode(file_get_contents("php://input"), true);
        $dni = $input['dni'] ?? '';
    
        if (!$dni) {
            echo json_encode(['success' => false, 'message' => 'DNI no proporcionado']);
            return;
        }
    
        // Llamar a la API
        $params = json_encode(['dni' => $dni]);
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://apiperu.dev/api/dni",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Bearer 7e4d3f572c5f1421261a7b3e2a7f46466534e6ea5b666c7e3658c23d5cd9f45c'
            ],
        ]);
    
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
    
        if ($err) {
            echo json_encode(['success' => false, 'message' => 'Error en la API']);
        } else {
            $data = json_decode($response, true);
            if (isset($data['data'])) {
                echo json_encode([
                    'success' => true,
                    'nombres' => $data['data']['nombres'] ?? '',
                    'apellidos' => $data['data']['apellido_paterno'] . ' ' . $data['data']['apellido_materno']
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'DNI no encontrado']);
            }
        }
    }
    public function admin_dashboard() {
        $this->verificar_administrador(); // Solo administradores
    
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('repositorio/admin_dashboard');
        $this->load->view('templates/footer');
    }
    

    // Página de bienvenida
    public function welcome() {
        // Verificar si el usuario está logueado
        if ($this->session->userdata('username')) {
            // Cargar la vista de bienvenida y pasar el nombre de usuario
            $data['username'] = $this->session->userdata('username');
            $this->load->view('welcome', $data);
        } else {
            // Si no está logueado, redirigir al inicio de sesión
            redirect('auth/login');
        }
    }

    // Página de cierre de sesión
    public function logout() {
        // Destruir la sesión
        $this->session->sess_destroy();
        // Redirigir a la página de inicio de sesión
        redirect('auth/login');
    }
}
?> 