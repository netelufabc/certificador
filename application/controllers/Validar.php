﻿<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Validar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('alunocurso_model');
    }

    public function index() {
        $_SESSION['aba_atual'] = 1;
        $dados = array(
        );

        if (isset($_GET['cod_validacao']) && $_GET['cod_validacao'] != NULL && $_GET['cod_validacao'] != '') {
            $cod_url = str_replace(" ", "", trim($_GET['cod_validacao']));
        } elseif (isset($_POST['cod_validacao']) && $_POST['cod_validacao'] != NULL && $_POST['cod_validacao'] != '') {
            $cod_url = str_replace(" ", "", trim($_POST['cod_validacao']));
        }
        if ($cod_url != NULL && $cod_url != FALSE && $cod_url != '') {
            
            $comp = strlen($cod_url);
            $cod = substr($cod_url, -3);
            $id = substr($cod_url, 0, $comp - 3);
            $res = $this->alunocurso_model->get_validacao($id, $cod);

            if ($res != FALSE) {
                $dados = array_merge($dados, $res);
            } else {
                $dados['cod_invalido'] = 'CÓDIGO INVÁLIDO';
            }

            $dados['view_header'] = "view_header.php";
            $dados['view_conteudo'] = "aba_validar.php";
            $dados['view_footer'] = "view_footer.php";

            $this->load->view('main', $dados);
        }
    }

}
