<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include_once'./phpqrcode/qrlib.php';
require_once './fpdf/fpdf.php';

class GerarPdf extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('aluno_model');
        $this->load->model('curso_model');
        $this->load->model('alunocurso_model');
        $this->load->model('certificado_model');
        //$this->load->model('Model_nivel_idiomas');
    }

    public function index() {
        
    }

//    public function formatCpf($value) {//funcao para formatar o CPF
//        $cpf = preg_replace("/\D/", '', $value);
//
//        if (strlen($cpf) === 11) {
//            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cpf);
//        }
//    }

    public function gerarFpdf() {

        $id_aluno = $this->uri->segment(3);
        $id_curso = $this->uri->segment(4);
        $id_alunocurso = $this->uri->segment(5);
        $cod_validacao = $this->uri->segment(6);

        $alunocurso = $this->alunocurso_model->get_alunocurso($id_alunocurso, $cod_validacao);
        if($alunocurso['aprovado'] == 'n' || $alunocurso['aprovado'] == 'N'){
            echo "<div style='color: red; text-align: center; padding-top: 100px'><h3>Não atingiu os requisitos para obter o certificado</h3></div>";
        }elseif ($alunocurso != FALSE && $alunocurso != NULL && $alunocurso != '') {
            $aluno = $this->aluno_model->get_aluno($alunocurso['id_aluno']);

//            $aluno['num_doc'] = $this->formatCpf($aluno['num_doc']); //chama formatar cpf

            $curso = $this->curso_model->get_curso($alunocurso['id_curso']);
            $certificado = $this->certificado_model->get_certificado($curso['id_certificado']);

            //datas
            $dataIni = $curso['dataIni'];
            $dataFim = $curso['dataFim'];

            setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
            date_default_timezone_set('America/Sao_Paulo');
            $dataCertificado = utf8_encode(strftime('%d de %B de %Y.', strtotime($curso['created'])));
            $data_criado = $curso['created'];

            //Criar novos modelos de certificado no diretório templates e inserir o caminho na tabela cert_certificados
            include_once $certificado['template_certificado'];

            //gera o pdf final		
            $fpdf->Output('Certificado-' . utf8_decode($aluno['nome']) . '.pdf', 'I');
            $this->count_downloads($id_alunocurso);
        } else {
            echo "<div style='color: red; text-align: center; padding-top: 100px'><h3>Dados incorretos para gerar certificado</h3></div>";
        }
    }

    public function count_downloads($id_alunocurso) {
        $dados = $this->alunocurso_model->get_downloads($id_alunocurso);
        $dados['downloads'] = $dados['downloads'] + 1;
        $dados['id_alunocurso'] = $id_alunocurso;

        $this->alunocurso_model->update_downloads($dados);
    }

    public function gerar() {
        //http://www.mpdfonline.com/repos/mpdfmanual.pdf
//            foreach ($lista as $row) {
//                $dados_aluno = array(
//                    'nome' => $row['nome'],
//                    'conceito' => $row['conceito'],
//                    'email' => $row['email']
//                );
        //rcebe os parâmetros passados pela url através do link fornecido ao usuário
        $id_aluno = $this->encrypt->decode($this->uri->segment(3));
        $id_aluno = $this->uri->segment(3);
        $id_curso = $this->uri->segment(4);
        $id_alunocurso = $this->uri->segment(5);
        $cod_validacao = $this->uri->segment(6);
// echo 'ok';

        $alunocurso = $this->alunocurso_model->get_alunocurso($id_alunocurso, $cod_validacao);

        if ($alunocurso != NULL) {
            $aluno = $this->aluno_model->get_aluno($id_aluno);
            $curso = $this->curso_model->get_curso($id_curso);

            $coordenador = 'Profª tertert Drª L&uacute;cia Regina H. R. Franco';

            //datas
            $dataIni = $curso['dataIni'];
            $dataFim = $curso['dataFim'];

            setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
            date_default_timezone_set('America/Sao_Paulo');
            $dataCertificado = utf8_encode(strftime('%d de %B de %Y', strtotime($curso['created'])));
//            $dataCertificado = utf8_encode(strftime( '%d de %B de %Y', strtotime( date( 'Y-m-d' ) ) ));//data atual

            $css = file_get_contents('css/certificado.css');
            $htmlTemplate = file_get_contents('templates/certificado_generico.html');
            $htmlTemplate = str_replace('%aluno%', mb_strtoupper($aluno['nome']), $htmlTemplate);
            $htmlTemplate = str_replace('%nomeCurso%', $curso['nomeCurso'], $htmlTemplate);
            $htmlTemplate = str_replace('%conceito%', $alunocurso['conceito'], $htmlTemplate);
            $htmlTemplate = str_replace('%dataIni%', $dataIni, $htmlTemplate);
            $htmlTemplate = str_replace('%dataFim%', $dataFim, $htmlTemplate);
            $htmlTemplate = str_replace('%cargahoraria%', $curso['cargaHoraria'], $htmlTemplate);
            $htmlTemplate = str_replace('%datacertificado%', $dataCertificado, $htmlTemplate);
            $htmlTemplate = str_replace('%nomeCoordenador%', $coordenador, $htmlTemplate);
            $htmlTemplate = str_replace('%cod_validacao%', $cod_validacao, $htmlTemplate);
            $htmlTemplate = str_replace('%id_alunocurso%', $id_alunocurso, $htmlTemplate);

//            $pagina = base_url('validar');
            $pagina = base_url();
            $htmlTemplate = str_replace('%url%', $pagina, $htmlTemplate);

            QRcode::png($pagina . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao, './phpqrcode/img/qrcode_temp.png');
            $htmlTemplate = str_replace('%qrcode%', './phpqrcode/img/qrcode_temp.png', $htmlTemplate);


            /* OBSERVAÇÃO: pode ocorrer erro pra gerar pdf no Chrome, principalemente quando
             * se transfere o código para o server Linux.
             * O erro ocorre por causa das permissões de pasta, espeficicamente no caso deste código,
             * na pasta ./phpqrcode/img/qrcode_temp.png 
             * (visualize o código da página que deveria gerar o pdf inserindo VIEW-SOURCE. Ex:view-source:http://nte.ufabc.edu.br/certificador/GerarPdf/gerar/2/2/5/w5y)
             * Mais infos: http://www.scriptcase.com.br/forum/index.php/topic,13539.15.html?PHPSESSID=dj73gh48iqn2ojno1qrqsh0480
             * SOLUÇÃO: acessar a pasta "img" pelo FileZilla e dar permissão pública de gravar.
             */

            $mpdf = new mPDF('utf-8', 'A4-L');
            $mpdf->WriteHTML($css, 1);
            $mpdf->WriteHTML($htmlTemplate);

            $mpdf->Output($aluno['nome'] . '.pdf', 'I');
            //$mpdf->Output('Certificado '.$aluno['nome'] . '.pdf', 'D');
            unlink('./phpqrcode/img/qrcode_temp.png'); //deleta arquivo criado temporariamente
        }
    }

    public function GerarModelo() {

//        $id_aluno = $this->uri->segment(3);
//        $id_curso = $this->uri->segment(4);
//        $id_alunocurso = $this->uri->segment(5);
//        $cod_validacao = $this->uri->segment(6);

        $alunocurso = $this->alunocurso_model->get_alunocurso($id_alunocurso, $cod_validacao);
        if ($alunocurso != FALSE && $alunocurso != NULL && $alunocurso != '') {
            $aluno = $this->aluno_model->get_aluno($id_aluno);

            //$aluno['cpf'] = $this->formatCpf($aluno['cpf']); //chama formatar cpf

            $curso = $this->curso_model->get_curso($id_curso);
            $certificado = $this->certificado_model->get_certificado($curso['id_certificado']);

            //datas
            $dataIni = $curso['dataIni'];
            $dataFim = $curso['dataFim'];

            setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
            date_default_timezone_set('America/Sao_Paulo');
            $dataCertificado = utf8_encode(strftime('%d de %B de %Y.', strtotime($curso['created'])));

            //Criar novos modelos de certificado no diretório templates e inserir o caminho na tabela cert_certificados
            include_once $certificado['template_certificado'];

            //gera o pdf final		
            $fpdf->Output('Certificado-' . utf8_decode($aluno['nome']) . '.pdf', 'I');
            $this->count_downloads($id_alunocurso);
        } else {
            echo "<div style='color: red; text-align: center; padding-top: 100px'><h3>Dados incorretos para gerar certificado</h3></div>";
        }
    }

}
