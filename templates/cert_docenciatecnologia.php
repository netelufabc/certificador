<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->helper('custom');

$fpdf = new FPDF();
$fpdf->AddPage('L', 'A4');
$fpdf->SetAutoPageBreak(false); //essa config possibilita definir margin inferior
$fpdf->Image('images/certificado_netel.png', 4, 1, 278);

$bordas = 0; //exibe as bordas de todas as cells para melhor configurar

$into = utf8_decode("O Núcleo Educacional de Tecnologias e Línguas da Universidade Federal do ABC confere o presente certificado a");
$nomeAluno = utf8_decode($aluno['nome']);

if($alunocurso['conceito'] != NULL || $alunocurso['conceito'] != ''){
    $txt_conceito_final = ", em que obteve o conceito final \"" . $alunocurso['conceito']."\"";
}  else {
    $txt_conceito_final ='';
}

$texto = utf8_decode(exibe_doc($aluno['tipo_doc'], $aluno['num_doc']) . "pela conclusão do curso " . strtoupper($curso['nomeCurso']).$txt_conceito_final."."
        . " O curso foi ministrado no período de " . $dataIni . " a " . $dataFim . " com carga horária de 24 horas, concluídas 12 oficinas obrigatórias e aprovação mínima de 75%.");
$data = utf8_decode("Santo André, $dataCertificado");

//trecho da introdução
$fpdf->SetFont('arial', '', 18);
//$fpdf->SetY(60); //posicionamento vertical
$fpdf->SetXY(39, 48);
$fpdf->SetRightMargin(17);
$fpdf->MultiCell(0, 10, $into, $bordas, 'C');

//nome do aluno
$fpdf->SetX(39);
$fpdf->SetFont('arial', 'B', 20);
$fpdf->MultiCell(0, 22, strtoupper($nomeAluno), $bordas, 'C');

//texto do corpo do certificado
$fpdf->SetX(39);
$fpdf->SetFont('arial', '', 18);
$fpdf->MultiCell(0, 10, $texto, $bordas, 'J');

//data
$fpdf->SetXY(39,133);
$fpdf->MultiCell(0, 10, $data, $bordas, 'C');

//nome do coordenador
$assinatura = 'images/assinaturas/ass_trans_angela.png';
$fpdf->Image($assinatura, 197, 157, 45);
$coordenador = utf8_decode("Profª Drª Ângela Terumi Fushita");
$fpdf->SetXY(160, 175);
$fpdf->MultiCell(0, 7, $coordenador, $bordas, 'C');

//cargo
$fpdf->SetXY(160, 182); //$fpdf->SetX(25);//config centralizado
$fpdf->MultiCell(0, 7, utf8_decode("Coordenação do NETEL / UFABC"), $bordas, 'C');


//qrcode
QRcode::png(base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao, './phpqrcode/img/qrcode_temp.png');
$fpdf->Image('./phpqrcode/img/qrcode_temp.png', 68, 155, 25);
//link
//$fpdf->SetY(190);
$fpdf->SetXY(53, 180);
$fpdf->SetFont('arial', 'U', 11);
$fpdf->SetTextColor(0, 0, 255);
$fpdf->SetRightMargin(110); //define comprimento da cell
$fpdf->Write(5, str_replace('http://', '', base_url()), base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao);

$cod_view = $id_alunocurso . $cod_validacao;
$cod_view = implode(' ', str_split($cod_view)); //espaçamento entre caracteres da string
//Cod. Validação
$fpdf->SetFont('arial', '', 11);
$fpdf->SetTextColor(0, 0, 0);
$fpdf->SetXY(52,185);
$fpdf->SetRightMargin(190); //define comprimento da cell
$fpdf->MultiCell(0, 5, utf8_decode('Cod. validação:  ') . $cod_view, $bordas, 'C');
