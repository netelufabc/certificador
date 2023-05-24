<?php

defined('BASEPATH') OR exit('No direct script access allowed');
if ($this->session->flashdata('sucesso')) {
        echo "<div class=\"message_success\">";
        echo $this->session->flashdata('sucesso');
        echo "</div>";
    }

if (isset($lista) && ($lista != NULL || $lista != '' || $lista != FALSE )) {

    if (isset($_SESSION['status']) && $_SESSION['status'] > 0) {//acesso admin
        //echo form_label('<h3><b>' . mb_strtoupper($lista[0]['nome']) . '</b></h3>'); //anchor("Admin/editar_aluno/$id_curso/$row[id_aluno]", $row['nome'])
        echo "<h3><b>".anchor('Admin/editar_aluno/'.$lista[0]['id_aluno'], mb_strtoupper($lista[0]['nome']))."</b></h3>";
//        $visualizar_cert = anchor('GerarPdf/gerarFPdf/'.$lista[0]['id_aluno'].'/'.$lista[0]['id_curso'].'/'.$lista[0]['id_alunocurso'].'/'.$lista[0]['cod_validacao'].'/'. urlencode($lista[0]['email']), img(array('src' => 'images/icons/preview_icon.png', 'border' => '0','alt' => "Visualizar certificado", 'height' => '25')), ['target' => '_blank']);
    //'alt' => "Visualizar certificado"
        
//        $curso = anchor("Admin/listarAlunosDoCurso/" . $lista[0]['id_curso'], $lista[0]['nomeCurso']);
        
        
    } else {
        echo form_label('<h3><b>' . mb_strtoupper($lista[0]['nome']) . '</b></h3>');

        $visualizar_cert = NULL;
        $curso = $lista[0]['nomeCurso'];
    }
    echo br(1);
    if (isset($msg)) {
        echo "<h5 style='color: #0000FF'>" . $msg . "</h5>";
    }
    $template = array(
        'table_open' => '<table border="1" class="tabela">',
    );
    $this->table->set_template($template);
    $this->table->set_heading('CURSO', 'INÍCIO', 'TÉRMINO', 'CERTIFICADOS');

    $email = urlencode($lista[0]['email']);
    foreach ($lista as $row) {
        if(isset($_SESSION['status']) && $_SESSION['status'] > 0){
//            echo "<h3><b>".anchor('Admin/editar_aluno/'.$lista[0]['id_aluno'], mb_strtoupper($lista[0]['nome']))."</b></h3>";
            $visualizar_cert = anchor('GerarPdf/gerarFPdf/'.$row['id_aluno'].'/'.$row['id_curso'].'/'.$row['id_alunocurso'].'/'.$row['cod_validacao'].'/'. urlencode($row['email']), img(array('src' => 'images/icons/preview_icon.png', 'border' => '0','alt' => "Visualizar certificado", 'height' => '25')), ['target' => '_blank']);
            $curso = anchor("Admin/listarAlunosDoCurso/" . $row['id_curso'], $row['nomeCurso']);
        }else{
            $visualizar_cert = NULL;
            $curso = $row['nomeCurso'];
        }
        
        if (strtolower($row['aprovado']) == 's' || $row['aprovado'] == NULL) {
            $this->table->add_row(
                    $curso, $row['dataIni'], $row['dataFim'],
                    
                    //trecho para tentar envir via POST
//                    form_open("Alunos/enviarCertificadoAluno/$row[id_aluno]/$row[id_curso]/$row[id_alunocurso]/$row[cod_validacao]/".urlencode($email)),
//                    form_submit(array('name' => 'dados'), 'Notificar Aluno'));
                    anchor("Alunos/enviarCertificadoAluno/$row[id_aluno]/$row[id_curso]/$row[id_alunocurso]/$row[cod_validacao]/$email", img(array('src' => 'images/icons/mail_icon.png', 'border' => '0', 'alt' => "Notificar Usuário", 'height' => '25'))).nbs(3).
                    $visualizar_cert);
        } else {
            $this->table->add_row($curso, $row['dataIni'], $row['dataFim'], "<span style='font-size:10px'>Não atingiu requisitos mínimos<span/>");
        }
    }
    echo $this->table->generate();
    echo br(1);
    echo anchor('Main', 'VOLTAR');
} elseif (isset($nomes) && $nomes != FALSE && $nomes != NULL && $nomes != '') {
    //listar nomes
    $template = array(
        'table_open' => '<table border="1" class="tabela">',
    );
    $this->table->set_template($template);
    $this->table->set_heading('NOME', 'E-MAIL');

    echo br(2);

    foreach ($nomes as $row) {
        $this->table->add_row(anchor("Alunos/listarCertificadosDoAluno/" . urlencode($row['email']), mb_strtoupper($row['nome'])), strtolower($row['email']));
    }

    echo $this->table->generate();
    echo br(1);
    echo anchor('Main/gerar_certificado', 'VOLTAR');
} else {

    if (isset($error)) {
        echo "<h5 style='color: #FF0000'>" . $error . $email . " </h5>";
    }
    echo form_open('Alunos/listarCertificadosDoAluno');
    echo form_label('<h3>CERTIFICADO</h3>');
    echo br(1);
    echo form_label('<h4>Busque pelo nome ou e-mail cadastrado no evento</h4>');
    echo br(1);
    echo "<input type='text' name='textBusca' required>"; //utilizando os recurso "required" do html5
    echo br(2);
    echo form_submit(array('name' => 'certificado_user'), 'Buscar certificado');
    echo form_close();
}