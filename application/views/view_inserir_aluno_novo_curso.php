<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!isset($_SESSION['status']) || $_SESSION['status'] == 0) {
    redirect('Admin');
}

if ($this->session->flashdata('no_file_selected')) {
    echo "<div class=\"message_error\">";
    echo $this->session->flashdata('no_file_selected');
    echo "</div><br>";
}

if (isset($listaCursos)) {
    echo "<div id='borda'>";
    echo "<h5><b>Preencha a planilha com os dados dos participantes</b></h5>";
//    echo br(1);
    echo anchor('/templates/MODELO_PLANILHA.xlsx', 'Modelo da planilha');
    echo br(2);
    echo "<h4><b>Selecione o evento para inserir participantes</b></h4>";
    echo br(1);

    $this->table->set_template(array("table_open" => "<table class='tabela'>"));
    $this->table->set_heading('', 'EVENTO (clique para selecionar)', 'EDITAL', 'INÍCIO', 'TÉRMINO', 'LISTAR'); //, 'EXCLUIR CURSO');
    $i = count($listaCursos);
    foreach ($listaCursos as $row) {
        $this->table->add_row($i, anchor("Admin/inserir_alunos_novo_curso/$row[id_curso]", $row['nomeCurso']), $row['edital'], $row['dataIni'], $row['dataFim'], anchor("Admin/listarAlunosDoCurso/$row[id_curso]", 'Inscritos')); //, anchor("Admin/excluirCurso/$row[id_curso]", 'Excluir'));
        $i--;
    }
    echo $this->table->generate();
} else {

    echo form_open_multipart("Admin/inserir_do_arquivo/$dadosCurso[id_curso]");
    echo validation_errors('<h5 style="color:red">', '</h5>');

    echo "<div id='borda'>";
    
    echo "<h4><b>" . $dadosCurso['nomeCurso'] . br(2)."Edital: " . $dadosCurso['edital'] . "</b><br/>(" . $dadosCurso['dataIni'] . " - " . $dadosCurso['dataFim'] . ")</h4>";

    echo br(1);
    echo form_label('Selecione a planilha com os dados dos participantes: ');
    echo br(1);
    echo anchor('/templates/MODELO_PLANILHA.xlsx', 'Modelo da planilha');
    echo form_input(array('name' => 'csvfile', 'type' => 'file', "required" => "required"));
    echo br(2);
    echo form_submit(array('name' => 'cadastrar_alunos'), 'Inserir participantes no evento');
    echo form_close();
    echo br(2);
    echo "</div>"; //borda    

    echo br(1);
    echo anchor('Admin', 'Listar eventos');
}