<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$fpdf = new FPDF();
$fpdf->AddPage('L', 'A4');
$fpdf->SetAutoPageBreak(false); //essa config possibilita definir margin inferior
$fpdf->Image('images/rea_frente.png', 2, 2, 293);

$into = utf8_decode("O Núcleo Educacional de Tecnologias e Línguas e a Pró-reitoria de Extensão e Cultura certificam que");
$nomeAluno = utf8_decode($aluno['nome']);
$texto = utf8_decode("participou do CURSO DE EXTENSÃO DE EDUCAÇÃO ABERTA E RECURSOS EDUCACIONAIS ABERTOS  no período de " . $dataIni . " a " . $dataFim . ", com carga horária de " . $curso['cargaHoraria'] . " horas.");
$data = utf8_decode("Santo André, $dataCertificado");
//mb_strtoupper($curso['nomeCurso'])

//trecho da introdução
$fpdf->SetFont('arial', '', 18);
$fpdf->SetY(60); //posicionamento vertical
$fpdf->SetX(35);
$fpdf->SetRightMargin(30);
$fpdf->MultiCell(0, 10, $into, 0, 'C');

//nome do aluno
$fpdf->SetX(35);
$fpdf->SetFont('arial', 'B', 20);
$fpdf->MultiCell(0, 22, strtoupper($nomeAluno), 0, 'C');

//texto do corpo do certificado
$fpdf->SetX(35);
$fpdf->SetRightMargin(30);
$fpdf->SetFont('arial', '', 18);
$fpdf->MultiCell(0, 10, $texto, 0, 'J');

//data
$fpdf->SetY(135);
$fpdf->SetX(35);
$fpdf->MultiCell(0, 10, $data, 0, 'C');

//página 2
$fpdf->AddPage('L', 'A4');
$texto2 = utf8_decode("CURSO DE EXTENSÃO DE EDUCAÇÃO ABERTA E RECURSOS EDUCACIONAIS ABERTOS

Conteúdo Programático:
    - Bens comuns
    - Direitos autorais e licenças livres
    - Formatos abertos
    - Ética Hacker
    - Software livre na educação
    - Livros abertos
    - RRI");
$fpdf->SetY(20);
$fpdf->SetX(20);
$fpdf->SetFont('arial', '', 14);
$fpdf->MultiCell(0, 10, $texto2, 0, 'J');

//qrcode
QRcode::png(base_url() . 'validar?cod_validacao=' . $id_alunocurso . $cod_validacao, './phpqrcode/img/qrcode_temp.png');
$fpdf->Image('./phpqrcode/img/qrcode_temp.png', 132, 145, 35);
//link
$fpdf->SetY(180);
$fpdf->SetX(121);
$fpdf->SetFont('arial', 'U', 11);
$fpdf->SetTextColor(0, 0, 255);
$fpdf->SetRightMargin(57); //define comprimento da cell
$fpdf->Write(5, str_replace('http://', '', base_url()), base_url() . 'validar?cod_validacao=' . $id_alunocurso . $cod_validacao);

$cod_view = $id_alunocurso . $cod_validacao;
$cod_view = implode(' ', str_split($cod_view)); //espaçamento entre caracteres da string
//Cod. Validação
$fpdf->SetFont('arial', '', 11);
$fpdf->SetTextColor(0, 0, 0);
$fpdf->SetY(186);
$fpdf->SetX(56);
$fpdf->SetRightMargin(57); //define comprimento da cell
$fpdf->MultiCell(0, 5, utf8_decode('Cod. validação:  ') . $cod_view , 0, 'C');