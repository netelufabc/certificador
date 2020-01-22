<!-- view para edição de cursos (GUC) -->
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (isset($error)):
    echo $error;
endif;
if ($this->session->flashdata('success') == TRUE):
    echo $this->session->flashdata('success');
endif;

if ($_SESSION['status']==1) {

//    if (isset($mail)/* $mail != NULL || $mail != ''*/) {
//        foreach ($mail as $valor) {
//            echo $valor['nome'];
//            echo br(2);
//        }
//    }

    echo form_open("Admin/editar_curso/$curso_id");
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
    echo "</div>";//coluna esquerda
    
    echo "<div id='col_right'>";
    echo form_input(array('name' => 'nomeCurso', 'required'=>'required'), set_value('edital', $dados_do_curso['nomeCurso']), '', 'autofocus' );
    echo br(2);
    echo form_input(array('name' => 'edital','required'=>'required'), set_value('edital', $dados_do_curso['edital']));
    echo br(2);
    echo "<input type=\"date\" name=\"dataInicio\" min=\"2016-01-01\" max=\"2021-12-31\" value=\"". date("Y-m-d",strtotime(str_replace('/','-',$dados_do_curso['dataIni']))) . "\">";
    echo br(2);
    echo "<input type=\"date\" name=\"dataFim\" min=\"2016-01-01\" max=\"2021-12-31\" value=\"". date("Y-m-d",strtotime(str_replace('/','-',$dados_do_curso['dataFim']))) . "\">";
    echo br(2);
    echo form_input(array('name' => 'cargaHoraria', 'size' => '2', 'required'=>'required'), set_value('cargaHoraria', $dados_do_curso['cargaHoraria']));
    echo form_label(' horas');
    echo "</div>";//coluna direita
    
    echo br(2);
    echo form_submit(array('name' => 'botao_alterar'), 'Alterar Dados do Curso');
    echo form_close();
    echo br(2);
    echo "</div>";

    echo anchor('Admin', 'LISTA DE CURSOS');

} else {
    redirect('Admin');
}