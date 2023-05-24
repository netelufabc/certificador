<?php

defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('custom_helper');

$fpdf = new FPDF();
$fpdf->AddPage('L', 'A4');
$fpdf->SetAutoPageBreak(false); //essa config possibilita definir margin inferior
//$fpdf->Image('images/certificado_pcv.png', 2, 2, 293);
$fpdf->Image('images/logos/fundo_ufabc.png', 2, 2, 324);

$fpdf->SetFillColor(0,90,60); //linha vertical verde
$fpdf->SetXY(15, 1);//linha vertical verde
$fpdf->Cell(10, 178, '', 0, 0, 'L', 'true');//linha vertical verde

////$fpdf->Image('images/brasao_netel.png', 1, 1,39);
$fpdf->Image('images/logos/brasao.png', 2, 13,36);
//$fpdf->Image('images/logos/netel.png', 7, 178,27);
//$fpdf->Image('images/logos/ufabc.png', 260, 179,37);
//$fpdf->Image('images/logos/pcv.png', 253, 14, 41);
$fpdf->Image('images/logos/ufabc.png', 3, 179, 35);
$fpdf->Image('images/logos/netel.png', 265, 180, 24);

$bordas = 0; //exibe as bordas de todas as cells para melhor configurar

$fpdf->SetXY(38, 13);
$fpdf->SetRightMargin(10);
$fpdf->SetFont('arial', 'B', 36);
$fpdf->SetTextColor(0, 90, 60);
$fpdf->MultiCell(0, 10, 'CERTIFICADO', $bordas, 'C');

$freq = frequecia_em_porcentagem($curso['cargaHoraria'],$alunocurso['faltas_em_horas']);
$dataIni = converte_dataString_extenso($dataIni);
$dataFim = converte_dataString_extenso($dataFim);

$into = utf8_decode("O Núcleo Educacional de Tecnologias e Línguas da Universidade Federal do ABC confere o presente certificado a");
$nomeAluno = utf8_decode($aluno['nome']);

//trecho da introdução
$fpdf->SetFont('arial', '', 16);
$fpdf->SetTextColor(0, 0, 0);
$fpdf->SetXY(38, 28);
$fpdf->SetRightMargin(10);
$fpdf->MultiCell(0, 9, $into, $bordas, 'C'); //quarto campo (0/1) exibe borda do campo
//nome do aluno
$fpdf->SetXY(38, 52);
$fpdf->SetFont('arial', 'B', 17);
$fpdf->MultiCell(0, 9, strtoupper($nomeAluno), $bordas, 'C');

//trata o período do evento caso a data de início e fim sejam as mesma
if ($dataIni == $dataFim) {
    $periodo = "em $dataIni";    
} else {
    $periodo = "de $dataIni a $dataFim";
}

$texto = utf8_decode(exibe_doc($aluno['tipo_doc'], $aluno['num_doc']) . "por sua participação como organizador(a) do(a) " . $curso['nomeCurso'] . ", "
        . "realizado pela Divisão de Idiomas do Núcleo Educacional de Tecnologias e Línguas da Universidade Federal do ABC, ocorrido "
        . "$periodo, com carga horária total de " . $curso['cargaHoraria'] . " horas. "
        . "Este evento tem caráter formativo, não avaliativo e de cunho gratuito. Devido à pandemia de Covid-19, as atividades ocorreram de forma virtual.");

$data = utf8_decode("Santo André, $dataCertificado");

//texto do corpo do certificado
$fpdf->SetXY(38, 67);
$fpdf->SetRightMargin(10);
$fpdf->SetTextColor(0);
$fpdf->SetFont('arial', '', 15);
$fpdf->MultiCell(0, 10, $texto, $bordas, 'J');

//data
$fpdf->SetXY(185, 152);
$fpdf->SetRightMargin(10);
$fpdf->MultiCell(0, 10, $data, $bordas, 'C');

//realização
//$fpdf->SetXY(20, 168);
//$fpdf->SetRightMargin(20);
//$fpdf->MultiCell(0, 10, utf8_decode("Realização:"), $bordas, 'L');

//Apoio
//$fpdf->SetXY(182, 168);
//$fpdf->SetRightMargin(20);
//$fpdf->MultiCell(0, 10, "Apoio:", $bordas, 'L');


//logos
//$fpdf->Image('images/logos/ufabc.png', 15, 175, 35);
//$fpdf->SetXY(30, 175);

//$fpdf->Image('images/logos/netel.png', 51, 177, 23);
//$fpdf->SetXY(30, 175);

//$fpdf->Image('images/logos/logo_leal.png', 185, 177, 15);
//$fpdf->SetXY(30, 175);

//$fpdf->SetXY(208, 188);
//$fpdf->SetFont('arial', '', 12);
//$fpdf->MultiCell(70, 5, utf8_decode('FONEMOS - Grupo de Estudos de Fonologia e Morfologia da USP'), $bordas, 'C');

//$fpdf->Image('images/assinaturas/ass_trans_andre.png', 68, 161, 40);
//$fpdf->SetXY(50, 178);
//$fpdf->SetFont('arial', '', 12);
//$fpdf->MultiCell(80, 5, utf8_decode('Prof. Dr. André Luiz Brandão'), $bordas, 'C');
//$fpdf->SetX(50);
//$fpdf->MultiCell(80, 5, 'Coordenador Geral - NETEL', $bordas, 'C');

//$fpdf->Image('images/assinaturas/ass_trans_carla.png', 208, 130, 25);
//$fpdf->SetXY(178, 150);
//$fpdf->SetFont('arial', '', 12);
//$fpdf->MultiCell(80, 5, 'Profa. Dra. Carla Lopes Rodrigues', $bordas, 'C');
//$fpdf->SetX(178);
//$fpdf->MultiCell(80, 5, 'Coordenadora do Curso PCV', $bordas, 'C');

$fpdf->Image('images/assinaturas/ass_trans_janaina.png', 193, 174, 35);
$fpdf->SetXY(150, 195);
$fpdf->SetRightMargin(33);
//$fpdf->SetXY(200, 160);
$fpdf->SetFont('arial', '', 12);
$fpdf->MultiCell(0, 5, utf8_decode('Janaína Gonçalves'), $bordas, 'C');
$fpdf->SetX(150);
$fpdf->MultiCell(0, 5, utf8_decode('Chefe da Divisão de Idiomas'), $bordas, 'C');


//qrcode
QRcode::png(base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao, './phpqrcode/img/qrcode_temp.png');
//$fpdf->Image('./phpqrcode/img/qrcode_temp.png', 145, 179, 20); //centro
$fpdf->Image('./phpqrcode/img/qrcode_temp.png', 104, 177, 20); //35
//link
$teste = 'netel.ufabc.edu.br/certificador';
$fpdf->SetXY(91, 196); //posicao para o link oficial
$fpdf->SetFont('arial', 'U', 9);
$fpdf->SetTextColor(0, 0, 255);
$fpdf->SetRightMargin(1); //define comprimento da cell
$fpdf->Write(5, str_replace('http://', '', $teste), base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao);

$cod_view = $id_alunocurso . $cod_validacao;
$cod_view = implode(' ', str_split($cod_view)); //espaçamento entre caracteres da string
//Cod. Validação
$fpdf->SetFont('arial', '', 9);
$fpdf->SetTextColor(0, 0, 0);
$fpdf->SetXY(50, 200);
$fpdf->SetRightMargin(120); //define comprimento da cell
$fpdf->MultiCell(0, 5, utf8_decode('Cód. validação:  ') . $cod_view, $bordas, 'C');
