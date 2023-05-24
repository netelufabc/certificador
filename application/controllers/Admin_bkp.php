<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('aluno_model');
        $this->load->model('curso_model');
        $this->load->model('alunocurso_model');
        $this->load->model('certificado_model');
        $this->load->model('Model_log');
        //$this->load->model('Model_nivel_idiomas');
        $this->load->library('csvimport');
        $this->load->helper('array');
        $this->load->helper('custom');
    }

    public function index() {

        if (!isset($_SESSION['status']) || !$_SESSION['status'] > 0) {
            $dados = array(
                'view_header' => 'view_header.php',
                'view_conteudo' => 'login.php',
                'view_footer' => 'view_footer.php',
            );
            $this->load->view('main', $dados);
        } else {

            $listaCursos = $this->curso_model->get_all_cursos();

            $dados = array(
                'view_header' => 'view_header.php',
                'view_conteudo' => 'view_listaCursos.php',
                'view_footer' => 'view_footer.php',
                'listaCursos' => $listaCursos
            );
            $this->load->view('main', $dados);
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('Admin');
    }

    public function editar_curso() { //função para edição dos cursos (GUC)
        $id = $this->uri->segment(3);

        $dados_curso = $this->curso_model->get_curso($id);

        $this->form_validation->set_rules('nomeCurso', 'NOME DO CURSO', 'trim|required');
        $this->form_validation->set_rules('cargaHoraria', 'CARGA HORÁRIA', 'required|is_natural');
        $this->form_validation->set_rules('dataInicio', 'Data de Início', 'required');
        $this->form_validation->set_rules('dataFim', 'Data de Fim', 'required');

        if ($this->form_validation->run() == TRUE) {
            $dados_curso = elements(array('nomeCurso', 'edital', 'dataInicio', 'dataFim', 'cargaHoraria'), $this->input->post());
            $data_inicio = data_converte_mysql_br($dados_curso['dataInicio']);
            $data_fim = data_converte_mysql_br($dados_curso['dataFim']);
            $dados_form = array(
                'nomeCurso' => $dados_curso['nomeCurso'],
                'edital' => $dados_curso['edital'],
                'dataIni' => $data_inicio,
                'dataFim' => $data_fim,
                'cargaHoraria' => $dados_curso['cargaHoraria']
            );

            $this->curso_model->update_curso($dados_form, $id);
        }

        $dados = array(
            'dados_do_curso' => $dados_curso,
            'curso_id' => $this->uri->segment(3),
            'view_header' => 'view_header.php',
            'view_conteudo' => 'view_edit_curso.php',
            'view_footer' => 'view_footer.php',
        );

        $this->load->view('main', $dados);
    }

    /**
     * Verificar se todos os e-mails do csv estão corretos.
     * Retorna NULL se estiver tudo certo, array com e-mails incorretos se houver ao menos um errado.
     *
     * @param $csv_array array de e-mails do csv.
     * @return string array de strings de e-mails errados ou NULL se estiver tudo certo.
     */
    public function validaCsv($csv_array) {

        $listaError = array();
        $line = 2; //indicar a linha do csv
        foreach ($csv_array as $row) {
            if (!$this->validaEmail($row['email'])) {
                $row['line'] = $line;
                array_push($listaError, $row);
            }
            $line++;
        }
        return $listaError;
    }

    public function cadastrarNovoCurso() {//nova
        $this->form_validation->set_rules('edital', 'EDITAL', 'trim|required|mb_strtoupper');
        $this->form_validation->set_rules('nomeCurso', 'NOME DO CURSO', 'trim|required');
        $this->form_validation->set_rules('cargaHoraria', 'CARGA HORÁRIA', 'trim|required');
        if ($this->form_validation->run() == TRUE) {

            $dados_curso = elements(array('nomeCurso', 'edital', 'dataInicio', 'dataFim', 'cargaHoraria', 'mod_certificado','nivel'), $this->input->post());
            $nomeCurso = mb_strtoupper($dados_curso['nomeCurso']);
            $edital = $dados_curso['edital'];
            $dataIni = data_converte_mysql_br($dados_curso['dataInicio']);
            $dataFim = data_converte_mysql_br($dados_curso['dataFim']);
            $cargaHoraria = $dados_curso['cargaHoraria'];
            $id_certificado = $dados_curso['mod_certificado'];
            $nivel = $dados_curso['nivel'];
            
            $dados_form = array(
                'nomeCurso' => $nomeCurso,
                'edital' => $edital,
                'dataIni' => $dataIni,
                'dataFim' => $dataFim,
                'cargaHoraria' => $cargaHoraria,
                'id_certificado' => $id_certificado,
                'nivel' => $nivel,
            );
            $id_curso = $this->curso_model->set_curso($dados_form);
            $this->session->set_flashdata('novo_curso_ok', "Curso criado com sucesso!");
            redirect('Admin');
        } else {
            $modelos_certificados = $this->certificado_model->get_allCertificados();
            $dados = array(
                'view_header' => 'view_header.php',
                'view_conteudo' => 'view_novo_curso.php',
                'view_footer' => 'view_footer.php',
                'modelos_certificados' => $modelos_certificados,
            );
        }
        $this->load->view('main', $dados);
    }

    function inserir_alunos_novo_curso() {

        if ($this->uri->segment(3) != null) {

            $id_curso = $this->uri->segment(3);

            $dados_curso = $this->curso_model->get_curso($id_curso);
            $modelos_certificados = $this->certificado_model->get_allCertificados();

            $dados = array(
                'view_header' => 'view_header.php',
                'view_conteudo' => 'view_inserir_aluno_novo_curso.php',
                'view_footer' => 'view_footer.php',
                'dadosCurso' => $dados_curso,
                //'modelos_certificados' => $modelos_certificados,                    
            );
            $this->load->view('main', $dados);
        } else {

            $listaCursos = $this->curso_model->get_all_cursos();
            $dados = array(
                'view_header' => 'view_header.php',
                'view_conteudo' => 'view_inserir_aluno_novo_curso.php',
                'view_footer' => 'view_footer.php',
                'listaCursos' => $listaCursos,
            );
            $this->load->view('main', $dados);
        }
    }

    function notificar_participantes() {
        if ($this->uri->segment(3) != null) {

            $id_curso = $this->uri->segment(3);

            $dados_curso = $this->curso_model->get_curso($id_curso);
            $listaAlunos = $this->alunocurso_model->getAlunosDoCurso($id_curso);
            $last_notif = $this->Model_log->get_last_sent_notif_all($id_curso);

            $dados = array(
                'view_header' => 'view_header.php',
                'view_conteudo' => 'view_notificar_participantes.php',
                'view_footer' => 'view_footer.php',
                'dadosCurso' => $dados_curso,
                'listaAlunos' => $listaAlunos,
                'last_notif' => $last_notif
            );
            $this->load->view('main', $dados);
        } else {
            $enviados_all = $this->Model_log->get_sent_to_all();
            $listaCursos = $this->curso_model->get_all_cursos();

            $dados = array(
                'view_header' => 'view_header.php',
                'view_conteudo' => 'view_notificar_participantes.php',
                'view_footer' => 'view_footer.php',
                'listaCursos' => $listaCursos,
                'enviados_all' => $enviados_all
            );
            $this->load->view('main', $dados);
        }
    }

    function notificar_now() {

        $id_curso = $this->uri->segment(3);
        $nome_curso = $this->curso_model->get_curso($id_curso);
        $alunos = $this->alunocurso_model->getAlunosDoCurso($id_curso);

        foreach ($alunos as $aluno) {

            $dadosEmailCert = array(
                'id_aluno' => $aluno['id_aluno'],
                'id_curso' => $id_curso,
                //'id_certificado' => element('mod_certificado', $this->input->post()),
                'conceito' => strtoupper($aluno['conceito']),
                'cod_validacao' => $aluno['cod_validacao'],
                'status' => $aluno['status'],
            );

            $id_alunocurso = $aluno['id_alunocurso'];

            $dadosEmailCert['id_alunocurso'] = $id_alunocurso;
            $dadosEmailCert['email'] = $aluno['email'];
            $dadosEmailCert['nomeCurso'] = $nome_curso['nomeCurso'];
            
            $msg_adicional = NULL;
            if($nome_curso['id_certificado']==3){
                $msg_adicional = 'Contato: linguas.netel@ufabc.edu.br';
            }
            
            if ($aluno['status'] == 'aprovado' || $aluno['status'] == NULL) {//envia somente para aprovados
                $link = anchor('GerarPdf/gerarFpdf/' . $dadosEmailCert['id_aluno'] . '/' . $dadosEmailCert['id_curso'] . '/' . $id_alunocurso . '/' . $dadosEmailCert['cod_validacao'], 'CERTIFICADO', 'target="blank"');
                $dadosEmailCert['corpo'] = utf8_decode("O Núcleo Educacional de Tecnologias e Línguas - UFABC informa que o certificado do curso:<br/><br/> <b>$dadosEmailCert[nomeCurso]</b><br/><br/> está disponível no link a seguir: $link.<br/><br/>"
                        . "<br/>$msg_adicional"
                        . "<br/><br/><br/>--- Mensagem automática do sistema ---");

                enviar($dadosEmailCert);
            }
        }
        $dados_notificação = array(
            'id_curso' => $id_curso,
            'type' => 'all',
            'id_aluno' => null,
            'last_sent_by' => $this->session->userdata('login'),
            'last_sent' => date('Y-m-d H:i:s')
        );
        $this->Model_log->set_last_sent_notif_all($dados_notificação);
        $this->session->set_flashdata('notificacao_ok', "Alunos notificados por e-mail! ");
        redirect('Admin/notificar_participantes');
    }

    function inserir_do_csv() {//recebe e trata o arquivo .CSV
        $id_curso = $this->uri->segment(3);
        $dados_curso = $this->curso_model->get_curso($id_curso);

        $file_path = $this->uploadCsv($dados_curso['edital']);

//acessa o arquivo CSV que foi salvo no server
        $csv_array = $this->csvimport->get_array($file_path);

        if ($csv_array) {

            if ($this->validaCsv($csv_array) != NULL) {//tratar aqui
                $listaError = $this->validaCsv($csv_array);
                unlink("$file_path");

                $dados = array(
                    'listaError' => $listaError,
                    'view_header' => 'view_header.php',
                    'view_conteudo' => 'listaErrorCsv.php',
                    'view_footer' => 'view_footer.php'
                );

                $this->load->view('main', $dados);
            } else {


                foreach ($csv_array as $row) {
                    $aluno = $this->cadastrarAlunoPorCsv($row); //insere na tabela alunos
                    $cod_validacao = $this->randomPassword();//gera cod. de validacao

                    $dadosEmailCert = array(
                        'id_aluno' => $aluno['id_aluno'],
                        'id_curso' => $id_curso,
                        'id_certificado' => element('mod_certificado', $this->input->post()),
                        'conceito' => strtoupper($row['conceito']),
                        'cod_validacao' => $cod_validacao,
                        'status' => strtolower($row['status']),
                        'faltas_em_horas' => $row['faltas_em_horas'],
                    );

                    $this->cadastrarAlunoCurso($dadosEmailCert, $dados_curso); //insere na tabela alunocurso
                }
                $this->session->set_flashdata('inserir_alunos_ok', "Alunos inseridos no curso!");
                redirect('Admin');
            }
        }//csv_array true
    }

    //cadastra o aluno na tabela ALUNOS; Não insere duplicado;
    public function cadastrarAlunoPorCsv($rowAluno) {

        $rowAluno['email'] = strtolower($rowAluno['email']);
        
        // verifica se o e-mail já está cadastrado na tabela 'alunos'
        $aluno = $this->aluno_model->get_aluno_by_email($rowAluno['email']);
        if ($aluno == NULL || $aluno == FALSE) {//se o e-mail ainda não está cadastrado, insere na tabela alunos
            $rowAluno['nome'] = utf8_decode($rowAluno['nome']); //famt correção UTF8 no bd
            
            unset($rowAluno['conceito']);
            unset($rowAluno['status']);
            unset($rowAluno['faltas_em_horas']);
            $rowAluno['id_aluno'] = $this->aluno_model->set_aluno($rowAluno); //inserindo na tabela alunos
            return $rowAluno;
        } else {
            //aluno já cadastrado; verificar se já consta CPF/RNE
            $dados = array(
                'id_aluno' => $aluno['id_aluno'],
                'cpf' => $rowAluno['cpf'],
                'rne' => $rowAluno['rne'],
            );
            
            if ($rowAluno['cpf'] != '' && $aluno['cpf'] == '' || $rowAluno['rne'] != '' && $aluno['rne'] == ''){
                $this->aluno_model->update_Cpf_Rne($dados);
                $aluno['cpf'] = $rowAluno['cpf'];
                $aluno['rne'] = $rowAluno['rne'];
            }
        }
        return $aluno;
    }

    public function cadastrarAlunoCurso($dadosAlunoCurso, $dados_curso) {

        //verifica se o aluno já está cadastrado no curso para não gerar duplicidade de certificado
        $alunoTemp = $this->alunocurso_model->get_alunocursoRedundante($dadosAlunoCurso['id_aluno'], $dados_curso['id_curso']);

        if ($alunoTemp['id_aluno'] != $dadosAlunoCurso['id_aluno'] && $alunoTemp['id_curso'] != $dados_curso['id_curso']) {
            $id_alunocurso = $this->alunocurso_model->set_alunocurso($dadosAlunoCurso);
			return $id_alunocurso;
			//alteração GUC 15/01/2020
        }else{//adiconado este bloco para não retornar NULL e dar pau (GUC)
            return $alunoTemp['id_alunocurso'];
        }
		//fim alteração GUC 15/01/2020
		
       // }

       // return $id_alunocurso;
    }

    public function listarCertificadosAluno() {

        $this->form_validation->set_rules('emailAluno', 'EMAIL CADASTRADO NO CURSO', 'valid_email|trim|required|strtolower');

        if ($this->form_validation->run() == TRUE) {
            $emailAluno = elements(array('emailAluno'), $this->input->post());

            $cursosDoAluno['lista'] = $this->alunocurso_model->getCursosDoAluno($emailAluno['emailAluno']);
            $this->load->view('listaCertificadosAluno', $cursosDoAluno);
        }
    }

    public function uploadCsv($edital_curso) {
        $data['error'] = '';
// Define as configurações para o upload do CSV
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';

//renomeia o csv com o nome do edital e login de quem fez o upload
        //$form = elements(array('edital'), $this->input->post());
        //$form = elements(array('edital'), $this->input->post());
//        $config['file_name'] = $form['edital'] . '_' . $_SESSION['login'] . '.csv';
        $config['file_name'] = $edital_curso . '_' . $_SESSION['login'] . '.csv';


//renomeia o csv com o nome do edital e login de quem fez o upload
        //$form = elements(array('edital'), $this->input->post());
//        $config['file_name'] = $form['edital'] . '_' . $_SESSION['login'] . '.csv';
        $config['file_name'] = $edital_curso . '_' . $_SESSION['login'] . '.csv';

        $this->load->library('upload', $config);
// Se o upload falhar, exibe mensagem de erro na view
        if (!$this->upload->do_upload('csvfile')) {
            $data['error'] = $this->upload->display_errors();
            $this->session->set_flashdata('no_file_selected', "Arquivo não selecionado ou inválido!");
            redirect('Admin/inserir_alunos_novo_curso');
        } else {
            $file_data = $this->upload->data();
            $file_path = './uploads/' . $file_data['file_name'];
            return $file_path;
        }
    }

    function validaEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

// Essa função era utilizada quando o nível era atribuído ao aluno. 
// Após alterações, o nível passou a ser atribuído aos cursos e esta função deixou de ser usada.
//    function validaNivel($nivel) {
//        //Define os tipos de níveis para Línguas
//        $niveis_tipos = NiveisLinguas();//em caso de alteração de níveis, definir os níveis neste método no arquivo custom_helper
//        
//        //PARA LÍNGUAS: verificar os níveis de línguas antes de inserir no bd
//        if (!is_null($nivel)) {
//            
//            $n = strtoupper($nivel);
//
//            foreach ($niveis_tipos as $key => $value) {//array associativo: verifica o índice
//                if ($key != $n) {
//                    continue;
//                } else {
//
//                    return TRUE;
//                }
//            }
//            return FALSE;
//        }
//    }

    /**
     * Gera senha aleat?ria de 6 d?gitos com n?meros e letras min?sculas apenas. Para incluir outros caracteres, adicionar na string da vari?vel "alphabet".
     * @return string Retorna a senha em string.
     */
    function randomPassword() {
        $alphabet = '23456789abcdefghijkmnpqrstuvwxyz';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 3; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

//    public function excluirCurso() {
//        $id_curso = $this->uri->segment(3);
//        $this->curso_model->delCurso($id_curso);
//        redirect("Admin");
//    }

    public function listarAlunosDoCurso() {

        $id_curso = $this->uri->segment(3);
        $listaAlunos = $this->alunocurso_model->getAlunosDoCurso($id_curso);

        if ($listaAlunos) {
            $dados = array(
                'view_header' => 'view_header.php',
                'view_conteudo' => 'listaAlunosDoCurso',
                'view_footer' => 'view_footer.php',
                'listaAlunos' => $listaAlunos,
                'id_curso' => $id_curso
            );
        } else {//trabalhar aqui, caso nao retorne nada do banco, ou seja, caso nao tenha alunos no curso
            $curso = $this->curso_model->get_curso($id_curso);
            $dados = array(
                'view_header' => 'view_header.php',
                'view_conteudo' => 'listaAlunosDoCurso',
                'view_footer' => 'view_footer.php',
                'curso' => $curso
            );
        }
        $this->load->view('main', $dados);
    }

    public function editar_aluno() {

        $id_curso = $this->uri->segment(3);
        $id_aluno = $this->uri->segment(4);
//        $id_nivel_idiomas = $this->Model_nivel_idiomas->GetIdNivelIdiomas($id_aluno, $id_curso);

        $dados_aluno = $this->aluno_model->get_aluno_por_curso($id_aluno, $id_curso);

        $this->form_validation->set_rules('nomeAluno', 'NOME DO ALUNO', 'trim|required');
        $this->form_validation->set_rules('email', 'E-MAIL', 'required');
        //$this->form_validation->set_rules('conceito', 'CONCEITO', 'required');
        $this->form_validation->set_rules('status', 'STATUS', 'required');

        if ($this->form_validation->run() == TRUE) {
            $dados_aluno = elements(array('nomeAluno', 'email', 'conceito', 'status', 'faltas_em_horas', 'nivel_idiomas', 'cpf', 'rne'), $this->input->post());
			
          //  $nivel_idiomas = $dados_aluno['nivel_idiomas'];
            unset($dados_aluno['nivel_idiomas']);
          //  if ($id_nivel_idiomas == NULL && $nivel_idiomas != NULL) {//GUC 15/01/2020 comentado para parar de dar pau na alteração de dados do aluno
         //       $this->Model_nivel_idiomas->InsertNewRow($id_aluno, $id_curso, $nivel_idiomas);
         //   } else {
         //       $this->Model_nivel_idiomas->UpdateNivelIdiomas($id_nivel_idiomas, $nivel_idiomas);
         //   }
            $this->aluno_model->update_aluno($dados_aluno, $id_curso, $id_aluno);
        }

        $dados = array(
          //  'nivel_idiomas' => $this->Model_nivel_idiomas->GetNivelAlunoIdiomas($id_aluno, $id_curso),//GUC 15/01/2020 comentado para parar de dar pau na alteração de dados do aluno.  Olhar view também comentada
            'dados_aluno' => $dados_aluno,
            'id_curso' => $this->uri->segment(3),
            'id_aluno' => $this->uri->segment(4),
            'view_header' => 'view_header.php',
            'view_conteudo' => 'view_edit_aluno.php',
            'view_footer' => 'view_footer.php',
        );

        $this->load->view('main', $dados);
    }

    public function notificar_um_aluno() {

        $id_curso = $this->uri->segment(3);
        $id_aluno = $this->uri->segment(4);

        $dados_aluno = $this->aluno_model->get_aluno_por_curso($id_aluno, $id_curso);
        $dados_notificacao = $this->Model_log->get_last_sent_notif_single($id_curso, $id_aluno);
        $nome_curso = $this->curso_model->get_curso($id_curso);

        $botao_acionado = elements(array('notificar_um_aluno'), $this->input->post());

        if ($botao_acionado['notificar_um_aluno'] != null) {
            $dados_notificacao = array(
                'id_curso' => $id_curso,
                'type' => 'single',
                'id_aluno' => $id_aluno,
                'last_sent_by' => $this->session->userdata('login'),
                'last_sent' => date('Y-m-d H:i:s')
            );

            $id_alunocurso = $dados_aluno->id_alunocurso;
            $link = anchor('GerarPdf/gerarFpdf/' . $id_aluno . '/' . $id_curso . '/' . $id_alunocurso . '/' . $dados_aluno->cod_validacao, 'CERTIFICADO', 'target="blank"');

            $msg_adicional = NULL;
            if($nome_curso['id_certificado'] == 3){
                $msg_adicional = 'Contato: linguas.netel@ufabc.edu.br';
            }
            $dadosEmailCert = array(
                'id_aluno' => $id_aluno,
                'id_curso' => $id_curso,
                'cod_validacao' => $dados_aluno->cod_validacao,
                'status' => $dados_aluno->status,
                'id_alunocurso' => $dados_aluno->id_alunocurso,
                'email' => $dados_aluno->email,
                'corpo' => utf8_decode("O Núcleo Educacional de Tecnologias e Línguas - UFABC informa que o certificado do curso:<br/><br/> <b>$nome_curso[nomeCurso]</b><br/><br/> está disponível no link a seguir: $link.<br/><br/>"
                        . "<br/>$msg_adicional"
                        . "<br/><br/><br/>--- Mensagem automática do sistema ---")
            );

            enviar($dadosEmailCert);
            $this->Model_log->set_last_sent_notif($dados_notificacao);
        } else {
            $dados = array(
                'dados_notificacao' => $dados_notificacao,
                'dados_aluno' => $dados_aluno,
                'id_curso' => $id_curso,
                'id_aluno' => $id_aluno,
                'view_header' => 'view_header.php',
                'view_conteudo' => 'view_notif_um_aluno.php',
                'view_footer' => 'view_footer.php',
            );
        }
        $this->load->view('main', $dados);
    }

}
