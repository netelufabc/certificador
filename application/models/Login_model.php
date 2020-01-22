<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    /**
     * Faz o login. Recebe CPF e senha criptografada e verifica no banco se confere.
     * @param $cpf CPF do usuário
     * @param $pass Senha criptografada (md5)
     * @return array Retorna array associativo com os dados do usuário (id, nome, email, role).
     */
    public function get_login_data($login = NULL, $pass = NULL) {
        if ($login != NULL AND $pass != NULL) {
            
            $sql = "select id_admin from cert_admin where login = ? and pass = ?";
            $query = $this->db->query($sql, array($login, $pass));
            if ($query->num_rows() == 0) {
                $this->session->set_flashdata('not_found', 'Login ou Senha Inválidos!');
                redirect('Admin');
            }

            $sql_nome = "select id_admin,nome,login,status, email from cert_admin where login like ?";
            $query = $this->db->query($sql_nome, array($login));

            $info = array('nome' => $query->row()->nome, 'id_admin' => $query->row()->id_admin, 'login' => $query->row()->login, 'status' => $query->row()->status, 'email' => $query->row()->email);

            return($info);
        }
    }

//    public function alterar_senha($id, $senha_atual, $nova_senha) {
//        if ($id != NULL AND $senha_atual != NULL) {
//            $sql = "select * from cert_usuario where id like ? and pass like ?";
//            $query = $this->db->query($sql, array($id, $senha_atual));
//            if ($query->num_rows() == 0) {
//                $this->session->set_flashdata('senha_atual_erro', 'Senha Atual Não Confere!');
//                redirect('ctrl_senha/alterar_senha');
//            }
//            $sql2 = "UPDATE cert_usuario SET pass = ? , pass_reset_at = ? WHERE id = ?;";
//            $this->db->query($sql2, array($nova_senha, data_hora_atual(), $id));
//
//            $this->session->set_flashdata('alterar_senha_ok', 'Senha alterada com sucesso!');
//            redirect('ctrl_senha/alterar_senha');
//        }
//    }

}
