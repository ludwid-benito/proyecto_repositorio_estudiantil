<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documento_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Cargar la base de datos
    }

    

    // Guardar un nuevo documento
    public function guardar_documento($data) {
        return $this->db->insert('documentos', $data);
    }

    // Obtener un documento por ID
    public function obtener_documento($documento_id) {
        $this->db->select('*');
        $this->db->from('documentos');
        $this->db->where('id', $documento_id);
        $query = $this->db->get();
        return $query->row(); // Devolver solo una fila
    }
    // Obtener documentos por ID del curso
    // Obtener documentos por ID del curso
    public function obtener_documentos_por_curso($curso_id) {
        $this->db->select('*');
        $this->db->from('documentos');
        $this->db->where('curso_id', $curso_id); // Filtrar por curso
        $query = $this->db->get();
        return $query->result(); // Retornar resultados como array
    }

    // Eliminar un documento
    public function eliminar_documento($documento_id) {
        $this->db->where('id', $documento_id);
        return $this->db->delete('documentos'); // Eliminar documento por ID
    }
}
