<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public function index() {

        $dados = array(
            'view_header' => 'view_header.php',
            'view_conteudo' => 'aba_gerar',
            'view_footer' => 'view_footer.php',
        );
        $this->load->view('main', $dados);
    }

    public function gerar_certificado() {

        $dados = array(
            'view_header' => 'view_header.php',
            'view_conteudo' => 'aba_gerar.php',
            'view_footer' => 'view_footer.php',
        );
        $this->load->view('main', $dados);
    }

    public function validar_certificado() {

        $dados = array(
            'view_header' => 'view_header.php',
            'view_conteudo' => 'aba_validar.php',
            'view_footer' => 'view_footer.php',
        );
        $this->load->view('main', $dados);
    }

    public function admin() {

        if (isset($_SESSION['status']) && $_SESSION['status'] == 1) {
            redirect('Admin');
        } else {
            $dados = array(
                'view_header' => 'view_header.php',
                'view_conteudo' => 'login.php',
                'view_footer' => 'view_footer.php',
            );
            $this->load->view('main', $dados);
        }
    }

}
