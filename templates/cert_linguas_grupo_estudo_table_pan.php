<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->helper('custom');

$fpdf = new FPDF();

//página 1
$fpdf->AddPage('L', 'A4');
$fpdf->SetAutoPageBreak(false); //essa config possibilita definir margin inferior
$fpdf->Image('images/certificado_netel.png', 5, -5, 288);
$bordas = 0;

$into = utf8_decode("O Núcleo Educacional de Tecnologias e Línguas da Universidade Federal do ABC confere o presente certificado a");
$nomeAluno = utf8_decode($aluno['nome']);

$texto = utf8_decode(exibe_doc($aluno['tipo_doc'], $aluno['num_doc'])."pela participação no " . $curso['nomeCurso'] . ". "
        . "Devido à pandemia de Covid-19, declarada em março de 2020, este grupo de "
        . "estudos presencial foi adaptado, de forma que o período e o percentual de "
        . "atividades remotas e presenciais se encontram no verso deste certificado.");

$data = utf8_decode("Santo André, $dataCertificado");

//trecho da introdução
$fpdf->SetFont('arial', '', 18);
$fpdf->SetXY(48, 42);
$fpdf->SetRightMargin(10);
$fpdf->MultiCell(0, 10, $into, $bordas, 'C');
//nome do aluno
$fpdf->SetXY(48, 64);
$fpdf->SetFont('arial', 'B', 20);
$fpdf->MultiCell(0, 15, strtoupper($nomeAluno), $bordas, 'C');

//texto do corpo do certificado
$fpdf->SetXY(48, 81);
$fpdf->SetFont('arial', '', 18);
$fpdf->MultiCell(0, 10, $texto, $bordas, 'J');

//data
$fpdf->SetXY(170, 144);
$fpdf->MultiCell(0, 10, $data, $bordas, 'C');


$assinatura = 'images/assinaturas/ass_trans_janaina.png';
$coordenador = utf8_decode("Janaína Gonçalves");
$fpdf->Image($assinatura, 208, 149, 45);

//nome do coordenador
//        $fpdf->SetX(25);//config centralizado
$fpdf->SetXY(170, 172);
$fpdf->MultiCell(0, 10, $coordenador, $bordas, 'C');

//cargo
$fpdf->SetXY(170, 182); //$fpdf->SetX(25);//config centralizado
$fpdf->MultiCell(0, 7, utf8_decode("Chefe da Divisão de Idiomas"), $bordas, 'C');


//PÁGINA 2
$fpdf->AddPage('L', 'A4');
$fpdf->SetAutoPageBreak(false); //essa config possibilita definir margin inferior    

$x = -37;
$y = -50;

//Atributos do aluno no curso
$fpdf->SetXY(100+$x, 105+$y);
$fpdf->SetFont('arial', 'B', 11);
$fpdf->SetFillColor(255,255,255);
$fpdf->MultiCell(30, 5, utf8_decode("\nCarga Horária"), "LT", 'C');
$fpdf->SetXY(130+$x, 105+$y);
$fpdf->MultiCell(30, 5, utf8_decode("Atividades presenciais"),"LT", 'C');
$fpdf->SetXY(160+$x, 105+$y);
$fpdf->MultiCell(30, 5, utf8_decode("Atividades remotas"),"LT", 'C');
$fpdf->SetXY(190+$x, 105+$y);
$fpdf->MultiCell(30, 5, utf8_decode("Frequência\ndo aluno"),"LT", 'C');
$fpdf->SetXY(220+$x, 105+$y);
$fpdf->MultiCell(50, 5, utf8_decode("\nPeríodo "), "LTR",'C');

$fpdf->SetXY(100+$x, 115+$y);
$fpdf->Cell(30, 10, $curso['cargaHoraria'] . " horas", "LB", 0, 'C');
$fpdf->Cell(30, 10, $curso['ativ_presencial'].'%', "LB", 0, 'C');
$fpdf->Cell(30, 10, $curso['ativ_remota'].'%', "LB", 0, 'C');
$freq = 100 - ($alunocurso['faltas_em_horas'] * 100) / $curso['cargaHoraria'];
$fpdf->Cell(30, 10, utf8_decode('Não se aplica')/*ceil($freq) . "%"*/, "LB", 0, 'C');//arredondamento para cima
//$fpdf->Cell(20, 10, $alunocurso['conceito'], "LB", 0, 'C');
$fpdf->Cell(50, 10, $dataIni . ' a ' . $dataFim, "LBR", 0, 'C');
//$fpdf->Cell(25, 10, $curso['nivel'], "LRB", 0, 'C');

//qrcode
QRcode::png(base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao, './phpqrcode/img/qrcode_temp.png');
$fpdf->Image('./phpqrcode/img/qrcode_temp.png', 130, 145, 35);
//link
$fpdf->SetXY(120, 180);
$fpdf->SetFont('arial', 'U', 11);
$fpdf->SetTextColor(0, 0, 255);
//$fpdf->SetRightMargin(210); //define comprimento da cell
$fpdf->Write(5, str_replace('http://', '', base_url()), base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao);

$cod_view = $id_alunocurso . $cod_validacao;
$cod_view = implode(' ', str_split($cod_view)); //espa�amento entre caracteres da string
//Cod. Valida��o
$fpdf->SetFont('arial', '', 11);
$fpdf->SetTextColor(0, 0, 0);
$fpdf->SetXY(117, 186);
//$fpdf->SetRightMargin(210); //define comprimento da cell
$fpdf->MultiCell(60, 5, utf8_decode('Cod. validação:  ') . $cod_view, 0, 'C');
