<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (isset($lista) && ($lista != NULL || $lista != '' || $lista != FALSE )) {
    echo form_label('<h3><b>' . $lista[0]['nome'] . '</b></h3>');
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
        if ($row['status'] == 'aprovado' || $row['status'] == "Aprovado") {
            $this->table->add_row(
                    $row['nomeCurso'], 
                    $row['dataIni'], 
                    $row['dataFim'],
                    //descomentar abaixo para exibir opção de gerar o certificado sem enviar por e-mail
                    /*anchor("GerarPdf/gerarFPdf/$row[id_aluno]/$row[id_curso]/$row[id_alunocurso]/$row[cod_validacao]/$email", img(array('src' => 'images/preview_icon.png', 'border' => '0', 'alt' => "Visualizar certificado", 'height' => '25')),['target' => '_blank']) .nbs(5).*/
                    anchor("Alunos/enviarCertificadoAluno/$row[id_aluno]/$row[id_curso]/$row[id_alunocurso]/$row[cod_validacao]/$email", img(array('src' => 'images/mail_icon.png', 'border' => '0', 'alt' => "Notificar Usuário", 'height' => '25'))));
        } else {
            $this->table->add_row($row['nomeCurso'], $row['dataIni'], $row['dataFim'], "<span style='font-size:10px'>Não atingiu requisitos mínimos<span/>");
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
    $this->table->set_heading('NOME');
    
    echo br(2);

    foreach ($nomes as $row) {
        $this->table->add_row(anchor("Alunos/listarCertificadosDoAluno/".urlencode($row['email']), $row['nome']));
        
    }

    echo $this->table->generate();
    echo br(1);
    echo anchor('Main', 'VOLTAR');
    
} else {
    echo br(1);
    if (isset($error)) {
        echo "<h5 style='color: #FF0000'>" . $error . $email . " </h5>";
    }
    echo form_open('Alunos/listarCertificadosDoAluno');
    echo form_label('<h4>Busque pelo nome ou e-mail cadastrado no curso </h4>');
    echo br(1);
    echo "<input type='text' name='textBusca' required>"; //utilizando os recurso "required" do html5
    echo br(2);
    echo form_submit(array('name' => 'certificado_user'), 'Buscar certificado');
    echo form_close();
}