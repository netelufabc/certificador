<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (isset($error)):
    echo "<span style='color:red'>" . $error . "</span>";
endif;
if ($this->session->flashdata('success') == TRUE):
    echo $this->session->flashdata('success');
endif;

if ($this->session->flashdata('no_file_selected')) {
    echo "<div class=\"message_error\">";
    echo $this->session->flashdata('no_file_selected');
    echo "</div><br>";
}

if ($_SESSION['status'] > 0) {

    if (isset($mail)/* &&$mail != NULL || $mail != '' */) {
        foreach ($mail as $valor) {
            echo $valor['nome'];
            echo br(2);
        }
    }

    echo form_open_multipart('Admin/gerarCertificadoNovoCurso');
    echo validation_errors('<h5 style="color:red">', '</h5>');

    echo br(1);
    echo "<div id='borda'>";
    echo "<h4><b>Cadastro de curso e emissão de certificados</b></h4>";
    echo br(1);
    echo "<div id='col_left'>";
    echo form_label('Nome do curso: ');
    echo br(2);
    echo form_label('Edital: ');
    echo br(2);
    echo form_label('Data do início: ');
    echo br(2);
    echo form_label('Data do término: ');
    echo br(2);
    echo form_label('Carga horária: ');
    echo br(2);

    echo "</div>"; //coluna esquerda

    echo "<div id='col_right'>";
    echo form_input(array('name' => 'nomeCurso', 'required' => 'required'), '', 'autofocus');
    echo br(2);
    echo form_input(array('name' => 'edital', 'required' => 'required'), '', "placeholder='ex: NTME 01/2018'");
    echo br(2);
    echo "<input type=\"date\" name=\"dataInicio\" min=\"2016-01-01\" max=\"2025-12-31\"  required>";
    echo br(2);
    echo "<input type=\"date\" name=\"dataFim\" min=\"2016-01-01\" max=\"2025-12-31\" required>";
    echo br(2);
    echo form_input(array('name' => 'cargaHoraria', 'size' => '3', 'required' => 'required'));
    echo form_label(' horas');
    echo br(2);
    echo "</div>"; //coluna direita

//    if ($certificados != FALSE) {
//        foreach ($certificados as $row) {
//            $mod_certificado = array(//precisa fazer dinâmico carregando a partir do bd
//            $row['id_certificado'] => $row['nome_certificado'],
//                );
//        }
//    }
    $mod_certificado = array(//precisa fazer dinâmico carregando a partir do bd
        '' => 'Selecione o modelo do certificado',
        '1' => 'NTE - Padrão',
        '2' => 'REA'
    );
    echo form_dropdown('mod_certificado', $mod_certificado, '', 'required');
    echo br(2);

    echo form_label('Selecione o arquivo CSV com os nomes e e-mails dos participantes: ');
    echo "<br/><a href='../templates/1_MODELO_CSV.csv'>(Modelo CSV)</a>";
    echo form_input(array('name' => 'csvfile', 'type' => 'file'));
    echo br(2);
    echo form_submit(array('name' => 'cadastrar'), 'Gerar certificados e notificar por E-mail');
    echo form_close();
    echo br(2);
    echo "</div>"; //borda    
//    if ($erro_email != NULL) {
//        foreach ($email as $mail) {
//            echo $mail;
//        }
//    }
    echo anchor('Admin', 'Listar eventos');
} else {
    redirect('Admin');
}