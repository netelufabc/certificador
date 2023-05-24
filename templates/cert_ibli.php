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
$fpdf->Image('images/logos/ufabc.png', 0.5, 178,40);
$fpdf->Image('images/logos/netel.png', 212, 178,27);
$fpdf->Image('images/logos/logo_prograd.png', 52,185,65);
$fpdf->Image('images/logos/logo_qzero.png', 270, 180, 16);

$bordas = 0; //exibe as bordas de todas as cells para melhor configurar
$setRMargin = 14;

$fpdf->SetXY(35, 25);
$fpdf->SetRightMargin($setRMargin);
$fpdf->SetFont('arial', 'B', 36);
$fpdf->SetTextColor(0, 90, 60);
$fpdf->MultiCell(0, 10, 'CERTIFICADO', $bordas, 'C');

$freq = frequecia_em_porcentagem($curso['cargaHoraria'],$alunocurso['faltas_em_horas']);
$dataIni = converte_dataString_extenso($dataIni);
$dataFim = converte_dataString_extenso($dataFim);

//trecho da introdução
$into = utf8_decode("O Núcleo Educacional de Tecnologias e Línguas da Universidade Federal do ABC confere o presente certificado a");
$fpdf->SetFont('arial', '', 18);
$fpdf->SetTextColor(0, 0, 0);
//$fpdf->SetY(60); //posicionamento vertical
$fpdf->SetXY(35, 48);
$fpdf->SetRightMargin($setRMargin);
$fpdf->MultiCell(0, 10, $into, $bordas, 'C');

//nome do aluno
$fpdf->SetX(35);
$fpdf->SetFont('arial', 'B', 20);
$fpdf->MultiCell(0, 22, utf8_decode(mb_strtoupper($aluno['nome'])), $bordas, 'C');

//  $dataIni $dataFim $curso[cargaHoraria]

//texto do corpo do certificado
$texto = utf8_decode(exibe_doc($aluno['tipo_doc'], $aluno['num_doc'])."pela conclusão do curso \"". mb_strtoupper($curso['nomeCurso']) ."\", "
        . "realizado em formato MOOC (sem tutoria), em 2020, com carga horária de $curso[cargaHoraria] horas, "
        . "distribuídas em 12 semanas.");
$fpdf->SetX(35);
$fpdf->SetFont('arial', '', 18);
$fpdf->MultiCell(0, 10, $texto, $bordas, 'J');

//data
$data = utf8_decode("Santo André, "). strftime("%d de %B de %Y", strtotime("today")).'.';
$fpdf->SetXY(35, 137);
$fpdf->SetRightMargin($setRMargin);
$fpdf->MultiCell(0, 10, $data, $bordas, 'C');

//assinaturas
$fpdf->Image('images/assinaturas/ass_trans_angela.png', 68, 152, 40);
$fpdf->SetXY(50, 162);
$fpdf->SetFont('arial', '', 12);
$fpdf->MultiCell(80, 5, utf8_decode('Profa. Dra. Angela Terumi Fushita'), $bordas, 'C');
$fpdf->SetX(50);
$fpdf->MultiCell(80, 5, 'Coordenadora do curso', $bordas, 'C');

$fpdf->Image('images/assinaturas/ass_trans_andre.png', 204, 145, 40);
$fpdf->SetXY(182, 162);
$fpdf->SetFont('arial', '', 12);
$fpdf->MultiCell(80, 5, utf8_decode('Prof. Dr. André Luiz Brandão'), $bordas, 'C');
$fpdf->SetX(182);
$fpdf->MultiCell(80, 5, 'Coordenador Geral - NETEL', $bordas, 'C');


//qrcode
QRcode::png(base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao, './phpqrcode/img/qrcode_temp.png');
$fpdf->Image('./phpqrcode/img/qrcode_temp.png', 155, 179, 20); //35
//link
$teste = 'netel.ufabc.edu.br/certificador';
$fpdf->SetXY(142, 198); //posicao para o link oficial
$fpdf->SetFont('arial', 'U', 9);
$fpdf->SetTextColor(0, 0, 255);
$fpdf->SetRightMargin(1); //define comprimento da cell
$fpdf->Write(5, str_replace('http://', '', $teste), base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao);

$cod_view = $id_alunocurso . $cod_validacao;
$cod_view = implode(' ', str_split($cod_view)); //espaçamento entre caracteres da string
//Cod. Validação
$fpdf->SetFont('arial', '', 9);
$fpdf->SetTextColor(0, 0, 0);
$fpdf->SetXY(140, 203);
$fpdf->SetRightMargin(108); //define comprimento da cell
$fpdf->MultiCell(0, 5, utf8_decode('Cód. validação:  ') . $cod_view, $bordas, 'C');
