<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensaje_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Cargar la base de datos
    }

    // Guardar un mensaje en la base de datos
    public function enviar_mensaje($data) {
        return $this->db->insert('mensajes', $data);
    }
    // Obtener mensajes por usuario
    public function obtener_mensajes_por_usuario($usuario_id){
        $this->db->select('mensajes.*, usuarios.username');
        $this->db->from('mensajes');
        $this->db->join('usuarios', 'mensajes.usuario_id = usuarios.id');
        $this->db->where('mensajes.usuario_id', $usuario_id);
        $this->db->order_by('fecha_envio', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    // Obtener todos los mensajes
    public function obtener_mensajes() {
        $this->db->select('mensajes.*, usuarios.username');
        $this->db->from('mensajes');
        $this->db->join('usuarios', 'mensajes.usuario_id = usuarios.id');
        
        $this->db->order_by('fecha_envio', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
    // Guardar una respuesta
    public function guardar_respuesta($mensaje_id, $data){
        $this->db->where('id', $mensaje_id);
        return $this->db->update('mensajes', array(
            'respuesta' => $data['respuesta'],
            'fecha_respuesta' => $data['fecha_respuesta'],
            'estado' => 'atendido'
        ));
    }
    // Actualizar el estado del mensaje
    public function actualizar_estado($mensaje_id, $estado){
        $this->db->where('id', $mensaje_id);
        return $this->db->update('mensajes', array('estado' => $estado));
    }
}
