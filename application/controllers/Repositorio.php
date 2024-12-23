<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Repositorio extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Cargar librerías, modelos y helpers necesarios
        $this->load->library('session');
        $this->load->helper('url'); // Para usar site_url()
        $this->load->model('Curso_model');
        $this->load->model('Documento_model');
        $this->load->model('User_model');
        $this->load->model('Mensaje_model');

        
    }

    // Página principal del repositorio
    public function index() {
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('repositorio/repositorio'); // Vista principal
        $this->load->view('templates/footer');
    }

    // Mostrar cursos y documentos públicos
    public function publico() {
        // Obtener cursos públicos desde el modelo
        $data['cursos'] = $this->Curso_model->obtener_publicos();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('repositorio/publico', $data); // Vista para público
        $this->load->view('templates/footer');
    }

    // Mostrar cursos y documentos privados del usuario
    public function privado() {
        $user_id = $this->session->userdata('user_id'); // ID del usuario logueado
        $data['cursos'] = $this->Curso_model->obtener_cursos_por_usuario($user_id);

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('repositorio/privado', $data); // Vista para privado
        $this->load->view('templates/footer');
    }

    // Página de soporte o chat
    public function soporte() {
        $this->load->model('Mensaje_model');
    
        // Obtener mensajes de la base de datos
        $data['mensajes'] = $this->Mensaje_model->obtener_mensajes();
    
        // Cargar las vistas
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('repositorio/soporte', $data); // Pasar mensajes a la vista
        $this->load->view('templates/footer');
    }
    // Mostrar el formulario para crear un nuevo curso
    public function crear_curso() {
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('repositorio/crear_curso'); // Nueva vista para crear curso
        $this->load->view('templates/footer');
    }

    // Guardar el nuevo curso en la base de datos
    public function guardar_curso() {
        // Validar los datos del formulario
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nombre', 'Nombre del Curso', 'required|min_length[3]');
        $this->form_validation->set_rules('descripcion', 'Descripción', 'required|min_length[10]');
        $this->form_validation->set_rules('tipo', 'Tipo', 'required|in_list[publico,privado]');

        if ($this->form_validation->run() == FALSE) {
            // Si la validación falla, recargar el formulario
            $this->crear_curso();
        } else {
            // Preparar los datos para insertar
            $data = array(
                'nombre'       => $this->input->post('nombre'),
                'descripcion'  => $this->input->post('descripcion'),
                'tipo'         => $this->input->post('tipo'),
                'usuario_id'   => $this->session->userdata('user_id') // Asignar el ID del usuario
            );

            // Insertar el curso usando el modelo
            $insert = $this->Curso_model->crear_curso($data);

            if ($insert) {
                // Redirigir a la página privada con un mensaje de éxito
                $this->session->set_flashdata('success', 'Curso creado exitosamente.');
                redirect('repositorio/privado');
            } else {
                // Redirigir de vuelta al formulario con un mensaje de error
                $this->session->set_flashdata('error', 'Hubo un problema al crear el curso.');
                redirect('repositorio/crear_curso');
            }
        }
    }
    // Mostrar los documentos de un curso específico
    public function gestionar_documentos($curso_id) {
        // Verificar que el curso pertenezca al usuario
        $user_id = $this->session->userdata('user_id');
        $curso = $this->Curso_model->obtener_curso($curso_id);

        if (!$curso || $curso->usuario_id != $user_id) {
            show_error('Curso no encontrado o acceso denegado.', 404, 'Error');
        }

        // Obtener los documentos del curso
        $data['documentos'] = $this->Documento_model->obtener_documentos_por_curso($curso_id);
        $data['curso'] = $curso;

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('repositorio/gestionar_documentos', $data); // Nueva vista para gestionar documentos
        $this->load->view('templates/footer');
    }

    // Manejar la subida de documentos
    public function guardar_documento($curso_id) {
        // Verificar que el curso pertenezca al usuario
        $user_id = $this->session->userdata('user_id');
        $curso = $this->Curso_model->obtener_curso($curso_id);

        if (!$curso || $curso->usuario_id != $user_id) {
            show_error('Curso no encontrado o acceso denegado.', 404, 'Error');
        }

        // Configurar la carga de archivos
        $config['upload_path'] = './uploads/documentos/';
        $config['allowed_types'] = 'pdf|doc|docx|ppt|pptx|xls|xlsx|jpg|jpeg|png';
        $config['max_size'] = 112048; // 2MB
        // Crear la carpeta si no existe
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, TRUE);
        }

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('documento')) {
            // Error en la subida
            $this->session->set_flashdata('error', $this->upload->display_errors());
        } else {
            // Archivo subido correctamente
            $archivo = $this->upload->data();
            $data = array(
                'curso_id'    => $curso_id,
                'nombre'      => $archivo['file_name'],
                'ruta'        => 'uploads/documentos/' . $archivo['file_name'],
                'fecha_subida'=> date('Y-m-d H:i:s')
            );

            $this->Documento_model->guardar_documento($data);
            $this->session->set_flashdata('success', 'Documento subido exitosamente.');
        }

        redirect('repositorio/gestionar_documentos/' . $curso_id);
    }
    public function ver_documentos($curso_id) {
        // Cargar modelo de documentos
        $this->load->model('Documento_model');
    
        // Obtener información del curso
        $curso = $this->Curso_model->obtener_curso($curso_id);
    
        if (!$curso) {
            show_error('El curso no existe.', 404, 'Error');
        }
    
        // Obtener los documentos asociados al curso
        $data['curso'] = $curso;
        $data['documentos'] = $this->Documento_model->obtener_documentos_por_curso($curso_id);
    
        // Cargar la vista con los detalles del curso y documentos
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('repositorio/ver_documentos', $data);
        $this->load->view('templates/footer');
    }
    

    public function enviar_mensaje() {
        // Verificar si el formulario fue enviado
        
        if ($this->input->post('mensaje')) {
            $usuario_id = $this->session->userdata('user_id'); // Obtener ID del usuario logueado
            $usuario = $this->session->userdata('username'); // Obtener nombre del usuario
    
            // Datos del mensaje
            $data = array(
                'usuario_id' => $usuario_id,
                'usuario' => $usuario,
                'mensaje' => $this->input->post('mensaje')
            );
    
            // Insertar mensaje en la base de datos
            $this->load->model('Mensaje_model');
            if ($this->Mensaje_model->enviar_mensaje($data)) {
                $this->session->set_flashdata('success', 'Mensaje enviado con éxito.');
            } else {
                $this->session->set_flashdata('error', 'Error al enviar el mensaje.');
            }
        }
    
        // Redirigir de vuelta a la página de soporte
        redirect('repositorio/soporte');
    }
    public function ver_mensajes() {
        $this->verificar_administrador(); // Verificar si es administrador
    
        $this->load->model('Mensaje_model');
        $data['mensajes'] = $this->Mensaje_model->obtener_mensajes();
    
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('repositorio/ver_mensajes', $data);
        $this->load->view('templates/footer');
    }
    protected function verificar_administrador() {
        if ($this->session->userdata('rol') != 'administrador') {
            show_error('No tienes permiso para acceder a esta página.', 403, 'Acceso Denegado');
        }
    }
    // Método para que el administrador responda a un mensaje
    public function responder_mensaje($mensaje_id){
        // Verificar si el usuario es administrador
        if($this->session->userdata('rol') != 'administrador'){
            show_error('No tienes permiso para acceder a esta página.', 403, 'Acceso Denegado');
        }

        // Obtener la respuesta del formulario
        $respuesta = $this->input->post('respuesta');

        if($respuesta){
            // Guardar la respuesta en la base de datos
            $data = array(
                'respuesta' => $respuesta,
                'fecha_respuesta' => date('Y-m-d H:i:s')
            );

            if($this->Mensaje_model->guardar_respuesta($mensaje_id, $data)){
                // Actualizar el estado del mensaje a 'atendido'
                $this->Mensaje_model->actualizar_estado($mensaje_id, 'atendido');

                $this->session->set_flashdata('success', 'Respuesta enviada correctamente.');
            } else {
                $this->session->set_flashdata('error', 'No se pudo enviar la respuesta. Intenta nuevamente.');
            }
        } else {
            $this->session->set_flashdata('error', 'La respuesta no puede estar vacía.');
        }

        redirect('repositorio/ver_mensajes');
    }
    
    
}
