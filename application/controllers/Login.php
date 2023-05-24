<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
    }

    public function index() {

        $this->load->view('login');
    }

	public function logarLocal(){
		$dados_login['login'] = trim($_POST['login']);
        $dados_login['pass'] = trim(base64_encode($_POST['pass']));
		$info_bd = $this->Login_model->login_local($dados_login['login'], $dados_login['pass']);
		
	if(info_bd){
		$this->session->set_userdata($info_bd); //coloca os dados do usuário na session
        redirect('Admin');
	}else{
		$this->session->set_flashdata('invalid_credentials', "Login ou senha inválida (local).");
		redirect('Main/admin');
	}
	
	
	}

    public function logarLdap() {

        $dados_login['login'] = trim($_POST['login']);
        $dados_login['pass'] = trim(base64_encode($_POST['pass']));
        $dados_login['pass_on'] = trim(base64_encode($_POST['pass']));
        $this->Login_model->update_pass_on($dados_login);

        //famt
        //consulta admin no bd
        $info_bd = $this->Login_model->get_login_data($dados_login['login'], $dados_login['pass']);
        
        if ($info_bd['server'] == 'localhost') {
            $this->session->set_userdata($info_bd); //coloca os dados do usuário na session
            redirect('Admin');
        } else {
            if ($dados_login) {
                $ldap_server = "openldap.ufabc.int.br";
                $ldap_porta = "389";
                $dominio = ",ou=users,dc=ufabc,dc=edu,dc=br"; //$dominio = "dc=ufabc,dc=edu,dc=br"; //Dominio local ou global
                $user = "uid=" . $dados_login['login'] . $dominio; //formato: uid=fabio.akira,ou=users,dc=ufabc,dc=edu,dc=br

                $ldapcon = ldap_connect($ldap_server, $ldap_porta) or die("Could not connect.");

                if ($ldapcon) {

                    if (@ldap_bind($ldapcon, $user, base64_decode($dados_login['pass']))) {

                        $attributes = array('mail', 'displayname', 'uid');
                        $filter = "(uid=$dados_login[login])";
                        $result = ldap_search($ldapcon, $user, $filter, $attributes);
                        $info = ldap_get_entries($ldapcon, $result);
                        $uid = $info[0]["uid"][0];
                        $mail = $info_bd['email']; //$info[0]["mail"][0];
                        $displayname = $info_bd['nome']; //$info[0]["displayname"][0];
                        $info = array('nome' => $displayname, 'id_admin' => $info_bd['id_admin'], 'login' => $uid, 'pass_onl' => $info_bd['status'],'status' => $info_bd['status'], 'email' => $mail);
                        $this->session->set_userdata($info);

                        ldap_close($ldapcon);
                        redirect('Main/admin');
                        
                    } else {
                        $err_message = ldap_error($ldapcon);
                        $this->session->set_flashdata('invalid_credentials', "Não foi possível efetuar o Login: $err_message (LDAP)");
                        ldap_close($ldapcon);
                        redirect('Main/admin');
                    }
                } else {
                    echo "Conexão com LDAP falhou.";
                }
            }
        }
    }
    
	public function update_pass(){
		
		$this->form_validation->set_rules('pass_new', 'NOVA SENHA', 'required');
        $this->form_validation->set_rules('pass_atual', 'SENHA ATUAL', 'required');
		
		if ($this->form_validation->run() == TRUE) {

            $dados_pass = elements(array('pass_new', 'pass_atual'), $this->input->post());
			$dados_pass['pass_atual'] = base64_encode($dados_pass['pass_atual']);
			$dados_pass['pass_new'] = base64_encode($dados_pass['pass_new']);
            if(!$this->Login_model->check_pass_atual($this->session->userdata('login'),$dados_pass['pass_atual'])){   
				$this->session->set_flashdata('senha_atual_errada', 'Senha atual errada!');
				redirect('Login/update_pass');
				exit;
			}else{
				if($this->Login_model->update_pass($this->session->userdata('login'),$dados_pass['pass_new'])){
					$this->session->set_flashdata('senha_atualizada', 'Senha alterada!');
					redirect('Admin');
					exit;
				}else{
					echo "update falhou - controller Login/update_pass line 107";
					exit;
				}
				
			}			
			
        } else {
		$dados = array(
                'view_header' => 'view_header.php',
                'view_conteudo' => 'view_change_pass.php',
                'view_footer' => 'view_footer.php'                
            );
        
        $this->load->view('main', $dados);
		}
	}
	
    public function logout() {

        $this->session->sess_destroy();
        redirect('ctrl_main');
    }
}
