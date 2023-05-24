<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include_once'./phpqrcode/qrlib.php';

class Editar extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('aluno_model');
        $this->load->model('curso_model');
        $this->load->model('alunocurso_model');
    }

    public function index() {
//        $id_aluno = $this->uri->segment(3);
//        $aluno['aluno'] = $this->aluno_model->get_aluno($id_aluno);
//
//        $this->load->view('formEditarAlunoCurso', $aluno);
    }

    

//    public function editarAlunoCurso() {
//        $this->form_validation->set_rules('nome', 'NOME DO ALUNO', 'trim|required|mb_strtoupper');
//        $this->form_validation->set_rules('email', 'EMAIL CADASTRADO NO CURSO', 'valid_email|trim|required|strtolower');
//
//        if ($this->form_validation->run() == TRUE) {
//            $id_aluno = $this->input->post('id_aluno');
//            $dadosAluno = elements(array('nome', 'email'), $this->input->post());
//            $this->aluno_model->atualizarAluno($id_aluno, $dadosAluno);
////            $aluno['aluno'] = $this->aluno_model->get_aluno($dadosAluno['id_aluno']);
//
////            $this->load->view('editarAlunoCurso', $aluno);
//        }
//        echo 'exibe';
//    }

    public function excluirAlunoCurso($id_aluno) {
        
    }

    /*public function listarCertificadosAluno() {

        $this->form_validation->set_rules('emailAluno', 'EMAIL CADASTRADO NO CURSO', 'valid_email|trim|required|strtolower');

        if ($this->form_validation->run() == TRUE) {
            $emailAluno = elements(array('emailAluno'), $this->input->post());

            $cursosDoAluno['lista'] = $this->alunocurso_model->getCursosDoAluno($emailAluno['emailAluno']);
            $this->load->view('listaCertificadosAluno', $cursosDoAluno);
        }
    }

    public function listarCertificadosCursos() {

        return $this->curso_model->get_all_cursos();
//            $this->load->view('listaCertificadosCursos', $cursos);
    }*/

}
