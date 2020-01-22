<?php

defined('BASEPATH') OR exit('No direct script access allowed');


if (isset($error)):
    echo $error;
endif;
//    if ($this->session->flashdata('success') == TRUE):
//        echo $this->session->flashdata('success');
//    endif;

if ($lista != NULL && $lista != '') {

    echo form_label('<h3>' . $lista[0]['nome'] . '</h3>');
    if (isset($msg)):
        echo $msg;
    endif;

    $template = array(
        'table_open' => '<table border="1" cellpadding="10" >',
    );
    $this->table->set_template($template);
    $this->table->set_heading('CURSO', 'INÍCIO', 'TÉRMINO', ' ');

    $email = urlencode($lista[0]['email']);
    foreach ($lista as $row) {
        if($row['status']=='aprovado'){
        //link para o aluno gerar o certificado de forma online
//        $this->table->add_row($row['nomeCurso'], $row['dataIni'], $row['dataFim'], anchor("GerarPdf/gerar/$row[id_aluno]/$row[id_curso]/$row[id_alunocurso]/$row[cod_validacao]", 'Certificado', "target='blank'"));
        //link para o aluno gerar o certificado online
        $this->table->add_row($row['nomeCurso'], $row['dataIni'], $row['dataFim'], anchor("Alunos/enviarCertificado/$row[id_aluno]/$row[id_curso]/$row[id_alunocurso]/$row[cod_validacao]/$email", 'Certificado'));
        }else{
            $this->table->add_row($row['nomeCurso'], $row['dataIni'], $row['dataFim'],'Reprovado');
    }
    }
    echo $this->table->generate();
}
echo anchor('Main','Página Incial');