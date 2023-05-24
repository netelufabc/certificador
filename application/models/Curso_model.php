<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Curso_model extends CI_Model {

    function get_curso($id_curso) {
        $array = array('id_curso' => $id_curso);
        $res = $this->db->get_where('cert_cursos', $array);
        if ($res->num_rows() > 0) {
            return $res->row_array();
        } else {
            return FALSE;
        }
    }

    function get_all_cursos() {
        $this->db->order_by('created', 'DESC');
        $query = $this->db->get('cert_cursos');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    function get_edital_unico($param) {
        $array = array('edital' => $param);
        $res = $this->db->get_where('cert_cursos', $array);
        if ($res->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Insere dados do curso na tabela 'cursos'
     *
     * @access  public
     */
    public function set_curso($dados = NULL) {
        if ($dados != NULL) {
            //verifica se edital é único
            $verifica = $this->get_edital_unico($dados['edital']);

            if ($verifica) {
                $this->session->set_flashdata('erro', "O identificador/edital informado já existe. Defina outro.");
                redirect('Admin/cadastrarNovoCurso');
            }

            $this->db->insert('cert_cursos', $dados);
            $id_curso = $this->db->insert_id(); //retorna o id da última inserção
            return $id_curso;
        }
    }

    public
            function update_curso($dados_curso, $id_curso) { //função para update na tabela cursos (GUC)
        $this->db->where('id_curso', $id_curso);
        $this->db->update('cert_cursos', $dados_curso);
        $this->session->set_flashdata('alterar_curso_ok', 'Dados do evento alterados com sucesso!');
        redirect('Admin');
    }

    public
            function del_evento($id_curso) {
        if ($id_curso != NULL) {
            $this->db->delete('cert_cursos', array('id_curso' => $id_curso));
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
