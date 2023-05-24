<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->helper('custom');

$fpdf = new FPDF();

//página 1
$fpdf->AddPage('L', 'A4');
$fpdf->SetAutoPageBreak(false); //essa config possibilita definir margin inferior
$fpdf->Image('images/certificado_netel.png', 5, -5, 288);
$bordas = 0;


$intro = utf8_decode("O Núcleo Educacional de Tecnologias e Línguas da Universidade Federal do ABC confere o presente certificado a");
$nomeAluno = utf8_decode($aluno['nome']);

$texto = utf8_decode(exibe_doc($aluno['tipo_doc'], $aluno['num_doc'])."pela conclusão do " . $curso['nomeCurso'] . ". "
        . "Devido à pandemia de Covid-19, declarada em março de 2020, este módulo "
        . "presencial foi adaptado, de forma que o período e o percentual de atividades "
        . "remotas e presenciais se encontram no verso deste certificado.");

$data = utf8_decode("Santo André, $dataCertificado");

//trecho da introdução
$fpdf->SetFont('arial', '', 18);
$fpdf->SetXY(48, 42);
$fpdf->SetRightMargin(10);
$fpdf->MultiCell(0, 10, $intro, $bordas, 'C'); //quarto campo (0/1) exibe borda do campo
//nome do aluno
$fpdf->SetXY(48, 65);
$fpdf->SetFont('arial', 'B', 20);
$fpdf->MultiCell(0, 15, strtoupper($nomeAluno), $bordas, 'C');

//texto do corpo do certificado
$fpdf->SetXY(48, 83);
$fpdf->SetFont('arial', '', 18);
$fpdf->MultiCell(0, 10, $texto, $bordas, 'J');

//data
$fpdf->SetXY(170, 142);
$fpdf->MultiCell(0, 10, $data, $bordas, 'C');


$assinatura = 'images/assinaturas/ass_trans_janaina.png';
$coordenador = utf8_decode("Janaína Gonçalves");
$fpdf->Image($assinatura, 208, 146, 47);

//nome do coordenador
//        $fpdf->SetX(25);//config centralizado
$fpdf->SetXY(170, 170);
$fpdf->MultiCell(0, 10, $coordenador, $bordas, 'C');

//cargo
$fpdf->SetXY(170, 180); //$fpdf->SetX(25);//config centralizado
$fpdf->MultiCell(0, 7, utf8_decode("Chefe da Divisão de Idiomas"), 0, 'C');


// .$alunocurso['faltas_em_horas']. " horas de faltas, obtendo conceito final \"" . $alunocurso['conceito'] . "\"."
//        . " O curso foi ministrado no período de " . $dataIni . " a " . $dataFim . " com carga horária de " . $curso['cargaHoraria'] . " horas."
//página 2
$fpdf->AddPage('L', 'A4');
$fpdf->SetAutoPageBreak(false); //essa config possibilita definir margin inferior    


$titulo = "Tabela referente ao nível deste certificado, adaptada das orientações do Quadro Comum Europeu de Referência para Línguas (QCER): escala global.";

$desc_nvl = NiveisLinguas();

$fpdf->SetY(20);
$fpdf->SetFont('arial', 'B', 11);
$fpdf->MultiCell(277, 10, utf8_decode($titulo), $bordas, 'C');

$fpdf->SetXY(43, 30);
$fpdf->SetFont('arial', 'B', 12);
$fpdf->SetFillColor(255, 211, 0);

//OBSERVAÇÃO: quando precisar alterar os níveis, fazer a alteração no arquivo curstom_helper, função NíveisLinguas.
switch ($curso['nivel']) {
    default :
        foreach ($desc_nvl as $key => $value) {
            
            if ($key == $curso['nivel']) {
                if ($curso['nivel'] == 'INICIANTE') {
                    $fpdf->Cell(30, 10, '', "LTRB", 0, 'C', 1);
                } else {
                    if ($key == 'Não se aplica') {
                        break;
                    }
                    $fpdf->Cell(30, 10, $key, "LTRB", 0, 'C', 1);
                }
            } else {
                if ($key == 'INICIANTE') {
                    
                    $fpdf->Cell(30, 10, '', "LTRB", 0, 'C');
                } else {
                    if ($key == 'Não se aplica') {
                        break;
                    }
                    
                    $fpdf->Cell(30, 10, $key, "LTRB", 0, 'C');
                }
            }
        }
}
$fpdf->SetFont('arial', '', 10);
$fpdf->SetXY(43, 40);
$fpdf->MultiCell(30, 7.5, "Iniciante \nI - III", "LRB", 'C');
$fpdf->SetXY(73, 40);
$fpdf->MultiCell(30, 7.5, "Elementar\nI - II", "LRB", 'C');
$fpdf->SetXY(103, 40);
$fpdf->MultiCell(30, 7.5, utf8_decode("Pré-Intermediário\nI - II"), "LRB", 'C');
$fpdf->SetXY(133, 40);
$fpdf->MultiCell(30, 7.5, utf8_decode("Intermediário\nI - III"), "LRB", 'C');
$fpdf->SetXY(163, 40);
$fpdf->MultiCell(30, 7.5, utf8_decode("Pós-Intermediário\nI - III"), "LRB", 'C');
$fpdf->SetXY(193, 40);
$fpdf->MultiCell(30, 7.5, utf8_decode("Avançado\nI - VII"), "LRB", 'C');
$fpdf->SetXY(223, 40);
$fpdf->MultiCell(30, 5, utf8_decode("Avançado\nsuperior\nI - VII"), "LRB", 'C');

//Exibe a descrição dos níveis 
$fpdf->SetXY(22, 60);
//$fpdf->SetRightMargin(58);
$fpdf->SetFont('arial', '', 12);
if ($curso['nivel'] != "Não se aplica") {
    $fpdf->MultiCell(253, 7, utf8_decode($curso['nivel'] . " - " . $desc_nvl[$curso['nivel']]), 0, 'J');
}

//Atributos do aluno no curso
$xtab2 = -29;
$fpdf->SetXY(70 + $xtab2, 105);
$fpdf->SetFont('arial', 'B', 11);
$fpdf->SetFillColor(255, 255, 255);
$fpdf->MultiCell(30, 5, utf8_decode("Carga Horária do módulo"), "LT", 'C');
$fpdf->SetXY(100 + $xtab2, 105);
$fpdf->MultiCell(30, 5, "Atividades presenciais", "LT", 'C');
$fpdf->SetXY(130 + $xtab2, 105);
$fpdf->MultiCell(30, 5, "Atividades remotas", "LT", 'C');
$fpdf->SetXY(160 + $xtab2, 105);
$fpdf->MultiCell(30, 5, utf8_decode("Frequência\ndo aluno"), "LT", 'C');
$fpdf->SetXY(190 + $xtab2, 105);
$fpdf->MultiCell(20, 5, "Conceito final", "LT", 'C');
$fpdf->SetXY(210 + $xtab2, 105);
$fpdf->MultiCell(50, 5, utf8_decode("Período\ndo módulo"), "LT", 'C');
$fpdf->SetXY(260 + $xtab2, 105);
$fpdf->MultiCell(26, 5, utf8_decode("Nível\nQCER"), "LTR", 'C');

$fpdf->SetXY(70 + $xtab2, 115);
$fpdf->Cell(30, 10, $curso['cargaHoraria'] . " horas", "LB", 0, 'C');
$fpdf->Cell(30, 10, $curso['ativ_presencial'] . '%', "LB", 0, 'C');
$fpdf->Cell(30, 10, $curso['ativ_remota'] . '%', "LB", 0, 'C');
$freq = 100 - ($alunocurso['faltas_em_horas'] * 100) / $curso['cargaHoraria'];
$fpdf->Cell(30, 10, utf8_decode('Não se aplica') /* ceil($freq) . "%" */, "LB", 0, 'C'); //arredondamento para cima
$fpdf->Cell(20, 10, $alunocurso['conceito'], "LB", 0, 'C');
$fpdf->Cell(50, 10, $dataIni . ' a ' . $dataFim, "LB", 0, 'C');
$fpdf->Cell(26, 10, utf8_decode($curso['nivel']), "LRB", 0, 'C');

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
$cod_view = implode(' ', str_split($cod_view)); //espaçamento entre caracteres da string
//Cod. Validação
$fpdf->SetFont('arial', '', 11);
$fpdf->SetTextColor(0, 0, 0);
$fpdf->SetXY(117, 186);
//$fpdf->SetRightMargin(210); //define comprimento da cell
$fpdf->MultiCell(60, 5, utf8_decode('Cod. validação:  ') . $cod_view, 0, 'C');
