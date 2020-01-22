<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$fpdf = new FPDF();
$fpdf->AddPage('L', 'A4');
$fpdf->SetAutoPageBreak(false); //essa config possibilita definir margin inferior
$fpdf->Image('images/certificado_padrao.png', 2, 2, 293);

$into = utf8_decode("O Núcleo Educacional de Tecnologias e Línguas da Universidade Federal do ABC confere o presente certificado a");
$nomeAluno = utf8_decode($aluno['nome']);
$texto = utf8_decode("pela conclusão do curso " . $curso['nomeCurso'] . ", em que obteve o conceito final \"" . $alunocurso['conceito'] . "\"."
        . " O curso foi ministrado no período de " . $dataIni . " a " . $dataFim . " com carga horária de " . $curso['cargaHoraria'] . " horas.");
$data = utf8_decode("Santo André, $dataCertificado");

//trecho da introdução
$fpdf->SetFont('arial', '', 18);
//$fpdf->SetY(60); //posicionamento vertical
$fpdf->SetXY(25,60);
$fpdf->SetRightMargin(25);
$fpdf->MultiCell(0, 10, $into, 0, 'C');

//nome do aluno
$fpdf->SetX(40);
$fpdf->SetFont('arial', 'B', 20);
$fpdf->MultiCell(0, 22, strtoupper($nomeAluno), 0, 'C');

//texto do corpo do certificado
$fpdf->SetX(25);
$fpdf->SetRightMargin(30);
$fpdf->SetFont('arial', '', 18);
$fpdf->MultiCell(0, 10, $texto, 0, 'J');
$fpdf->SetY(143);

//data
$fpdf->SetX(30);
$fpdf->MultiCell(0, 10, $data, 0, 'C');

//nome do coordenador
$d1 = '2018-06-01 00:00:00'; //antes dessa data exibe a assinatura da LÃºcia
if (strtotime($curso['created']) < strtotime($d1)) {
    $assinatura = 'images/ass_trans_lucia.png';
    $coordenador = utf8_decode("Profª Drª Lúcia Regina H. R. Franco");
    $fpdf->Image($assinatura, 195, 163, 50);
    
    $fpdf->SetY(175);
    //$fpdf->SetX(25);//config centralizado
    $fpdf->SetX(163);
    $fpdf->MultiCell(0, 10, $coordenador, 0, 'C');
    
    //cargo
    $fpdf->SetY(185);
    $fpdf->SetX(164); //$fpdf->SetX(25);//config centralizado
    $fpdf->MultiCell(0, 7, utf8_decode("Coordenação do NETEL / UFABC"), 0, 'C');

} else {
    $assinatura = 'images/ass_trans_andre.png';
    $coordenador = utf8_decode("Profº Drº André Luiz Brandão");
    $fpdf->Image($assinatura, 197, 157, 45);

//nome do coordenador
$fpdf->SetY(175);
//        $fpdf->SetX(25);//config centralizado
$fpdf->SetX(172);
$fpdf->MultiCell(0, 10, $coordenador, 0, 'C');

//cargo
$fpdf->SetXY(169,185); //$fpdf->SetX(25);//config centralizado
$fpdf->MultiCell(0, 7, utf8_decode("Coordenação do NETEL / UFABC"), 0, 'C');
}

//qrcode
QRcode::png(base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao, './phpqrcode/img/qrcode_temp.png');
$fpdf->Image('./phpqrcode/img/qrcode_temp.png', 40, 155, 35);
//link
//$fpdf->SetY(190);
$fpdf->SetXY(40,190);
$fpdf->SetFont('arial', 'U', 11);
$fpdf->SetTextColor(0, 0, 255);
$fpdf->SetRightMargin(110); //define comprimento da cell
$fpdf->Write(5, str_replace('http://', '', base_url()), base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao);

$cod_view = $id_alunocurso . $cod_validacao;
$cod_view = implode(' ', str_split($cod_view)); //espaçamento entre caracteres da string
//Cod. Validação
$fpdf->SetFont('arial', '', 11);
$fpdf->SetTextColor(0, 0, 0);
$fpdf->SetY(196);
$fpdf->SetX(24);
$fpdf->SetRightMargin(210); //define comprimento da cell
$fpdf->MultiCell(0, 5, utf8_decode('Cod. validação:  ') . $cod_view, 0, 'C');
