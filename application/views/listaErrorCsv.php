<?php

defined('BASEPATH') OR exit('No direct script access allowed');


if (isset($error)):
    echo $error;
endif;
//    if ($this->session->flashdata('success') == TRUE):
//        echo $this->session->flashdata('success');
//    endif;

if ($listaError != NULL || $listaError == '') {

    $att = array('style' => 'color: red;');
    echo form_label('<h3>O ARQUIVO (.CSV) CONTÉM ERROS</h3>', '', $att);

    echo form_label('Verifique os dados dos participantes abaixo no arquivo .CSV e repita do procedimento para gerar os certificados do curso', '', $att);

    $template = array(
        'table_open' => '<table border="1" cellpadding="10" >',
    );

    $this->table->set_template($template);

    foreach ($listaError as $row) {
            //exibe lista de erro para certificados gerais sem NÍVEL
            $this->table->set_heading('LINHA NO .CSV', 'NOME', 'E-MAIL');
            $this->table->add_row($row['line'], utf8_decode($row['nome']), $row['email']);
    }
    
    echo $this->table->generate();
}
echo br(1);
echo "<a href='javascript:void(0)' onClick='history.go(-1); return false;'>VOLTAR</a>";
echo br(2);
echo anchor('Admin', 'Listar eventos');
