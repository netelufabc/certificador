<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_log extends CI_Model {

    function get_all_notifs_course($id_curso) {
        $res = $this->db->query("select * from cert_log_notificacao where cert_log_notificacao.id_curso = ?", array($id_curso))->row();
        return $res;
    }

    function set_last_sent_notif_all($dados_notif) { //type = single or all
        $ja_notificado = $this->get_sent_user_in_course($dados_notif['id_curso'], $dados_notif['id_aluno']);
        if ($ja_notificado) {
            $this->db->where('id_notificacao', $ja_notificado['id_notificacao']);
            $this->db->update('cert_log_notificacao', $dados_notif);
        } else {
            $this->db->insert('cert_log_notificacao', $dados_notif);
        }
    }

    function get_last_sent_notif_single($id_curso, $id_aluno) {
        return($this->db->query("select * from cert_log_notificacao where cert_log_notificacao.id_curso = ? 
                and cert_log_notificacao.`id_aluno` = ?", array($id_curso, $id_aluno))->row());
    }

    function set_last_sent_notif($dados_notif) { //type = single or all
        $ja_notificado = $this->get_last_sent_notif_single($dados_notif['id_curso'], $dados_notif['id_aluno']);
        if ($ja_notificado) {
            $this->db->where('id_curso', $dados_notif['id_curso']);
            $this->db->where('id_aluno', $dados_notif['id_aluno']);
            $this->db->update('cert_log_notificacao', $dados_notif);
        } else {
            $this->db->insert('cert_log_notificacao', $dados_notif);
        }
//        $this->session->set_flashdata('enviada_notificacao_ok','Aluno notificado por e-mail.');
//        redirect("Admin/listarAlunosDoCurso/$dados_notif[id_curso]");
    }
    
    //famt -
    function get_sent_user_in_course($id_curso, $id_aluno) {
        $this->db->where('id_curso', $id_curso);
        $this->db->where('id_aluno', $id_aluno);
        $this->db->select('id_notificacao');
        $query = $this->db->get('cert_log_notificacao');
        
        return $query->row_array();
    }
    
	//famt - 02/08/2020
    function get_sent_to_user($id_curso) {
        $this->db->where('id_curso', $id_curso);
        $this->db->select('id_aluno');
        $query = $this->db->get('cert_log_notificacao');
        
        if ($query->num_rows() > 0) {
            $res = array();
            foreach ($query->result_array() as $row) {
                array_push($res, $row['id_aluno']);
            }
            return $res;
        } else {
            return FALSE;
        }
    }
	
    //todas as notificações agrupadas por curso
    function get_sent() {
//        $this->db->where('type', 'all');
        $this->db->group_by('id_curso');
        $query = $this->db->get('cert_log_notificacao');
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
        
    function get_qtd_enviados_por_curso() {
        $sql = "SELECT `id_curso`, COUNT(*) qtd_alunos  FROM `cert_log_notificacao` GROUP BY `id_curso`;";
        $res = $this->db->query($sql);

        if ($res->num_rows() > 0) {
            return $res->result_array();
        } else {
            return FALSE;
    }
    }

    ////////////////////popular tabela de log
    //        $d = $this->Model_log->get_all_alunoCurso();
//        foreach ($d as $value) {
//            $value['last_sent_by'] = 'adm';
//            $value['last_sent'] = date('Y-m-d H:i:s');
//            $r = $this->Model_log->set_all_alunoCurso($value);
//        }
    //Código acima colocar no link do menu NOTIFICAR PARTICIPANTES
    
      public function get_all_alunoCurso() {
        $this->db->select('id_curso,id_aluno');
        $query = $this->db->get('cert_alunocurso');
        return $query->result_array();
}
    
    function set_all_alunoCurso($dados){
        $this->db->insert('cert_log_notificacao', $dados);
    }
    

}
