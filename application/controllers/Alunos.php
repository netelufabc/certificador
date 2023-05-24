<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include_once'./phpqrcode/qrlib.php';

class Alunos extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('aluno_model');
        $this->load->model('curso_model');
        $this->load->model('alunocurso_model');
        $this->load->helper('custom');
    }

    public function index() {
        
    }

    public function enviarCertificadoAluno() {

        $dados = array(
            'id_aluno' => $this->uri->segment(3),
            'id_curso' => $this->uri->segment(4),
            'id_alunocurso' => $this->uri->segment(5),
            'cod_validacao' => $this->uri->segment(6),
            'email' => urldecode($this->uri->segment(7)),
        );

        $dados['nomeCurso'] = $this->curso_model->get_curso($dados['id_curso'])['nomeCurso'];
        $dados['link'] = anchor('GerarPdf/gerarFpdf/' . $dados['id_aluno'] . '/' . $dados['id_curso'] . '/' . $dados['id_alunocurso'] . '/' . $dados['cod_validacao'], 'CERTIFICADO', 'target="blank"');

        //variável para receber texto de e-mail personalizado (falta implementar)
        $dados['corpo'] = NULL;

        if (enviar($dados)) {
            $dados['enviado'] = 1;
            $dados['nomeCurso'] = $dados['nomeCurso'];
            $this->session->set_flashdata('enviada_notificacao_ok', 'Aluno notificado por e-mail.');
//            redirect("Alunos/listarCertificadosDoAluno/" . urlencode($dados['email']));
            $this->listarCertificadosDoAluno($dados);
            //header("Location: http://https://netel.ufabc.edu.br/certificador/Alunos/enviarCertificadoAluno/$dados[id_curso]");
        }
    }

    public function listarCertificadosDoAluno($dadosRecebidos = NULL) {

        // $_SESSION['aba_atual'] = 2;
//        if (isset($dadoEmail)){
//            $text = urldecode($dadoEmail);
//        }

        $text = trim(element('textBusca', $this->input->post()));

        if(isset($dadosRecebidos['email'])){//dado vindo pelo link de envio do certificado
            $text = urldecode($dadosRecebidos['email']);
        } elseif (isset($dadosRecebidos)) {//info vindo do link da lista de nomes (resultado da busca por nomes)
            $text = urldecode($dadosRecebidos);
            $dadosRecebidos = array();
        }

        //verifica se o campo foi preenchido com email ou nome
        if (isset($text) && $text!= NULL) {
            if (!strpos($text, '@')) {//busca pelo NOME
                $dadosRecebidos['nomes'] = $this->aluno_model->get_aluno_nome($text);
                
            } else {//busca por E-MAIL
                $dadosRecebidos['lista'] = $this->alunocurso_model->getCursosDoAluno($text);
            }

            //se não tem o nome ou e-mail cadastrado envia msg de erro
            if ((isset($dadosRecebidos['nomes']) && $dadosRecebidos['nomes'] == FALSE) || (isset($dadosRecebidos['lista']) && $dadosRecebidos['lista'] == FALSE)) {
                $dadosRecebidos['error'] = 'Não há certificados disponíveis para: ';
                $dadosRecebidos['email'] = $text;
            }
        }

        if (isset($dadosRecebidos['enviado']) && $dadosRecebidos['enviado'] == 1) {
            $dadosRecebidos['msg'] = "Evento:<b> " . $dadosRecebidos['nomeCurso'] . "</b><br/><br/>"
                    . "Enviado para: <b>" . $dadosRecebidos['email'] . "</b>";
        }

        $dadosRecebidos['view_header'] = "view_header.php";
        $dadosRecebidos['view_conteudo'] = "view_certificados_do_aluno.php";
        $dadosRecebidos['view_footer'] = "view_footer.php";

        $this->load->view('main', $dadosRecebidos);
    }

//    public function exibirEditAluno() {
//
//        $id_aluno = $this->uri->segment(3);
//        $aluno['aluno'] = $this->aluno_model->get_aluno($id_aluno);
//        $this->load->view('editAluno', $aluno);
//    }
//    public function editarAluno() {
//
//        $id_aluno = element('id_aluno', $this->input->post());
//
//        $ruleEmail['ruleEmail'] = array(
//            'field' => 'email',
//            'label' => 'E-MAIL',
//            'rules' => 'is_unique[alunos.email]');
////            'rules' => 'valid_email|trim|required|strtolower|is_unique[alunos.email]');
//        $this->form_validation->set_rules('nome', 'NOME DO ALUNO', 'trim|required|mb_strtoupper');
//        $this->form_validation->set_rules($ruleEmail);
//
//        if ($this->form_validation->run('ruleEmail') == FALSE) {
//            $this->aluno_model->delAluno($id_aluno);
////            $aluno = $this->alunocurso_model->getAluno($id_aluno);
//        }
//
//        if ($this->form_validation->run() == TRUE) {
//
//            $dadosAluno = elements(array('nome', 'email'), $this->input->post());
//            $ok = $this->aluno_model->atualizarAluno($id_aluno, $dadosAluno);
////            $aluno['aluno'] = $this->aluno_model->get_aluno($dadosAluno['id_aluno']);
////            $this->load->view('editarAlunoCurso', $aluno);
//        }
//        if ($ok) {
//            $this->listarAlunosDoCurso();
//        } else {
//            echo 'ERRO';
//        }
//    }

    public function excluirAlunoDoCurso() {
        $id_curso = $this->uri->segment(5);
        
        $dados = array(
            'id_alunocurso' => $this->uri->segment(3),
            'id_aluno' => $this->uri->segment(4),
            'id_curso' => $this->uri->segment(5),
        );
        if($this->alunocurso_model->delAlunoDoCurso($dados)){
            $this->session->set_flashdata('inserir_alunos_ok', 'Inscrição cancelada!');
            redirect('Admin/listarAlunosDoCurso/'.$id_curso);
    }

    }

    public function listarCertificadosCursos() {
        return $this->curso_model->get_all_cursos();
    }

}
