<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_log extends CI_Model {

    function get_last_sent_notif_all($id_curso) {
        $res = $this->db->query("select * from cert_log_notificacao where cert_log_notificacao.id_curso = ? 
                and cert_log_notificacao.`type` = 'all'", array($id_curso))->row();
        return $res;
    }

    function set_last_sent_notif_all($dados_notif) { //type = single or all
        $ja_notificado = $this->get_last_sent_notif_all($dados_notif['id_curso']);
        if ($ja_notificado) {
            $this->db->where('id_curso', $dados_notif['id_curso']);
            $this->db->update('cert_log_notificacao', $dados_notif);
        } else {
            $this->db->insert('cert_log_notificacao', $dados_notif);
        }
    }

    function get_last_sent_notif_single($id_curso, $id_aluno) {
        return($this->db->query("select * from cert_log_notificacao where cert_log_notificacao.id_curso = ? 
                and cert_log_notificacao.`type` = 'single' and cert_log_notificacao.`id_aluno` = ?", array($id_curso, $id_aluno))->row());
    }

    function set_last_sent_notif_single($dados_notif) { //type = single or all
        $ja_notificado = $this->get_last_sent_notif_single($dados_notif['id_curso'], $dados_notif['id_aluno']);
        if ($ja_notificado) {
            $this->db->where('id_curso', $dados_notif['id_curso']);
            $this->db->update('cert_log_notificacao', $dados_notif);
        } else {
            $this->db->insert('cert_log_notificacao', $dados_notif);
        }
        $this->session->set_flashdata('enviada_notificacao_ok','Aluno notificado por e-mail.');
        redirect("Admin//listarAlunosDoCurso/$dados_notif[id_curso]");
    }
    
    function get_sent_to_all() {
        $this->db->where('type', 'all');
        $this->db->group_by('id_curso');
        $query = $this->db->get('cert_log_notificacao');
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
        
    }

}
