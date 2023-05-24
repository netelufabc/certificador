<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_nivel_idiomas extends CI_Model {

    
    function get_all_niveis() {
        $query = $this->db->get('cert_nivel_idiomas');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
        
    }
    
    /**
     * Insere nova linha na tabela cert_nivel_idiomas (nivel do aluno, que sairá no certificado, somente para cursos de idiomas)
     * @param type $id_aluno INT
     * @param type $id_curso INT
     * @param type $nivel String Máximo 4 caracteres (exemplo: B1.1, B1.2, C1.4, ...)
     */
    function InsertNewRow($id_aluno, $id_curso, $nivel) {
        $dados = array(
            'id_aluno' => $id_aluno,
            'id_curso' => $id_curso,
            'nivel' => $nivel,
        );
        $this->db->insert('cert_nivel_idiomas', $dados);
    }

    /**
     * Retorna o nível de determinado aluno (somente idiomas)
     * @param type $id_aluno
     * @return string com o nível ou string vazio se não encontrar algo.
     */
    function GetNivelAlunoIdiomas($id_aluno, $id_curso) {
        $array = array('id_aluno' => $id_aluno, 'id_curso' => $id_curso);
        $res = $this->db->get_where('cert_nivel_idiomas', $array);
        if ($res->num_rows() > 0) {
            //return $res->row()->nivel;
            return $res->row_array();
        } else {
            return NULL;
        }
    }

    /**
     * Retorna o ID da tabela id_nivel_idiomas para dados id_aluno e id_curso.
     * @param type $id_aluno
     * @param type $id_curso
     * @return type INT ou NULL se não encontrar
     */
    function GetIdNivelIdiomas($id_aluno, $id_curso) {
        $array = array('id_aluno' => $id_aluno, 'id_curso' => $id_curso);
        $res = $this->db->get_where('cert_nivel_idiomas', $array);
        if ($res->num_rows() > 0) {
            return $res->row()->id_nivel_idiomas;
        } else {
            return NULL;
        }
    }

    /**
     * Update no nivel do aluno (somente idiomas).
     * @param type $id_nivel_idiomas INT
     * @param type $nivel STRING Máximo 4 characteres (exemplo: B1.1, B1.2, C1.4, ...)
     */
    function UpdateNivelIdiomas($id_nivel_idiomas, $nivel) {
        if ($id_nivel_idiomas != null) {
           $this->db->query("UPDATE cert_nivel_idiomas
            SET nivel = ?
            WHERE id_nivel_idiomas = ?", array($nivel, $id_nivel_idiomas));
        }
    }
}
