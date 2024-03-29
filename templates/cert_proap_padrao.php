<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->helper('custom');

$fpdf = new FPDF();

//página 1
$fpdf->AddPage('L', 'A4');
$fpdf->SetAutoPageBreak(false); //essa config possibilita definir margin inferior
$fpdf->Image('images/fundo_proap.png', 5, -5, 288);

$intro = utf8_decode("A Pró-reitoria de Assuntos Comunitários e Políticas Afirmativas da Universidade Federal do ABC confere o presente certificado a");
$nomeAluno = utf8_decode($aluno['nome']);

$texto = utf8_decode(exibe_doc($aluno['tipo_doc'], $aluno['num_doc'])."pela conclusão do " . strtoupper($curso['nomeCurso']) . ", realizado em ". substr($dataIni, -4) . ", com carga horária de " .$curso['cargaHoraria'] ." horas." );

$data = utf8_decode("Santo André, $dataCertificado");

//trecho da introdução
$fpdf->SetFont('arial', '', 18);
$fpdf->SetXY(48, 55);

$fpdf->MultiCell(225, 10, $intro, 0, 'C'); //quarto campo (0/1) exibe borda do campo
//nome do aluno
$fpdf->SetXY(48, 80);
$fpdf->SetFont('arial', 'B', 20);
$fpdf->MultiCell(225, 22, strtoupper($nomeAluno), 0, 'C');

//texto do corpo do certificado
$fpdf->SetXY(50, 105);
$fpdf->SetRightMargin(12);
$fpdf->SetFont('arial', '', 18);
$fpdf->MultiCell(225, 10, $texto, 0, 'J');

//data
$fpdf->SetXY(170, 145);
$fpdf->MultiCell(0, 10, $data, 0, 'C');


$assinatura = 'images/assinaturas/ass_trans_claudia.png';
$coordenador = utf8_decode("Cláudia Regina Vieira");
$fpdf->Image($assinatura, 194, 145,70);

//nome do coordenador
$fpdf->SetXY(170, 180);
$fpdf->MultiCell(0, 10, $coordenador, 0, 'C');

//cargo
$fpdf->SetXY(171, 190); //$fpdf->SetX(25);//config centralizado
$fpdf->MultiCell(0, 7, utf8_decode("Pró-reitora da PROAP"), 0, 'C');

//página 2
$fpdf->AddPage('L', 'A4');
$fpdf->SetAutoPageBreak(false); //essa config possibilita definir margin inferior    

$titulo = "Módulos do curso:";

$fpdf->SetY(20);
$fpdf->SetFont('arial', 'B', 13);
$fpdf->MultiCell(277, 10, utf8_decode($titulo), 0, 'C');

$fpdf->SetXY(43, 30);

$fpdf->SetFont('arial', '', 12);

$fpdf->SetXY(43, 40);
$fpdf->MultiCell(150,7.5,utf8_decode("Escravidão e desigualdade racial na construção do capitalismo"),"LRBT",'L');
$fpdf->SetXY(193, 40);
$fpdf->MultiCell(60,7.5,utf8_decode("Prof. Ramatis Jacinto"),"LRBT",'L');

$fpdf->SetXY(43, 47.5);
$fpdf->MultiCell(150,7.5,utf8_decode("Racismo e ações afirmativas"),"LRBT",'L');
$fpdf->SetXY(193, 47.5);
$fpdf->MultiCell(60,7.5,utf8_decode("Profª. Regimeire Maciel"),"LRBT",'L');

$fpdf->SetXY(43, 55);
$fpdf->MultiCell(150,7.5,utf8_decode("O poder do movimento negro e a heteroidentificação                                             "),"LRBT",'L');
$fpdf->SetXY(193, 55);
$fpdf->MultiCell(60,7.5,utf8_decode("Prof. Ivair Augusto Alves dos Santos"),"LRBT",'L');


$fpdf->SetXY(43, 70);
$fpdf->MultiCell(150,7.5,utf8_decode("Jurisprudência do STF sobre as Bancas de Heteroidentificação e a base normativa sobre o tema"),"LRBT",'L');
$fpdf->SetXY(193, 70);
$fpdf->MultiCell(60,7.5,utf8_decode("Profª. Isadora Brandão                           "),"LRBT",'L');

$fpdf->SetXY(43, 85);
$fpdf->MultiCell(150,7.5,utf8_decode("Os desafios da autoidentificação e da heteroidentificação indígena no contexto sul-americano"),"LRBT",'L');
$fpdf->SetXY(193, 85);
$fpdf->MultiCell(60,7.5,utf8_decode("Prof. Luis Roberto de Paula                           "),"LRBT",'L');

$fpdf->SetXY(43, 100);
$fpdf->MultiCell(150,7.5,utf8_decode("Branquitude brasileira e processos de colonialidade"),"LRBT",'L');
$fpdf->SetXY(193, 100);
$fpdf->MultiCell(60,7.5,utf8_decode("Profª. Ana Helena Passos"),"LRBT",'L');

$fpdf->SetXY(43, 107.5);
$fpdf->MultiCell(150,7.5,utf8_decode("Dez anos da lei de cotas e o papel das bancas de heteroidentificação"),"LRBT",'L');
$fpdf->SetXY(193, 107.5);
$fpdf->MultiCell(60,7.5,utf8_decode("Prof. Acácio Almeida"),"LRBT",'L');

$fpdf->SetXY(43, 115);
$fpdf->MultiCell(150,7.5,utf8_decode("Vivência das bancas"),"LRBT",'L');
$fpdf->SetXY(193, 115);
$fpdf->MultiCell(60,7.5,utf8_decode("Profª. Maria Lucia Almeida"),"LRBT",'L');

//qrcode
QRcode::png(base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao, './phpqrcode/img/qrcode_temp.png');
$fpdf->Image('./phpqrcode/img/qrcode_temp.png', 130, 145, 35);
//link
$fpdf->SetXY(128, 180);
$fpdf->SetFont('arial', 'U', 11);
$fpdf->SetTextColor(0, 0, 255);
//$fpdf->SetRightMargin(210); //define comprimento da cell
$fpdf->Write(5, str_replace('http://', '', base_url()), base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao);

$cod_view = $id_alunocurso . $cod_validacao;
$cod_view = implode(' ', str_split($cod_view)); //espaçamento entre caracteres da string
//Cod. Validação
$fpdf->SetFont('arial', '', 11);
$fpdf->SetTextColor(0, 0, 0);
$fpdf->SetXY(117, 186);
//$fpdf->SetRightMargin(210); //define comprimento da cell
$fpdf->MultiCell(60, 5, utf8_decode('Cod. validação:  ') . $cod_view, 0, 'C');
