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

    public function logar() {

        $_SESSION['aba_atual'] = 3;
        $this->form_validation->set_rules('login', 'LOGIN', 'required|trim');
        $this->form_validation->set_rules('pass', 'SENHA', 'required|trim');

        if ($this->form_validation->run() == TRUE) {
            $dados_login = elements(array('login', 'pass'), $this->input->post());
            $dados_login['pass'] = $dados_login['pass']; //md5($dados_login['pass']);
            $info = $this->Login_model->get_login_data($dados_login['login'], $dados_login['pass']);

            $this->session->set_userdata($info); //coloca os dados do usuário na session
//            $this->session->sess_destroy();
//            $this->load->view('main');
            redirect('Admin');
        }
    }

    public function logarLdap() {

        $dados_login = elements(array('login', 'pass'), $this->input->post());

        if ($dados_login) {
            $ldap_server = "openldap.ufabc.int.br";
            $ldap_porta = "389";
            $dominio = ",ou=users,dc=ufabc,dc=edu,dc=br"; //$dominio = "dc=ufabc,dc=edu,dc=br"; //Dominio local ou global
            $user = "uid=" . $dados_login['login'] . $dominio; //formato: uid=fabio.akira,ou=users,dc=ufabc,dc=edu,dc=br

            $ldapcon = ldap_connect($ldap_server, $ldap_porta) or die("Could not connect.");

            if ($ldapcon) {

                if (@ldap_bind($ldapcon, $user, $dados_login['pass'])) {

                    $attributes = array('mail', 'displayname', 'uid');
                    $filter = "(uid=$dados_login[login])";

                    $result = ldap_search($ldapcon, $user, $filter, $attributes);
                    $info = ldap_get_entries($ldapcon, $result);

                    $uid = $info[0]["uid"][0];

                    if ($uid == "gustavo.castilho" || $uid == "fabio.akira" || $uid == "fernanda.a") {//fazer dinamico
                        $mail = $info[0]["mail"][0];
                        $displayname = $info[0]["displayname"][0];

                        $info = array('nome' => $displayname, 'id_admin' => 1, 'login' => $uid, 'status' => 1, 'email' => $mail);
                        $this->session->set_userdata($info);

                        ldap_close($ldapcon);
                        redirect('Main/admin');
                    } else {
                        $this->session->set_flashdata('invalid_credentials', "Não foi possível efetuar o Login: usuário não autorizado");
                        ldap_close($ldapcon);
                        redirect('Main/admin');
                    }
                } else {
                    $err_message = ldap_error($ldapcon);
                    $this->session->set_flashdata('invalid_credentials', "Não foi possível efetuar o Login: $err_message");
                    ldap_close($ldapcon);
                    redirect('Main/admin');
                }
            } else {
                echo "Conexão com LDAP falhou.";
            }
        }
    }

//    public function logout() {
//
//        $this->session->sess_destroy();
//        redirect('ctrl_main');
//    }
}
