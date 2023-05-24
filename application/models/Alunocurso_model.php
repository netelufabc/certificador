<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AlunoCurso_model extends CI_Model {

    //busca na tabela AlunoCurso o aluno que já foi cadastrado em um curso
    function get_alunocursoRedundante($id_aluno, $id_curso) {
        $array = array(
            'id_aluno'   =>  $id_aluno,
            'id_curso'  =>  $id_curso
            );
        $res = $this->db->get_where('cert_alunocurso', $array);
        
        if ($res->num_rows() > 0) {
            return $res->row_array();
        } else {
            return FALSE;
        }
    }
    
    
    function get_alunocurso($id_alunocurso, $cod_validacao) {
        $array = array(
            'id_alunocurso' => $id_alunocurso,
            'cod_validacao' => $cod_validacao
        );
//        $res = $this->db->query("SELECT * FROM 'alunocurso' WHERE 'id' = $id AND 'cod_validacao' = '$cod_validacao';")->result();
        $res = $this->db->get_where('cert_alunocurso', $array);


        if ($res->num_rows() > 0) {
            return $res->row_array();
        } else {
            return FALSE;
        }
    }

    function getCursosDoAluno($emailAluno) {
        $sql = "SELECT a.`id_aluno`,a.`nome`,a.`email`, c.`id_curso`,c.`nomeCurso`,c.`dataIni`,c.`dataFim`, ac.`id_alunocurso`, ac.`id_aluno`, ac.`id_curso`, ac.`cod_validacao`, ac.`aprovado`
            FROM cert_alunos a, cert_cursos c, cert_alunocurso ac 
            WHERE a.`email` = '$emailAluno'
            AND a.`id_aluno` = ac.`id_aluno`
            AND c.`id_curso` = ac.`id_curso`
            ORDER BY c.`created` DESC;";

        $res = $this->db->query($sql);
        if ($res->num_rows() > 0) {
            return $res->result_array();
        } else {
            return FALSE;
        }
    }

    //busca dados pelo nome
    function getCursosDoAlunoPorNome($nomeAluno) {
        $sql="SELECT a.id_aluno, a.nome, a.email,c.id_curso, c.nomeCurso, ac.id_alunocurso, ac.id_certificado, ac.cod_validacao, ac.aprovado
            FROM cert_alunocurso ac, cert_alunos a, cert_cursos c 
            WHERE a.id_aluno IN
                (SELECT id_aluno FROM cert_alunos WHERE nome LIKE '%$nomeAluno%')
            AND a.id_aluno = ac.id_aluno
            AND ac.id_curso = c.id_curso
            ORDER BY a.nome ASC;";
        
        
//        $sql = "SELECT a.`id_aluno`,a.`nome`,a.`email`, c.`id_curso`,c.`nomeCurso`,c.`dataIni`,c.`dataFim`, ac.`id_alunocurso`, ac.`id_aluno`, ac.`id_curso`, ac.`cod_validacao`, ac.`aprovado`
//            FROM cert_alunos a, cert_cursos c, cert_alunocurso ac 
//            WHERE a.`email` = '$nomeAluno'
//            AND a.`id_aluno` = ac.`id_aluno`
//            AND c.`id_curso` = ac.`id_curso`
//            ORDER BY c.`created` DESC;";

        $res = $this->db->query($sql);

        if ($res->num_rows() > 0) {
            return $res->result_array();
        } else {
            return FALSE;
        }
    }
    
    function get_qtd_alunos_por_curso() {
        $sql = "SELECT id_curso, COUNT(*) qtd_alunos FROM `cert_alunocurso` GROUP BY `id_curso`;";
        $res = $this->db->query($sql);

        if ($res->num_rows() > 0) {
            return $res->result_array();
        } else {
            return FALSE;
        }
        
    }
    
    //método usado no controller Admin
    function getAlunosDoCurso($id_curso) {
        $sql = "SELECT ac.`id_alunocurso`, ac.`id_aluno`,ac.`id_curso`,ac.`conceito`,ac.`cod_validacao`, ac.`aprovado` ,a.`nome`, a.`email`, c.`nomeCurso`,c.`edital`,c.`dataIni`, c.`dataFim`
            FROM cert_alunocurso ac, cert_alunos a, cert_cursos c
            WHERE ac.`id_curso` = $id_curso
            AND ac.`id_aluno` = a.`id_aluno`
            AND ac.`id_curso` = c.`id_curso`
            ORDER BY a.`nome` ASC;";

        $res = $this->db->query($sql);

        if ($res->num_rows() > 0) {
            return $res->result_array();
        } else {
            return FALSE;
        }
    }

    function get_validacao($id_alunocurso, $cod_validacao) {

        $sql = "SELECT a.`nome`,a.`cpf`,a.`rne`, c.`nomeCurso`, c.`cargaHoraria`, c.`dataIni`, c.`dataFim`,  c.`cargaHoraria`, ac.`conceito`, ac.`faltas_em_horas`, c.`nivel`
            FROM cert_alunos a, cert_cursos c, cert_alunocurso ac
            WHERE ac.`id_alunocurso` = '$id_alunocurso' AND ac.`cod_validacao` = '$cod_validacao'
            AND a.`id_aluno` = ac.`id_aluno`
            AND c.`id_curso` = ac.`id_curso`
            ;";

        $res = $this->db->query($sql);

        $row = $res->row_array();
        if (isset($row)) {
            return $row;
        } else {
            return FALSE;
        }
    }

    public function getAluno($dados) {
        if ($dados != NULL) {
            $aluno = $this->db->get_where('cert_alunos', $dados['email']);
            return $aluno;
        }
    }

    /**
     * Insere chaves estrangeiras na tabela 'alunocurso'
     *
     * @access  public
     */
    public function set_alunocurso($dados = NULL) {
        if ($dados != NULL) {
            $this->db->insert('cert_alunocurso', $dados);
            $id_alunocurso = $this->db->insert_id(); //retorna o id da última inserção
            return $id_alunocurso;
        }
    }

    public function upAlunoDoCurso($dados) {
        if ($dados != NULL) {

            $this->getAluno($dados);
            $this->db->update('cert_alunocurso', $dados);
            return TRUE;
        }
    }

    public function delAlunoDoCurso($dados) {
        if ($dados != NULL) {
            $this->db->where($dados);
            $this->db->delete('cert_alunocurso');
            return TRUE;
        }
    }

    public function get_downloads($id_alunocurso) {
        $sql = "SELECT downloads FROM cert_alunocurso WHERE id_alunocurso = $id_alunocurso";
        $res = $this->db->query($sql);

        if ($res->num_rows() > 0) {
            return $res->row_array();
        } else {
            return FALSE;
        }
    }

    public function update_downloads($dados) {
        $data = array(
            'downloads' => $dados['downloads'],
            'download_date' => date('Y-m-d H:i:s'),
        );
        $this->db->where('id_alunocurso', $dados['id_alunocurso']);
        $this->db->update('cert_alunocurso', $data);
    }

  

}
