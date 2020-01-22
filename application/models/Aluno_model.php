<?php

class Aluno_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_all_alunos() {
        $query = $this->db->get('cert_alunos');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    function get_aluno($id_aluno) {
        $array = array('id_aluno' => $id_aluno);
        $res = $this->db->get_where('cert_alunos', $array);
        if ($res->num_rows() > 0) {
            return $res->row_array();
        } else {
            return FALSE;
        }
    }

    function get_aluno_por_curso($id_aluno, $id_curso) {
        return($this->db->query("select cert_alunos.cpf, cert_alunos.rne,cert_alunocurso.`id_alunocurso`, cert_alunocurso.`faltas_em_horas`, cert_alunos.id_aluno, cert_alunocurso.id_curso ,cert_alunos.nome,cert_alunos.email,
            cert_alunocurso.conceito,cert_alunocurso.`status`,cert_alunocurso.`cod_validacao` from cert_alunos
            INNER JOIN
            cert_alunocurso ON cert_alunos.id_aluno = cert_alunocurso.id_aluno
            WHERE cert_alunocurso.id_curso = ?  AND cert_alunos.id_aluno = ?;", array($id_curso, $id_aluno))->row());
    }

    function update_aluno($dados_aluno, $id_curso, $id_aluno) {
        $this->db->query("UPDATE cert_alunos
            SET nome = ?, email = ?, cpf = ?, rne = ?
            WHERE id_aluno = ?", array($dados_aluno['nomeAluno'], $dados_aluno['email'],$dados_aluno['cpf'], $dados_aluno['rne'], $id_aluno));
        $this->db->query("UPDATE cert_alunocurso
            SET conceito = ?, status = ?, faltas_em_horas = ?
            WHERE id_aluno = ? AND id_curso = ?", array($dados_aluno['conceito'], $dados_aluno['status'], $dados_aluno['faltas_em_horas'] , $id_aluno, $id_curso));
        $this->session->set_flashdata('alterar_aluno_ok', 'Dados do Aluno alterados com sucesso!');
        redirect("Admin/listarAlunosDoCurso/$id_curso");
    }

    function get_aluno_nome($nome) {
        $sql = "SELECT * FROM cert_alunos WHERE nome LIKE '%$nome%' ORDER BY nome ASC;";

        $res = $this->db->query($sql);
        if ($res->num_rows() > 0) {
            return $res->result_array();
        } else {
            return FALSE;
        }
    }

    function get_aluno_by_email($email_aluno) {
        $array = array('email' => $email_aluno);
        $res = $this->db->get_where('cert_alunos', $array);
        if ($res->num_rows() > 0) {
            return $res->row_array();
        } else {
            return FALSE;
        }
    }

    /**
     * Insere cada aluno da lista na tabela 'alunos'
     *
     * @access  public
     */
    function set_aluno($dados = NULL) {

        if ($dados != NULL) {
            $this->db->insert('cert_alunos', $dados);
            $id_aluno = $this->db->insert_id(); //retorna o id da última inserção
            return $id_aluno;
        }
    }

    function atualizarAluno($id_aluno, $dados) {
//        if (is_null($id) || !isset($data))
//            return false;
        $this->db->where('id_aluno', $id_aluno);
        return $this->db->update('cert_alunos', $dados);
    }

    public function delAluno($id_aluno) {
        if ($id_aluno != NULL) {
            $this->db->delete('cert_alunos', $id_aluno);
        }
    }
    
    //famt
    function update_Cpf_Rne($dados) {
        $this->db->where('id_aluno', $dados['id_aluno']);
        return $this->db->update('cert_alunos', $dados);
    }

}
