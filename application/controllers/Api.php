<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Mensaje_model'); // Cargar el modelo necesario
        header('Content-Type: application/json'); // Configurar encabezado para respuestas JSON
    }

    // Método para obtener todos los mensajes (GET)
    public function mensajes_get(){
        // Verificar si la solicitud es GET
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $mensajes = $this->Mensaje_model->obtener_mensajes();
            if($mensajes){
                echo json_encode([
                    'status' => TRUE,
                    'data' => $mensajes
                ]);
            }
            else{
                echo json_encode([
                    'status' => FALSE,
                    'message' => 'No se encontraron mensajes.'
                ]);
            }
        } else {
            // Método no permitido
            echo json_encode([
                'status' => FALSE,
                'message' => 'Método no permitido.'
            ]);
        }
    }

    // Método para crear un nuevo mensaje (POST)
    public function mensajes_post(){
        // Verificar si la solicitud es POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtener datos del cuerpo de la solicitud
            $data = json_decode(file_get_contents('php://input'), true);
            $data = [
                'usuario_id' => $data['usuario_id'],
                'usuario' => $data['usuario'],
                'mensaje' => $data['mensaje'],
                'estado' => 'pendiente',
                'fecha_envio' => date('Y-m-d H:i:s')
            ];

            if($this->Mensaje_model->enviar_mensaje($data)){
                echo json_encode([
                    'status' => TRUE,
                    'message' => 'Mensaje creado exitosamente.'
                ]);
            }
            else{
                echo json_encode([
                    'status' => FALSE,
                    'message' => 'No se pudo crear el mensaje.'
                ]);
            }
        } else {
            // Método no permitido
            echo json_encode([
                'status' => FALSE,
                'message' => 'Método no permitido.'
            ]);
        }
    }

    // Método para actualizar (responder) un mensaje existente (PUT)
    public function mensajes_put($id){
        // Verificar si la solicitud es PUT
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            // Obtener datos del cuerpo de la solicitud
            $data = json_decode(file_get_contents('php://input'), true);
            $data = [
                'respuesta' => $data['respuesta'],
                'fecha_respuesta' => date('Y-m-d H:i:s'),
                'estado' => 'atendido'
            ];

            if($this->Mensaje_model->guardar_respuesta($id, $data)){
                echo json_encode([
                    'status' => TRUE,
                    'message' => 'Mensaje actualizado exitosamente.'
                ]);
            }
            else{
                echo json_encode([
                    'status' => FALSE,
                    'message' => 'No se pudo actualizar el mensaje.'
                ]);
            }
        } else {
            // Método no permitido
            echo json_encode([
                'status' => FALSE,
                'message' => 'Método no permitido.'
            ]);
        }
    }

    // Método para eliminar un mensaje (DELETE)
    public function mensajes_delete($id){
        // Verificar si la solicitud es DELETE
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if($this->Mensaje_model->eliminar_mensaje($id)){
                echo json_encode([
                    'status' => TRUE,
                    'message' => 'Mensaje eliminado exitosamente.'
                ]);
            }
            else{
                echo json_encode([
                    'status' => FALSE,
                    'message' => 'No se pudo eliminar el mensaje.'
                ]);
            }
        } else {
            // Método no permitido
            echo json_encode([
                'status' => FALSE,
                'message' => 'Método no permitido.'
            ]);
        }
    }

    // Otros métodos según tus necesidades...
}
?>
