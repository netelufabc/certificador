<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->helper('custom');

$fpdf = new FPDF();
$fpdf->AddPage('L', 'A4');
$fpdf->SetAutoPageBreak(false); //essa config possibilita definir margin inferior
$fpdf->Image('images/certificado_padrao.png', 2, 2, 293);

$bordas = 0; //exibe as bordas de todas as cells para melhor configurar

$intro = utf8_decode("O Núcleo de Tecnologias Educacionais da Universidade Federal do ABC \n confere o presente certificado a");
$nomeAluno = utf8_decode($aluno['nome']);

$texto = utf8_decode(exibe_doc($aluno['tipo_doc'], $aluno['num_doc']) ."pela conclusão do curso " . strtoupper($curso['nomeCurso']) . ", em que obteve o conceito final \"" . $alunocurso['conceito'] . "\"."
        . " O curso foi ministrado no período de " . $dataIni . " a " . $dataFim . " com carga horária de " . $curso['cargaHoraria'] . " horas.");
$data = utf8_decode("Santo André, $dataCertificado");

//trecho da introdução
$fpdf->SetFont('arial', '', 18);
//$fpdf->SetY(60); //posicionamento vertical
$fpdf->SetXY(25,60);
$fpdf->SetRightMargin(25);
$fpdf->MultiCell(0, 10, $intro, $bordas, 'C');

//nome do aluno
$fpdf->SetX(25);
$fpdf->SetFont('arial', 'B', 20);
$fpdf->MultiCell(0, 22, strtoupper($nomeAluno), $bordas, 'C');

//texto do corpo do certificado
$fpdf->SetX(25);
$fpdf->SetRightMargin(25);
$fpdf->SetFont('arial', '', 18);
$fpdf->MultiCell(0, 10, $texto, $bordas, 'J');
$fpdf->SetY(143);

//data
$fpdf->SetX(25);
$fpdf->MultiCell(0, 10, $data, $bordas, 'C');

//nome do coordenador
$d1 = '2018-06-01 00:00:00'; //(cert_cursos - created)antes dessa data exibe a assinatura da LÃºcia
if (strtotime($curso['created']) < strtotime($d1)) {
    $assinatura = 'images/assinaturas/ass_trans_lucia.png';
    $fpdf->Image($assinatura, 195, 163, 50);
    $coordenador = utf8_decode("Profª Drª Lúcia Regina H. R. Franco");
} else {
    $assinatura = 'images/assinaturas/ass_trans_andre.png';
    $fpdf->Image($assinatura, 197, 157, 45);
    $coordenador = utf8_decode("Profº Drº André Luiz Brandão");
}
//nome do coordenador
//        $fpdf->SetX(25);//config centralizado
$fpdf->SetXY(160,175);
$fpdf->MultiCell(0, 7, $coordenador, $bordas, 'C');

//cargo
$fpdf->SetXY(160,182); //$fpdf->SetX(25);//config centralizado
$fpdf->MultiCell(0, 7, utf8_decode("Coordenação do NTE / UFABC"), $bordas, 'C');


//qrcode
QRcode::png(base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao, './phpqrcode/img/qrcode_temp.png');
$fpdf->Image('./phpqrcode/img/qrcode_temp.png', 40, 155, 35);
//link
//$fpdf->SetY(190);
$fpdf->SetXY(30,190);//posicao para o link oficial
$fpdf->SetFont('arial', 'U', 11);
$fpdf->SetTextColor(0, 0, 255);
$fpdf->SetRightMargin(110); //define comprimento da cell
$fpdf->Write(5, str_replace('http://', '', 'netel.ufabc.edu.br/certificador'), base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao);

$cod_view = $id_alunocurso . $cod_validacao;
$cod_view = implode(' ', str_split($cod_view)); //espaçamento entre caracteres da string
//Cod. Validação
$fpdf->SetFont('arial', '', 11);
$fpdf->SetTextColor(0, 0, 0);
$fpdf->SetY(196);
$fpdf->SetX(25);
$fpdf->SetRightMargin(210); //define comprimento da cell
$fpdf->MultiCell(0, 5, utf8_decode('Cod. validação:  ') . $cod_view, 0, 'C');
