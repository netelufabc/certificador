<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!isset($_SESSION['status']) || $_SESSION['status'] != 1) {
    redirect('Admin');
}

if ($this->session->flashdata('no_file_selected')) {
    echo "<div class=\"message_error\">";
    echo $this->session->flashdata('no_file_selected');
    echo "</div><br>";
}

if (isset($listaCursos)) {
    echo "<div id='borda'>";
    echo "<h4><b>Selecione o curso para inserir alunos</b></h4>";
    echo br(1);

    $this->table->set_template(array("table_open" => "<table class='tabela'>"));
    $this->table->set_heading('','CURSO (clique para selecionar)', 'EDITAL', 'INÍCIO', 'TÉRMINO', 'LISTAR'); //, 'EXCLUIR CURSO');
    $i = count($listaCursos);
    foreach ($listaCursos as $row) {
        $this->table->add_row($i,anchor("Admin/inserir_alunos_novo_curso/$row[id_curso]", $row['nomeCurso']), $row['edital'], $row['dataIni'], $row['dataFim'], anchor("Admin/listarAlunosDoCurso/$row[id_curso]", 'Inscritos')); //, anchor("Admin/excluirCurso/$row[id_curso]", 'Excluir'));
        $i--;
    }
    echo $this->table->generate();
} else {

    echo form_open_multipart("Admin/inserir_do_csv/$dadosCurso[id_curso]");
    echo validation_errors('<h5 style="color:red">', '</h5>');

    echo "<div id='borda'>";
    echo "<h4><b>Selecione arquivo com os alunos para inserir no curso:</b></h4>";
    echo "<h4>" . $dadosCurso['nomeCurso'] . "<br>Edital: " . $dadosCurso['edital'] . " (" . $dadosCurso['dataIni'] . " - " . $dadosCurso['dataFim'] . ")</h4>";

    echo br(1);
    echo form_label('Selecione o arquivo CSV com os nomes e e-mails dos participantes: ');
    echo "<br/><a href='/certificador/templates/1_MODELO_CSV.csv'>(Modelo CSV)</a>";
    echo form_input(array('name' => 'csvfile', 'type' => 'file', "required" => "required"));
    echo br(2);
    echo form_submit(array('name' => 'cadastrar_alunos'), 'Inserir alunos no Curso');
    echo form_close();
    echo br(2);
    echo "</div>"; //borda    

    echo anchor('Admin/inserir_alunos_novo_curso', 'Cancelar');
}