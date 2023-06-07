<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notas_model extends CI_Model {

    function get_notas($id_alunocurso) {
        $res = $this->db->get_where('cert_notas', array('id_alunocurso' => $id_alunocurso));
        return $res->result_array();
    }

    function set_notas($id_alunocurso, $notas) {
        foreach ($notas as $key => $nota) {
            if ($nota != NULL) {
                $dados = array('id_alunocurso' => $id_alunocurso, 'nota' => $nota);
                $this->db->insert('cert_notas', $dados);
            }
        }
    }

    function update_notas($id_alunocurso, $notas) {
        foreach ($this->get_notas($id_alunocurso) as $nota) {
            $this->db->where('id_notas', $nota['id_notas']);
            $this->db->delete('cert_notas');
        }

        $this->set_notas($id_alunocurso, $notas);
    }

}
