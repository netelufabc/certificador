<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->helper('custom');

$fpdf = new FPDF();

//página 1
$fpdf->AddPage('L', 'A4');
$fpdf->SetAutoPageBreak(false); //essa config possibilita definir margin inferior
$fpdf->Image('images/certificado_netel.png', 5, -5, 288);

$intro = utf8_decode("O Núcleo Educacional de Tecnologias e Línguas da Universidade Federal do ABC, através de sua Divisão de Idiomas, nos termos da lei Nº 11.145 de criação da Fundação Universidade federal do ABC, em 26 de Julho de 2005 e atendendo os termos da Portaria do Ministério de Estado da Justiça e Segurança Pública Nº 623 de 13 de Novembro de 2020, tendo em vista o resultados das avaliações presenciais, outorga a");
$nomeAluno = utf8_decode($aluno['nome']);

$texto = utf8_decode("de nacionalidade " . $aluno['nacionalidade'] . ", " . exibe_doc($aluno['tipo_doc'], $aluno['num_doc'])."o CERTIFICADO DE PROFICIÊNCIA EM LÍNGUA PORTUGUESA de nível indicado neste documento, válido perante instituições nacionais e estrangeiras para todos os fins de direito.");

$data = utf8_decode("Santo André, $dataCertificado");

//trecho da introdução
$fpdf->SetFont('arial', '', 14);
$fpdf->SetXY(48, 42);
$fpdf->SetRightMargin(10);
$fpdf->MultiCell(0, 10, $intro, 0, 'J'); //quarto campo (0/1) exibe borda do campo
//nome do aluno
$fpdf->SetXY(48, 80);
$fpdf->SetFont('arial', 'B', 17);
$fpdf->MultiCell(0, 22, strtoupper($nomeAluno), 0, 'C');

//texto do corpo do certificado
$fpdf->SetXY(50, 100);
$fpdf->SetRightMargin(12);
$fpdf->SetFont('arial', '', 14);
$fpdf->MultiCell(0, 10, $texto, 0, 'J');

//data
$fpdf->SetXY(45, 135);
$fpdf->MultiCell(0, 10, $data, 0, 'C');

//assinatura professor (esquerda)
$assinatura = 'images/assinaturas/ass_trans_mariangela_nova.png';
$fpdf->Image($assinatura, 50, 150, 80);

//nome do professor
$fpdf->SetFont('arial', 'B');
$fpdf->Text(57, 171, utf8_decode("Mariângela Alonso"));
$fpdf->SetFont('arial', '', 14);
$fpdf->Text(67, 179, utf8_decode("Docente"));
$fpdf->Text(60, 187, utf8_decode("Siape xxxxxxx"));


//assinatura jeniffer (centro)
$assinatura = 'images/assinaturas/ass_trans_jeni_nova.png';
$fpdf->Image($assinatura, 115, 145, 100);

$fpdf->SetXY(35, 165);
$fpdf->SetFont('arial', 'B');
$fpdf->MultiCell(0, 10, utf8_decode("Jeniffer Alessandra Suplizzi"), 0, 'C');
$fpdf->SetFont('arial', '', 14);

//cargo
$fpdf->SetXY(35, 175); //$fpdf->SetX(25);//config centralizado
$fpdf->MultiCell(0, 7, utf8_decode("Chefe da Divisão de Idiomas"), 0, 'C');

//siape
$fpdf->SetXY(35, 183); //$fpdf->SetX(25);//config centralizado
$fpdf->MultiCell(0, 7, utf8_decode("Siape xxxxxxx"), 0, 'C');

//assinatura angela (direita)
$assinatura = 'images/assinaturas/ass_trans_angela_nova.png';
$coordenador = utf8_decode("Angela Terumi Fushita");
$fpdf->Image($assinatura, 220, 150, 100);

//nome do coordenador
$fpdf->SetXY(210, 165);
$fpdf->SetFont('arial', 'B');
$fpdf->MultiCell(0, 10, $coordenador, 0, 'C');
$fpdf->SetFont('arial', '', 14);

//cargo
$fpdf->SetXY(210, 175); 
$fpdf->MultiCell(0, 7, utf8_decode("Coordenadora do NETEL"), 0, 'C');

//siape
$fpdf->SetXY(210, 183); 
$fpdf->MultiCell(0, 7, utf8_decode("Siape xxxxxxx"), 0, 'C');


//página 2
$fpdf->AddPage('L', 'A4');
$fpdf->SetAutoPageBreak(false); //essa config possibilita definir margin inferior    


$titulo = "Tabela referente ao nível deste certificado, adaptada das orientações do Quadro Comum Europeu de Referência para Línguas (QCER): escala global.";

$desc_nvl = NiveisLinguas();

$fpdf->SetY(20);
$fpdf->SetFont('arial', 'B', 11);
$fpdf->MultiCell(277, 10, utf8_decode($titulo), 0, 'C');

$fpdf->SetXY(43, 30);
$fpdf->SetFont('arial', 'B', 12);
$fpdf->SetFillColor(255, 211, 0);

//OBSERVAÇÃO: quando precisar alterar os níveis, basta fazer a alteração no arquivo curstom_helper, função NíveisLinguas.
switch ($curso['nivel']) { //este bloco gera a linha superior da tabela (A1,A2,etc...)
    default :
        foreach ($desc_nvl as $key => $value) {
            if($key == $curso['nivel']){
                if($curso['nivel'] == 'INICIANTE'){
                    $fpdf->Cell(30,10,'',"LTRB",0,'C',1);
                }else{
                    if ($key == 'Não se aplica') {
                        break;
                    }
                    $fpdf->Cell(30,10,$key,"LTRB",0,'C',1);
                }
            }else{
                if($key == 'INICIANTE'){
                    $fpdf->Cell(30,10,'',"LTRB",0,'C');
                }else{
                    if ($key == 'Não se aplica') {
                        break;
                    }
                    $fpdf->Cell(30,10,$key,"LTRB",0,'C');
                }
            }
        }
}
$fpdf->SetFont('arial', '', 10);
$fpdf->SetXY(43, 40);
$fpdf->MultiCell(30,7.5,"Iniciante \nI - III","LRB",'C');
$fpdf->SetXY(73, 40);
$fpdf->MultiCell(30,7.5,"Elementar\nI - II","LRB",'C');
$fpdf->SetXY(103, 40);
$fpdf->MultiCell(30,7.5,  utf8_decode("Pré-Intermediário\nI - IV"),"LRB",'C');
$fpdf->SetXY(133, 40);
$fpdf->MultiCell(30,7.5,  utf8_decode("Intermediário\nI - III"),"LRB",'C');
$fpdf->SetXY(163, 40);
$fpdf->MultiCell(30,7.5,  utf8_decode("Pós-Intermediário\nI - III"),"LRB",'C');
$fpdf->SetXY(193, 40);
$fpdf->MultiCell(30,7.5,  utf8_decode("Avançado\nI - VII"),"LRB",'C');
$fpdf->SetXY(223, 40);
$fpdf->MultiCell(30,5,  utf8_decode("Avançado\nsuperior\nI - VII"),"LRB",'C');

//Exibe a descrição dos níveis 
$fpdf->SetXY(22, 60);
$fpdf->SetFont('arial', '', 10);
$fpdf->MultiCell(253, 7, utf8_decode($curso['nivel'] . " - " . $desc_nvl[$curso['nivel']]), 0, 'J');

//Atributos do aluno no curso
$fpdf->SetXY(70, 85); //altura borda superior primeira célula
$fpdf->SetFont('arial', 'B', 11);
$fpdf->SetFillColor(255,255,255);
$fpdf->MultiCell(30, 5, utf8_decode("Carga Horária do módulo"), "LT", 'C');

$fpdf->SetXY(100, 85);//altura borda superior segunda célula
$fpdf->MultiCell(30, 5, utf8_decode("Frequência\ndo aluno"),"LT", 'C');
$fpdf->SetXY(130, 85);
$fpdf->MultiCell(20, 5, utf8_decode("Conceito final"), "LT", 'C');
$fpdf->SetXY(150, 85);
$fpdf->MultiCell(50, 5, utf8_decode("Período\ndo módulo"), "LT",'C');
$fpdf->SetXY(200, 85);
$fpdf->MultiCell(25, 5, utf8_decode("Nível\nQCER"), "LTR", 'C');

$fpdf->SetXY(70, 95);//inicio segunda linha do quadro
$fpdf->Cell(30, 10, $curso['cargaHoraria'] . " horas", "LB", 0, 'C');
$freq = 100 - ($alunocurso['faltas_em_horas'] * 100) / $curso['cargaHoraria'];
$fpdf->Cell(30, 10, ceil($freq) . "%", "LB", 0, 'C');//arredondamento para cima
$fpdf->Cell(20, 10, $alunocurso['conceito'], "LB", 0, 'C');
$fpdf->Cell(50, 10, $dataIni . ' a ' . $dataFim, "LB", 0, 'C');
$fpdf->Cell(25, 10, $curso['nivel'], "LRB", 0, 'C');

//Título "conteúdo"
$fpdf->SetXY(22, 110);
$fpdf->SetFont('arial', '', 10);
$fpdf->MultiCell(253, 7, utf8_decode("Conteúdo programático:"), 0, 'J');

$conteudo_array = ConteudoProgramatico();//pega o texto do conteudo e joga em $conteudo
foreach ($conteudo_array as $key => $value) {
	if($key == $curso['nivel'] ){
		$conteudo = $value;
		break;
	}
}

//Exibe a descrição do conteúdo 
$fpdf->SetXY(22, 117);
$fpdf->SetFont('arial', '', 10);
$fpdf->MultiCell(253, 7, utf8_decode($conteudo), 0, 'J');

//conceitos das avaliações
$fpdf->SetXY(22, 160);
$fpdf->SetFont('arial', '', 10);
$fpdf->MultiCell(253, 7, utf8_decode("Conceito da primeira...:"), 0, 'J');

//qrcode
QRcode::png(base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao, './phpqrcode/img/qrcode_temp.png');
$fpdf->Image('./phpqrcode/img/qrcode_temp.png', 130, 160, 35);
//link
$fpdf->SetXY(128, 193);
$fpdf->SetFont('arial', 'U', 11);
$fpdf->SetTextColor(0, 0, 255);

$fpdf->Write(5, str_replace('http://', '', base_url()), base_url() . 'validar/?cod_validacao=' . $id_alunocurso . $cod_validacao);

$cod_view = $id_alunocurso . $cod_validacao;
$cod_view = implode(' ', str_split($cod_view)); //espaçamento entre caracteres da string
//Cod. Validação
$fpdf->SetFont('arial', '', 11);
$fpdf->SetTextColor(0, 0, 0);
$fpdf->SetXY(117, 200);

$fpdf->MultiCell(60, 5, utf8_decode('Cod. validação:  ') . $cod_view, 0, 'C');
