<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Curso_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Cargar la base de datos
    }

    // Obtener cursos públicos
    public function obtener_publicos() {
        $this->db->select('*');
        $this->db->from('cursos');
        $this->db->where('tipo', 'publico'); // Filtrar por tipo 'publico'
        $query = $this->db->get();
        return $query->result(); // Devolver resultados como array de objetos
    }

    // Obtener cursos privados por usuario
    public function obtener_privados($user_id) {
        $this->db->select('*');
        $this->db->from('cursos');
        $this->db->where('tipo', 'privado'); // Filtrar por tipo 'privado'
        $this->db->where('usuario_id', $user_id); // Filtrar por ID del usuario
        $query = $this->db->get();
        return $query->result(); // Devolver resultados como array de objetos
    }

    // Crear un nuevo curso
    public function crear_curso($data) {
        return $this->db->insert('cursos', $data); // Insertar datos en la tabla 'cursos'
    }

    // Obtener un curso específico por ID
    public function obtener_curso($curso_id) {
        $this->db->select('*');
        $this->db->from('cursos');
        $this->db->where('id', $curso_id);
        $query = $this->db->get();
        return $query->row(); // Devolver solo una fila
    }
    // Obtener todos los cursos creados por un usuario específico
    public function obtener_cursos_por_usuario($user_id) {
        $this->db->select('*');
        $this->db->from('cursos');
        $this->db->where('usuario_id', $user_id); // Filtrar por ID del usuario
        $query = $this->db->get();
        return $query->result(); // Retorna todos los cursos del usuario
    }


    // Actualizar un curso
    public function actualizar_curso($curso_id, $data) {
        $this->db->where('id', $curso_id);
        return $this->db->update('cursos', $data); // Actualizar curso por ID
    }

    // Eliminar un curso
    public function eliminar_curso($curso_id) {
        $this->db->where('id', $curso_id);
        return $this->db->delete('cursos'); // Eliminar curso por ID
    }
}
