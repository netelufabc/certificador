<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function ListarTemplates() {
    $path = "templates/";
    $diretorio = dir($path);

    echo "Lista de Arquivos do diretório '<strong>" . $path . "</strong>':<br />";
    while ($arquivo = $diretorio->read()) {
        echo "<a href='" . $path . $arquivo . "'>" . $arquivo . "</a><br />";
    }
    $diretorio->close();
}

function NiveisLinguas() {
    //$niveis_tipos = array("INICIANTE", "A1.1", "A1.2", "A2.1", "A2.2", "B1.1", "B1.2", "B2.1", "B2.2", "C1.1", "C1.2", "C1.3");

    $niveis_tipos = array(
        "INICIANTE" => "É capaz de dizer e de perguntar o dia, a hora e a data, usar formas básicas de saudação, preencher formulários simples com dados pessoais: nome, morada, nacionalidade, estado civil.",
        "A1" => "É capaz de compreender e usar expressões familiares e cotidianas, enunciados muito simples para satisfazer necessidades concretas; pode apresentar-se e apresentar outros, fazer perguntas e dar respostas sobre aspectos pessoais como o local onde vive, as pessoas que conhece e as coisas que tem; pode comunicar-se de modo simples se o interlocutor falar lenta e distintamente.",
        "A2" => "É capaz de compreender frases isoladas e expressões frequentes relacionadas a áreas de prioridade imediata; é capaz de comunicar-se em tarefas simples e em rotinas que exigem apenas uma troca de informação direta sobre assuntos que lhe são familiares e habituais; pode descrever de modo simples sua formação, o meio circundante e referir-se a assuntos relacionados a necessidades imediatas.",
        "B1" => "É capaz de compreender as questões principais quando é usada linguagem clara e padronizada e os assuntos lhe são familiares; é capaz de lidar com a maioria das situações encontradas na região onde se fala a língua-alvo, de produzir um discurso simples e coerente sobre assuntos que lhe são familiares ou de interesse pessoal; pode descrever experiências e eventos, sonhos, esperanças e ambições, bem como expor brevemente razões e justificativas para uma opinião ou um projeto.",
        "B2" => "É capaz de compreender as ideias principais em textos complexos sobre assuntos concretos e abstratos, incluindo discussões técnicas na sua área de especialidade. É capaz de se comunicar com certo grau de espontaneidade com falantes nativos, sem que haja tensão de parte a parte. É capaz de exprimir-se de modo claro e pormenorizado sobre uma grande variedade de temas e explicar um ponto de vista sobre um tema da atualidade, expondo as vantagens e os inconvenientes de várias possibilidades.",
        "C1" => "É capaz de compreender um vasto número de textos longos e exigentes, reconhecendo os seus significados implícitos, de exprimir-se de forma fluente e espontânea sem precisar pesquisar muitas palavras; é capaz de usar a língua de modo flexível e eficaz para fins sociais, acadêmicos e profissionais; exprimir-se sobre temas complexos de forma clara e bem estruturada, manifestando o domínio de mecanismos de organização, de articulação e de coesão do discurso.",
        "C2" => "É capaz de compreender praticamente tudo o que ouve ou lê, de resumir as informações recolhidas em diversas fontes orais e escritas, reconstruindo argumentos e fatos de modo coerente; é capaz de exprimirse espontaneamente de modo fluente e com exatidão e de distinguir finas variações de significado em situações complexas.",
    );

    return $niveis_tipos;
}

function UploadCsv() {
    $data['error'] = '';
    // Define as configurações para o upload do CSV
    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = 'csv';
    $config['max_size'] = '1000';
    $this->load->library('upload', $config);
    // Se o upload falhar, exibe mensagem de erro na view
    if (!$this->upload->do_upload('csvfile')) {
        $data['error'] = $this->upload->display_errors();
        $this->load->view('main', $data);
    } else {
        $file_data = $this->upload->data();
        $file_path = './uploads/' . $file_data['file_name'];
        return $file_path;
    }
}

//    public function enviar($dados_curso, $dados) {
function enviar($dados) {

    $contaemail = 'suporte.ead@ufabc.edu.br'; //'suporte.tidia@gmail.com';
    $pass = 'ufabc!@#tidia'; //'ufabc!@#tidia';
    $assunto = 'Certificado NETEL-UFABC';

//        $id_aluno = $dados['id_aluno'];
//        $id_curso = $dados['id_curso'];
//        $id_alunocurso = $dados['id_alunocurso'];
//        $cod_validacao = $dados['cod_validacao'];
//
//        $link = anchor('GerarPdf/gerarFpdf/' . $id_aluno . '/' . $id_curso . '/' . $id_alunocurso . '/' . $cod_validacao, 'CERTIFICADO', 'target="blank"');
//        $corpo = utf8_decode("O Núcleo Educacional de Tecnologias e Línguas - UFABC informa que o certificado do curso:<br/><br/> <b>$nome_curso[nomeCurso]</b><br/><br/> está disponível no link a seguir: $link.<br/><br/>"
//                        . "<br/><br/>--- Mensagem automática do sistema ---");

    require_once './phpmailer/PHPMailerAutoload.php';
//        $alunos = Array();
//        $this->load->model('aluno_model');
//        $alunos = $this->aluno_model->get_all_alunos();
//// O BLOCO ABAIXO INICIALIZA O ENVIO
    $mail = new PHPMailer; // INICIA A CLASSE PHPMAILER
    $mail->IsSMTP(); //ESSA OP��O HABILITA O ENVIO DE SMTP
    $mail->Host = 'smtp.ufabc.edu.br'; //'smtp.gmail.com'; //SERVIDOR DE SMTP, USE smtp.SeuDominio.com OU smtp.hostsys.com.br 
    $mail->Port = 587; //gmail 465 ou ufabc 587
    $mail->SMTPAuth = true; //ATIVA O SMTP AUTENTICADO
    $mail->SMTPSecure = 'tls'; //gmail ssl e ufabc tls
    $mail->Username = "$contaemail"; //    $mail->Username = "suporte.tidia@gmail.com"; //"suporte.tidia@ufabc.edu.br"; //EMAIL PARA SMTP AUTENTICADO (pode ser qualquer conta de email do seu domínio)
    $mail->Password = $pass; //    SENHA DO EMAIL PARA SMTP AUTENTICADO
    $mail->From = "$contaemail"; //    $mail->From = "suporte.tidia@gmail.com"; //E-MAIL DO REMETENTE 
    $mail->FromName = "NETEL - UFABC"; //NOME DO REMETENTE
    $mail->WordWrap = 50; // ATIVAR QUEBRA DE LINHA
    $mail->IsHTML(true); //ATIVA MENSAGEM NO FORMATO HTML
    $mail->Subject = $assunto; //ASSUNTO DA MENSAGEM
//        $mail->AddAddress($email); //E-MAIL DO DESINATÁRIO, NOME DO DESINATÁRIO --> AS VARIÁVEIS ALI PODEM FAZER REFERENCIA A DADOS VINDO DE $_GET OU $_POST, OU AINDA DO BANCO DE DADOS
//        $path = './uploads/akira.pdf';
//        $anexo = $mail->AddAttachment($path, 'akira.pdf');
//        $this->email->attach('./uploads/cert/' . $dados_aluno['nome'] . '.pdf');
//        $email = 'fabiomoto@yahoo.com.br';


    $email = $dados['email'];

    $mail->Body = $dados['corpo'];
    $mail->AddAddress($email);
    $enviou = $mail->Send();
    $mail->ClearAllRecipients();  //Limpa os destinat�rios e os anexos (DEMORA MUITO)
    $mail->ClearAttachments();

    if ($enviou) {
        return TRUE;
    } else {
//            echo $mail->print_debugger();
        echo $mail->ErrorInfo;
        return FALSE;
    }


//        foreach ($alunos as $item) {
    // consulta o BANCO + LOOP ( while ) e depois coloca o seguinte...
//https://forum.imasters.com.br/topic/471136-passar-2-parametros-pela-url/
//echo"http://www.seusite.com.br/campo1=".$rs['campo1']."&campo2=".$rs['campo2']."";
// saida -> http://www.seusite.com.br/campo1=campo1&campo2=campo2
//            $link = "<a href='http://172.17.72.39/certificador2/gerarpdf/gerar?email=$item'>CERTIFICADO</a>";
//            $mail->Body = $corpo;
//            $mail->AddAddress($item);
//            $enviou = $mail->Send();
//            $mail->ClearAllRecipients();  //Limpa os destinatários e os anexos (DEMORA MUITO)
//            $mail->ClearAttachments();
//        }
}

function enviar_mail($dados) {

    $contaemail = 'suporte.ead@gmail.com';
    $pass = 'ufabc!@#tidia';
    $assunto = 'Certificado NETEL-UFABC';
    $corpo = "corpo $dados'['id_aluno']' e $dados'['id_curso']'";

    require_once './phpmailer/PHPMailerAutoload.php';
    $alunos = Array();
    $alunos = $this->aluno_model->get_all_alunos();

//// O BLOCO ABAIXO INICIALIZA O ENVIO
    $mail = new PHPMailer; // INICIA A CLASSE PHPMAILER
    $mail->IsSMTP(); //ESSA OPÇAO HABILITA O ENVIO DE SMTP
    $mail->Host = 'smtp.gmail.com'; //SERVIDOR DE SMTP, USE smtp.SeuDominio.com OU smtp.hostsys.com.br 
    $mail->Port = 465; //gmail 465 ou 587
    $mail->SMTPAuth = true; //ATIVA O SMTP AUTENTICADO
    $mail->SMTPSecure = 'ssl';
    $mail->Username = "$contaemail"; //    $mail->Username = "suporte.tidia@gmail.com"; //"suporte.tidia@ufabc.edu.br"; //EMAIL PARA SMTP AUTENTICADO (pode ser qualquer conta de email do seu domínio)
    $mail->Password = $pass; //    SENHA DO EMAIL PARA SMTP AUTENTICADO
    $mail->From = "$contaemail"; //    $mail->From = "suporte.tidia@gmail.com"; //E-MAIL DO REMETENTE 
    $mail->FromName = "NETEL - UFABC"; //NOME DO REMETENTE
    $mail->WordWrap = 50; // ATIVAR QUEBRA DE LINHA
    $mail->IsHTML(true); //ATIVA MENSAGEM NO FORMATO HTML
    $mail->Subject = $assunto; //ASSUNTO DA MENSAGEM
//        $mail->AddAddress($email); //E-MAIL DO DESINATÁRIO, NOME DO DESINATÁRIO --> AS VARIÁVEIS ALI PODEM FAZER REFERENCIA A DADOS VINDO DE $_GET OU $_POST, OU AINDA DO BANCO DE DADOS
//        $path = './uploads/akira.pdf';
//        $anexo = $mail->AddAttachment($path, 'akira.pdf');
//        $this->email->attach('./uploads/cert/' . $dados_aluno['nome'] . '.pdf');
    $email = $dados['email'];



    $mail->Body = $corpo;
    $mail->AddAddress($email);
    $enviou = $mail->Send();
    $mail->ClearAllRecipients();  //Limpa os destinatários e os anexos (DEMORA MUITO)
    $mail->ClearAttachments();

//        foreach ($alunos as $item) {
    // consulta o BANCO + LOOP ( while ) e depois coloca o seguinte...
//https://forum.imasters.com.br/topic/471136-passar-2-parametros-pela-url/
//echo"http://www.seusite.com.br/campo1=".$rs['campo1']."&campo2=".$rs['campo2']."";
// saida -> http://www.seusite.com.br/campo1=campo1&campo2=campo2
//            $link = "<a href='http://172.17.72.39/certificador2/gerarpdf/gerar?email=$item'>CERTIFICADO</a>";
//            $mail->Body = $corpo;
//            $mail->AddAddress($item);
//            $enviou = $mail->Send();
//            $mail->ClearAllRecipients();  //Limpa os destinatários e os anexos (DEMORA MUITO)
//            $mail->ClearAttachments();
//        }
}

/* * ***** */

function utf8_encode_array($array) {
    foreach ($array as $key => $value) {
        $array[$key] = utf8_encode($value);
    }
    return($array);
}

function allow_admin_only($role) {
    if ($role != 1) {
        redirect('main');
    }
}

//function criamenu($user_id, $user_role) {
//
//    if ($user_id != NULL) {
//        switch ($user_role) {
//            case 10:
//                $menu = array(
//                    'processos/meus_processos' => 'Meus Processos',
//                );
//                break;
//            case 1:
//                $menu = array(
//                    'processos/meus_processos' => 'Meus Processos',
//                    'main/noticias' => 'Notícias',
//                    'cursos' => 'Cursos',
//                    'polos' => 'Polos',
//                    'editais' => 'Editais',
//                    'inscricoes' => 'Inscrições',
//                    'listas' => 'Listas',
//                    'homologacoes' => 'Homologações',
//                    'avaliacoes' => 'Avaliações',
//                    'prematricula' => 'Pré-Matrícula',
//                    'matricula' => 'Matrícula',
//                );
//                break;
//            case 2:
//
//                break;
//            default:
//
//                break;
//        }
//        return($menu);
//    } else {
//        return NULL;
//    }
//}
//function retornaperfil($user_role) {
//    switch ($user_role) {
//        case 10:
//            $role = "Usuário Padrão";
//            break;
//        case 1:
//            $role = "Administrador";
//            break;
//
//        default:
//
//            break;
//    }
//    return($role);
//}
//famt
//Função recebe resultado do bd ($string) referente a nível de formação e exibe 
//a nomenclatura correta, com acentuação;
//function exibe_formacao($string) {
//    $niveis = array(
//        'tecnico' => 'Técnico',
//        'graduacao' => 'Graduação Superior',
//        'especializacao' => 'Especialização',
//        'mestrado' => 'Mestrado',
//        'doutorado' => 'Doutorado',
//        'posdoutorado' => 'Pós Doutorado'
//    );
//    //caso não receba parâmetros (a $string será ''), a função retorna array para 
//    //exibir todas as nomenclaturas.ex: usado nos dropdowns.
//    switch ($string) {
//        case 'tecnico':
//            return 'Técnico';
//            break;
//
//        case 'graduacao':
//            return 'Graduação Superior';
//            break;
//
//        case 'especializacao':
//            return 'Especialização';
//            break;
//
//        case 'mestrado':
//            return 'Mestrado';
//            break;
//
//        case 'doutorado':
//            return 'Doutorado';
//            break;
//
//        case 'posdoutorado':
//            return 'Pós Doutorado';
//            break;
//
//        case '1':
//            $niveis = array(
//                '' => 'Selecione',
//                'tecnico' => 'Técnico',
//                'graduacao' => 'Graduação Superior',
//                'especializacao' => 'Especialização',
//                'mestrado' => 'Mestrado',
//                'doutorado' => 'Doutorado',
//                'posdoutorado' => 'Pós Doutorado'
//            );
//            return $niveis;
//
//        default:
//            return $niveis;
//            break;
//    }
//}
//
//function homologacao_inscricao() {
//    $array_homologacao = array(
//        '0' => 'Aguardando Homologação',
//        '1' => 'Homologado',
//        '2' => 'Não Homologado',
//        '10' => 'Qualquer Status');
//    return $array_homologacao;
//}
//
//function status_prematricula() {
//    $array_prematricula = array(
//        '0' => 'Aguardando Candidato',
//        '1' => 'Não Realizada',
//        '2' => 'Realizada Pendente',
//        '3' => 'Realizada Concluída',
//        '10' => 'Qualquer Status');
//    return $array_prematricula;
//}
//
//function status_matricula() {
//    $array_matricula = array(
//        '0' => 'Em Processamento',
//        '1' => 'Pendente',
//        '2' => 'Confirmada',
//        '3' => 'Indeferida',
//        '4' => 'Eliminado do Processo',
//        '5' => 'Cancelado após matrícula',
//        '10' => 'Qualquer Status');
//    return $array_matricula;
//}
//function dados_usuarios() {
//    $array_dados_usuarios = array(
//        //tabela users
//        'email' => 'E-mail',
//        'cpf' => 'CPF',
//        //tabela user_infos
//        'nome' => 'Nome',
//        'sexo' => 'Sexo',
//        'nome_mae' => 'Nome da mãe',
//        'nome_pai' => 'Nome do pai',
//        'data_nasc' => 'Data de nascimento',
//        'cidade_nasc' => 'Naturalidade',
//        'estado_nasc' => 'Estado de nascimento',
//        'pais_nasc' => 'País de nascimento',
//        'nacionalidade' => 'Nacionalidade',
//        'passaporte' => 'Passaporte',
//        'endereco' => 'Endereço',
//        'complemento' => 'Complemento',
//        'bairro' => 'Bairro',
//        'cidade' => 'Cidade',
//        'cep' => 'CEP',
//        'estado' => 'Estado',
//        'pais' => 'País',
//        'telefone_fixo_dd' => 'DDD(fixo)',
//        'telefone_fixo_num' => 'Telefone fixo',
//        'telefone_celular_dd' => 'DDD(cel)',
//        'telefone_celular_num' => 'Telefone celular',
//        //RG
//        'rg_num' => 'RG',
//        'rg_orgao_expeditor' => 'Órgão expedidor',
//        'rg_estado' => 'Estado do RG',
//        'rg_data_emissão' => 'Data de emissão do RG',
//        //Alistamento militar
//        'militar_num' => 'Alistamento militar',
//        'militar_reparticao' => 'Repartição militar',
//        'militar_data_emissão' => 'Data de emissão (militar)',
//        'militar_tipo' => 'Tipo de certificado militar',
//        //Título eleitoral
//        'eleitor_num' => 'Título eleitoral',
//        'eleitor_zona' => 'Zona eleitoral',
//        'eleitor_secao' => 'Seção',
//        'eleitor_data_emissao' => 'Data de emissão (título)',
//        'eleitor_data_ultima_votacao' => 'Data da última votação',
//        'eleitor_justificou' => 'Justificativa de eleição',
//    );
//    return $array_dados_usuarios;
//}
//opções para geração de lista: user_editals 
//function dados_user_editals() {
//    $array_dados_user_editals = array(
//        'just_homologado' => 'Justificativa da inscrição',
//        'just_prematricula' => 'Justificativa da pré-matrícula',
//        'just_matricula' => 'Justificativa da matrícula',
//        'pontuacao' => 'Pontuação',
//    );
//    return $array_dados_user_editals;
//}
//Função para utilizar mais de um botão no form ;
//(ref. http://simplesideias.com.br/multiplos-botoes-submit-em-um-formulario)
function multi_bt_form($name) {
    $params = func_get_args();

    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
}

/**
 * Recebe a data em formato BR dd/mm/aaaa e retorna para inserir no mysql (yyyy-mm-dd).
 * @param $data Data em formato BR dd/mm/aaaa.
 * @return string Data em formato mysql yyyy-mm-dd
 */
function data_converte_br_mysql($data) {
    $date = implode("-", array_reverse(explode("/", $data)));
    return $date;
}

/**
 * Recebe a data em formato mysql (yyyy-mm-dd) e retorna BR dd/mm/aaaa.
 * @param $data Data em formato mysql (yyyy-mm-dd).
 * @return string Data em formato BR dd/mm/aaaa.
 */
function data_converte_mysql_br($data) {
    $date = implode("/", array_reverse(explode("-", $data)));
    return $date;
}
