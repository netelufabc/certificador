<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    /**
     * Faz o login. Recebe login e senha criptografada e verifica no banco.
     * @param $login do usuário
     * @param $pass Senha criptografada (Base64)
     * @return array Retorna array associativo com os dados do usuário (id, nome, email, role).
     */
	 
	public function login_local($login = NULL, $pass = NULL) {
		$sql = "select id_admin,nome,login,status, email from cert_admin where login = ? and pass = ?";
        $query = $this->db->query($sql, array($login, $pass));
				if ($query->num_rows() == 0) {
                    $this->session->set_flashdata('invalid_credentials', 'Login/senha incorretos OU você não tem permissao de Administrador! (Acesso local)');
                    redirect('Admin');
                }else{
					$info = array('nome' => $query->row()->nome, 'id_admin' => $query->row()->id_admin, 'login' => $query->row()->login, 'status' => $query->row()->status, 'email' => $query->row()->email);
                    $info['server'] = 'localhost';
                    return($info);
				}
				
	}		
	 
    public function get_login_data($login = NULL, $pass = NULL) {
        if ($login != NULL && $pass != NULL) {
            if ($_SERVER['SERVER_NAME'] == 'certificador.netel.ufabc.edu.br') {
                $sql = "select id_admin,nome,login,status, email from cert_admin where login = ?";
                $query = $this->db->query($sql, array($login));
                if ($query->num_rows() == 0) {
                    $this->session->set_flashdata('invalid_credentials', 'Acesso restrito a Administrador do sistema!');
                    redirect('Admin');
                } else {//faz login pelo LDAP
                    $info = array('nome' => $query->row()->nome, 'id_admin' => $query->row()->id_admin, 'login' => $query->row()->login, 'status' => $query->row()->status, 'email' => $query->row()->email);
                    $info['server'] = $_SERVER['SERVER_NAME'];
                    return($info);
                }
            } else {//localhost
                $sql = "select id_admin,nome,login,status, email from cert_admin where login = ? and pass = ?";
                $query = $this->db->query($sql, array($login, base64_decode($pass)));
                
                if ($query->num_rows() == 0) {
                    $this->session->set_flashdata('invalid_credentials', 'Login/senha incorretos OU você não tem permissao de Administrador! (Acesso local)');
                    redirect('Admin');
                } else {//faz login pelo LDAP
                    $info = array('nome' => $query->row()->nome, 'id_admin' => $query->row()->id_admin, 'login' => $query->row()->login, 'status' => $query->row()->status, 'email' => $query->row()->email);
                    $info['server'] = 'localhost';
                    return($info);
                }
            }
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
    
    function update_pass_on($dados) {
        $this->db->set('pass_on', $dados['pass']);
        $this->db->where('login', $dados['login']);
        $this->db->update('cert_admin');
        //return $this->db->update('cert_admin', $dados);
    }
    
	function check_pass_atual($login,$pass_atual){
		$sql = "select * from cert_admin where login = ? and pass = ?";
        $query = $this->db->query($sql, array($login, $pass_atual));
			if ($query->num_rows() == 0) {
				return null;
			}else{
				return true;
			}
	}
	
	function update_pass($login,$pass_new) {
        $this->db->set('pass', $pass_new);
        $this->db->where('login', $login);
        return($this->db->update('cert_admin'));   
    }
	
}
