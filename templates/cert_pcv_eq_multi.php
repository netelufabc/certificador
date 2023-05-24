<?php

defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('custom_helper');

$fpdf = new FPDF();
$fpdf->AddPage('L', 'A4');
$fpdf->SetAutoPageBreak(false); //essa config possibilita definir margin inferior
//$fpdf->Image('images/certificado_pcv.png', 2, 2, 293);
$fpdf->Image('images/logos/fundo_ufabc.png', 2, 2, 324);
$fpdf->SetFillColor(0,90,60);
$fpdf->SetXY(15, 1);
$fpdf->Cell(10, 178, '', 0, 0, 'L', 'true');
//$fpdf->Image('images/brasao_netel.png', 1, 1,39);
$fpdf->Image('images/logos/brasao.png', 2, 13,36);
$fpdf->Image('images/logos/netel.png', 7, 178,27);
$fpdf->Image('images/logos/ufabc.png', 260, 179,37);
$fpdf->Image('images/logos/pcv.png', 253, 14, 41);

$bordas = 0; //exibe as bordas de todas as cells para melhor configurar

$fpdf->SetXY(34, 25);
$fpdf->SetRightMargin(34);
$fpdf->SetFont('arial', 'B', 36);
$fpdf->SetTextColor(0, 90, 60);
$fpdf->MultiCell(0, 10, 'CERTIFICADO', $bordas, 'C');

$freq = frequecia_em_porcentagem($curso['cargaHoraria'],$alunocurso['faltas_em_horas']);
$dataIni = converte_dataString_extenso($dataIni);
$dataFim = converte_dataString_extenso($dataFim);

$texto = utf8_decode("Certificamos que " . mb_strtoupper($aluno['nome'].', ') . exibe_doc($aluno['tipo_doc'], $aluno['num_doc']) . " apoiou o desenho do "
        . "módulo \"" . mb_strtoupper($curso['nomeCurso']) . "\" do curso \"DOCÊNCIA COM TECNOLOGIAS\" "
        . "como parte de uma equipe de especialistas da UFABC. "
        . "O curso foi ministrado no período de $dataIni a $dataFim.");

$data = utf8_decode("Santo André, $dataCertificado");

//texto do corpo do certificado
$fpdf->SetXY(36, 55);
$fpdf->SetRightMargin(24);
$fpdf->SetTextColor(0);
$fpdf->SetFont('arial', '', 16);
$fpdf->MultiCell(0, 10, $texto, $bordas, 'J');

//data
$fpdf->SetXY(36, 118);
$fpdf->SetRightMargin(24);
$fpdf->MultiCell(0, 10, $data, $bordas, 'C');

//assinaturas
$fpdf->Image('images/assinaturas/ass_trans_carolina.png', 64, 137, 45);
$fpdf->SetXY(50, 150);
$fpdf->SetFont('arial', '', 12);
$fpdf->MultiCell(80, 5, utf8_decode('Profa. Dra. Carolina Corrêa de Carvalho'), $bordas, 'C');
$fpdf->SetX(50);
$fpdf->MultiCell(80, 5, 'Coordenadora do Curso PCV', $bordas, 'C');

$fpdf->Image('images/assinaturas/ass_trans_andre.png', 68, 161, 40);
$fpdf->SetXY(50, 178);
$fpdf->SetFont('arial', '', 12);
$fpdf->MultiCell(80, 5, utf8_decode('Prof. Dr. André Luiz Brandão'), $bordas, 'C');
$fpdf->SetX(50);
$fpdf->MultiCell(80, 5, 'Coordenador Geral - NETEL', $bordas, 'C');

$fpdf->Image('images/assinaturas/ass_trans_carla.png', 208, 130, 25);
$fpdf->SetXY(178, 150);
$fpdf->SetFont('arial', '', 12);
$fpdf->MultiCell(80, 5, 'Profa. Dra. Carla Lopes Rodrigues', $bordas, 'C');
$fpdf->SetX(178);
$fpdf->MultiCell(80, 5, 'Coordenadora do Curso PCV', $bordas, 'C');

$fpdf->Image('images/assinaturas/ass_trans_miguel.png', 198, 168, 40);
$fpdf->SetXY(178, 178);
$fpdf->SetFont('arial', '', 12);
$fpdf->MultiCell(80, 5, 'Prof. Dr. Miguel Said Vieira', $bordas, 'C');
$fpdf->SetX(178);
$fpdf->MultiCell(80, 5, 'Vice-coordenador - NETEL', $bordas, 'C');


//qrcode
QRcode::png(base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao, './phpqrcode/img/qrcode_temp.png');
$fpdf->Image('./phpqrcode/img/qrcode_temp.png', 145, 179, 20); //35
//link
$teste = 'netel.ufabc.edu.br/certificador';
$fpdf->SetXY(132, 198); //posicao para o link oficial
$fpdf->SetFont('arial', 'U', 9);
$fpdf->SetTextColor(0, 0, 255);
$fpdf->SetRightMargin(1); //define comprimento da cell
$fpdf->Write(5, str_replace('http://', '', $teste), base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao);

$cod_view = $id_alunocurso . $cod_validacao;
$cod_view = implode(' ', str_split($cod_view)); //espaçamento entre caracteres da string
//Cod. Validação
$fpdf->SetFont('arial', '', 9);
$fpdf->SetTextColor(0, 0, 0);
$fpdf->SetXY(132, 203);
$fpdf->SetRightMargin(120); //define comprimento da cell
$fpdf->MultiCell(0, 5, utf8_decode('Cód. validação:  ') . $cod_view, $bordas, 'C');
