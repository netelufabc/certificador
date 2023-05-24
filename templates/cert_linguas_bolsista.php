<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->helper('custom');

$fpdf = new FPDF();

//página 1
$fpdf->AddPage('L', 'A4');
$fpdf->SetAutoPageBreak(false); //essa config possibilita definir margin inferior
$fpdf->Image('images/certificado_netel.png', 5, -5, 288);
$bordas = 0;

//trecho da introdução
$intro = utf8_decode("O Núcleo Educacional de Tecnologias e Línguas da Universidade Federal do ABC confere o presente certificado a");
$fpdf->SetFont('arial', '', 18);
$fpdf->SetXY(48, 42);
$fpdf->SetRightMargin(10);
$fpdf->MultiCell(0, 10, $intro, $bordas, 'C'); //quarto campo (0/1) exibe borda do campo

//nome do aluno
$nomeAluno = utf8_decode($aluno['nome']);
$fpdf->SetXY(48, 67);
$fpdf->SetFont('arial', 'B', 20);
$fpdf->MultiCell(0, 15, strtoupper($nomeAluno), $bordas, 'C');

$dataIni = converte_dataString_mesAno($dataIni);
$dataFim = converte_dataString_mesAno($dataFim);

//texto do corpo do certificado
/*$texto = utf8_decode(exibe_doc($aluno['tipo_doc'], $aluno['num_doc'])."por sua participação como monitor(a) de Educação Linguística "
        . "do programa de monitoria do " . mb_strtoupper($curso['nomeCurso']) . ", no período de $dataIni a $dataFim, "
        . "com carga horária de $curso[cargaHoraria] horas semanais..");*/
$texto = utf8_decode(exibe_doc($aluno['tipo_doc'], $aluno['num_doc'])."por sua participação como bolsista do Programa de Bolsas de Educação Linguística do  " . mb_strtoupper($curso['nomeCurso']) . ", no período de $dataIni a $dataFim, "
        . "com carga horária de $curso[cargaHoraria] horas semanais.");
$fpdf->SetXY(48, 88);
$fpdf->SetFont('arial', '', 18);
$fpdf->MultiCell(0, 10, $texto, $bordas, 'J');

//data
$data = utf8_decode("Santo André, $dataCertificado");
$fpdf->SetXY(170, 139);
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


//PÁGINA 2
$fpdf->AddPage('L', 'A4');
$fpdf->SetAutoPageBreak(false); //essa config possibilita definir margin inferior    

/*$intro2 = "As atividades de monitoria em Educação Linguística contemplam:";*/
$intro2 = "As atividades dos bolsistas do Programa de Bolsas de Educação Linguística estão contempladas em detalhes nos respectivos editais de seleção. Resumidamente, elas são orientadas pela chefia da Divisão de Idiomas e envolvem o acompanhamento de aulas dos módulos e encontros dos Grupos de Estudos e Oficinas, a presença nas reuniões convocadas, a elaboração de Diários de Bordo e de relatórios, a preparação e a liderança de Grupos de Estudos e Oficinas. ";
$fpdf->SetXY(40,20);
$fpdf->SetFont('arial', '', 13);
//$fpdf->MultiCell(230, 18, utf8_decode($intro2), $bordas, 'L');
$fpdf->MultiCell(230, 12, utf8_decode($intro2), $bordas, 'J');

/*$paragrafo1 = chr(149). utf8_decode(" Acompanhar as aulas dos cursos conforme direcionamento da coordenação, visando à formação do monitor, bem como estimulando sua postura ativa, crítica e participativa;");
$paragrafo2 = chr(149). utf8_decode(" Realizar atividades de rotina pedagógica e seu consequente estímulo para a participação na Educação Linguística, como a elaboração de listas de presença e auxílio na preparação de materiais didáticos, exceto provas dos módulos regulares de línguas;");
$paragrafo3 = chr(149). utf8_decode(" Organizar e conduzir grupos de estudos, incluindo preparação, agendamento e acompanhamento das reuniões, estimulando a análise crítica e habilidades características da aprendizagem responsável e colaborativa;");
$paragrafo4 = chr(149). utf8_decode(" Dialogar com a comunidade interna e externa e organizar ações de imersão linguística para além da aprendizagem comum, visando ao comprometimento sociocultural do monitor e dos participantes;");
$paragrafo5 = chr(149). utf8_decode(" Comparecer semanalmente às reuniões pedagógicas com a coordenação do curso ou com a equipe da Divisão de Idiomas;");
$paragrafo6 = chr(149). utf8_decode(" Encaminhar relatórios quadrimestrais de atividades à coordenação.");

$l = 230;
$x = 40;
$fpdf->SetX($x);
$fpdf->MultiCell($l, 7, $paragrafo1, $bordas, 'J');
$fpdf->SetX($x);
$fpdf->MultiCell($l, 7, $paragrafo2, $bordas, 'J');
$fpdf->SetX($x);
$fpdf->MultiCell($l, 7, $paragrafo3, $bordas, 'J');
$fpdf->SetX($x);
$fpdf->MultiCell($l, 7, $paragrafo4, $bordas, 'J');
$fpdf->SetX($x);
$fpdf->MultiCell($l, 7, $paragrafo5, $bordas, 'J');
$fpdf->SetX($x);
$fpdf->MultiCell($l, 7, $paragrafo6, $bordas, 'J');
*/
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
