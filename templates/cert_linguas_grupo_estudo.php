<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->helper('custom');

$fpdf = new FPDF();

//página 1
$fpdf->AddPage('L', 'A4');
$fpdf->SetAutoPageBreak(false); //essa config possibilita definir margin inferior
$fpdf->Image('images/certificado_netel.png', 5, -5, 288);

$intro = "O Núcleo Educacional de Tecnologias e Línguas da Universidade Federal do ABC confere o presente certificado a";
$nomeAluno = utf8_decode($aluno['nome']);

$texto = exibe_doc($aluno['tipo_doc'], $aluno['num_doc'])."pela participação no " . $curso['nomeCurso'] . ".";

$data = "Santo André, $dataCertificado";

//trecho da introdução
$fpdf->SetFont('arial', '', 18);
$fpdf->SetXY(48, 42);
$fpdf->SetRightMargin(10);
$fpdf->MultiCell(0, 10, utf8_decode($intro), 0, 'C'); //quarto campo (0/1) exibe borda do campo
//nome do aluno
$fpdf->SetXY(48, 69);
$fpdf->SetFont('arial', 'B', 20);
$fpdf->MultiCell(0, 22, strtoupper($nomeAluno), 0, 'C');

//texto do corpo do certificado
$fpdf->SetXY(50, 98);
$fpdf->SetRightMargin(12);
$fpdf->SetFont('arial', '', 18);
$fpdf->MultiCell(0, 10, utf8_decode($texto), 0, 'J');

//data
$fpdf->SetXY(170, 133);
$fpdf->MultiCell(0, 10, utf8_decode($data), 0, 'C');


$assinatura = 'images/assinaturas/ass_trans_janaina.png';
$coordenador = "Janaína Gonçalves";
$fpdf->Image($assinatura, 208, 142, 53);

//nome do coordenador
//        $fpdf->SetX(25);//config centralizado
$fpdf->SetXY(170, 170);
$fpdf->MultiCell(0, 10, utf8_decode($coordenador), 0, 'C');

//cargo
$fpdf->SetXY(170, 180); //$fpdf->SetX(25);//config centralizado
$fpdf->MultiCell(0, 7, utf8_decode("Chefe da Divisão de Idiomas"), 0, 'C');


// .$alunocurso['faltas_em_horas']. " horas de faltas, obtendo conceito final \"" . $alunocurso['conceito'] . "\"."
//        . " O curso foi ministrado no per�odo de " . $dataIni . " a " . $dataFim . " com carga hor�ria de " . $curso['cargaHoraria'] . " horas."
//p�gina 2
$fpdf->AddPage('L', 'A4');
$fpdf->SetAutoPageBreak(false); //essa config possibilita definir margin inferior    


$titulo = "Tabela referente ao nível deste certificado, adaptada das orientações do Quadro Comum Europeu de Referência para Línguas (QCER): escala global.";

$desc_nvl = NiveisLinguas();

$fpdf->SetY(20);
$fpdf->SetFont('arial', 'B', 11);
//$fpdf->MultiCell(277, 10, utf8_decode($titulo), 0, 'C');

$fpdf->SetXY(43, 30);
$fpdf->SetFont('arial', 'B', 12);
$fpdf->SetFillColor(255, 211, 0);

//OBSERVA��O: quando precisar alterar os níveis, basta fazer a alteração no arquivo curstom_helper, função NiveisLinguas.
//switch ($curso['nivel']) {
//    default :
//        foreach ($desc_nvl as $key => $value) {
//            if($key == $curso['nivel']){
//                if($curso['nivel'] == 'INICIANTE'){
//                    $fpdf->Cell(30,10,'',"LTRB",0,'C',1);
//                }else{
//                    $fpdf->Cell(30,10,$key,"LTRB",0,'C',1);
//                }
//            }else{
//                if($key == 'INICIANTE'){
//                    $fpdf->Cell(30,10,'',"LTRB",0,'C');
//                }else{
//                    $fpdf->Cell(30,10,$key,"LTRB",0,'C');
//                }
//            }
//        }
//}
//$fpdf->SetFont('arial', '', 10);
//$fpdf->SetXY(43, 40);
//$fpdf->MultiCell(30,7.5,"Iniciante \nI - III","LRB",'C');
//$fpdf->SetXY(73, 40);
//$fpdf->MultiCell(30,7.5,"Elementar\nI - II","LRB",'C');
//$fpdf->SetXY(103, 40);
//$fpdf->MultiCell(30,7.5,  utf8_decode("Pr�-Intermedi�rio\nI - II"),"LRB",'C');
//$fpdf->SetXY(133, 40);
//$fpdf->MultiCell(30,7.5,  utf8_decode("Intermedi�rio\nI - III"),"LRB",'C');
//$fpdf->SetXY(163, 40);
//$fpdf->MultiCell(30,7.5,  utf8_decode("P�s-Intermedi�rio\nI - III"),"LRB",'C');
//$fpdf->SetXY(193, 40);
//$fpdf->MultiCell(30,7.5,  utf8_decode("Avan�ado\nI - VII"),"LRB",'C');
//$fpdf->SetXY(223, 40);
//$fpdf->MultiCell(30,5,  utf8_decode("Avan�ado\nsuperior\nI - VII"),"LRB",'C');
//
////Exibe a descri��o dos n�veis 
//$fpdf->SetXY(22, 60);
////$fpdf->SetRightMargin(58);
//$fpdf->SetFont('arial', '', 12);
//$fpdf->MultiCell(253, 7, utf8_decode($curso['nivel'] . " - " . $desc_nvl[$curso['nivel']]), 0, 'J');


$x = -10;
$y = -50;

//Atributos do aluno no curso
$fpdf->SetXY(100+$x, 105+$y);//$fpdf->SetXY(70, 105);
$fpdf->SetFont('arial', 'B', 11);
$fpdf->SetFillColor(255,255,255);
$fpdf->MultiCell(30, 5, utf8_decode("\nCarga Horária"), "LT", 'C');

$fpdf->SetXY(130+$x, 105+$y);
$fpdf->MultiCell(30, 5, utf8_decode("Frequência\ndo aluno"),"LT", 'C');
$fpdf->SetXY(160+$x, 105+$y);
//$fpdf->MultiCell(20, 5, utf8_decode("Conceito final"), "LT", 'C');
//$fpdf->SetXY(150, 105);
$fpdf->MultiCell(50, 5, utf8_decode("\nPeríodo"), "LTR",'C');
$fpdf->SetXY(120+$x, 105+$y);
//$fpdf->MultiCell(25, 5, utf8_decode("N�vel\nQCER"), "LTR", 'C');

$fpdf->SetXY(100+$x, 115+$y);
$fpdf->Cell(30, 10, $curso['cargaHoraria'] . " horas", "LB", 0, 'C');
$freq = 100 - ($alunocurso['faltas_em_horas'] * 100) / $curso['cargaHoraria'];
$fpdf->Cell(30, 10, ceil($freq) . "%", "LB", 0, 'C');//arredondamento para cima
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
$fpdf->Write(5, str_replace('http://', '', 'netel.ufabc.edu.br/certificador'), base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao);

$cod_view = $id_alunocurso . $cod_validacao;
$cod_view = implode(' ', str_split($cod_view)); //espa�amento entre caracteres da string
//Cod. Valida��o
$fpdf->SetFont('arial', '', 11);
$fpdf->SetTextColor(0, 0, 0);
$fpdf->SetXY(117, 186);
//$fpdf->SetRightMargin(210); //define comprimento da cell
$fpdf->MultiCell(60, 5, utf8_decode('Cód. validação:  ') . $cod_view, 0, 'C');
