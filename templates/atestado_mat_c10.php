<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->helper('custom');

$fpdf = new FPDF();
$fpdf->AddPage('P', 'A4');
$fpdf->SetAutoPageBreak(false); //essa config possibilita definir margin inferior
//$fpdf->Image('images/certificado_netel.png', 4, 1, 278);
$fpdf->Image('images/logos/header.png', 25, 8, 110);

$bordas = 0; //exibe as bordas de todas as cells para melhor configurar

//trecho da introdução
$fpdf->SetFont('times', '', 16);
$fpdf->SetXY(25, 48);
$fpdf->SetRightMargin(17);
$fpdf->MultiCell(0, 10, utf8_decode("ATESTADO"), $bordas, 'C');

$nomeAluno = utf8_decode($aluno['nome']);

$exibe_doc = NULL;
if($aluno['cpf'] != ''){
    $exibe_doc = 'portador(a) do CPF: '.$aluno['cpf'].', ';
}  elseif ($aluno['rne'] != '') {
    $exibe_doc = 'portador(a) do RNE: '.$aluno['rne'].', ';
} elseif ($aluno['passaporte'] != '') {
    $exibe_doc = 'portador(a) do passaporte: '.$aluno['passaporte'].', ';
}

$texto = utf8_decode('Atestamos que, atendendo o requerimento do(a) interessado(a), '. $nomeAluno . ', '
        . exibe_doc($aluno['tipo_doc'], $aluno['num_doc']) . " é aluno(a) regularmente matriculado(a) no Curso de Especialização em "
        . "Ensino de Ciências - Séries Finais do Ensino Fundamental - Ciência é 10, na modalidade "
        . "de Ensino a Distância, ministrado pelo NETEL - Núcleo Educacional de "
        . "Tecnologias e Línguas da UFABC - Universidade Federal do ABC, devendo cumprir "
        . "a carga horária total de 480 horas, dividida em 3 módulos, com duração de 18 meses, "
        . "iniciado em 29/08/2020, incluindo a monografia.");

//texto do corpo do certificado
$fpdf->SetXY(25,65);
$fpdf->SetFont('times', '', 12);
$fpdf->MultiCell(0, 10, $texto, $bordas, 'J');


$dataCertificado = utf8_encode(strftime( '%d de %B de %Y', strtotime( date( 'Y-m-d' ) ) ));//data atual
$data = utf8_decode("Santo André, $dataCertificado");
//data
$fpdf->SetXY(25,170);
$fpdf->MultiCell(0, 10, $data, $bordas, 'C');

//nome do coordenador
$assinatura = 'images/assinaturas/ass_trans_andre.png';
//$fpdf->Image($assinatura, 90, 190, 45);
$coordenador = utf8_decode("Profa. Dra. Mirian Pacheco Albrecht");
$fpdf->SetXY(25, 207);
$fpdf->MultiCell(0, 7, $coordenador, $bordas, 'C');

//cargo
$fpdf->SetXY(25, 214); //$fpdf->SetX(25);//config centralizado
$fpdf->MultiCell(0, 7, utf8_decode("Coordenadora do Curso"), $bordas, 'C');


//qrcode
QRcode::png(base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao, './phpqrcode/img/qrcode_temp.png');
$fpdf->Image('./phpqrcode/img/qrcode_temp.png', 97, 230, 25);
//link
//$fpdf->SetY(190);
$fpdf->SetXY(84, 253);
$fpdf->SetFont('times', 'U', 11);
$fpdf->SetTextColor(0, 0, 255);
$fpdf->SetRightMargin(10); //define comprimento da cell
$fpdf->Write(5, str_replace('http://','','netel.ufabc.edu.br/certificador'), base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao);

$cod_view = $id_alunocurso . $cod_validacao;
$cod_view = implode(' ', str_split($cod_view)); //espaçamento entre caracteres da string
//Cod. Validação
$fpdf->SetFont('times', '', 11);
$fpdf->SetTextColor(0, 0, 0);
$fpdf->SetXY(25,260);
$fpdf->SetRightMargin(18); //define comprimento da cell
$fpdf->MultiCell(0, 5, utf8_decode('Cod. validação:  ') . $cod_view, $bordas, 'C');

//footer
$fpdf->Image('images/logos/footer.png', 65, 278, 90);
