<?php

if ($this->session->flashdata('alterar_curso_ok')) { //mostrar msg de alterado curso com sucesso
    echo "<div class=\"message_success\">";
    echo $this->session->flashdata('alterar_curso_ok');
    echo "</div>";
}

if ($this->session->flashdata('novo_curso_ok')) { //mostrar msg de alterado curso com sucesso
    echo "<div class=\"message_success\">";
    echo $this->session->flashdata('novo_curso_ok');
    echo "</div>";
}

if ($this->session->flashdata('inserir_alunos_ok')) { 
    echo "<div class=\"message_success\">";
    echo $this->session->flashdata('inserir_alunos_ok');
    echo "</div>";
}

echo form_label('<h4>Cursos</h4>');
echo br(1);

if (isset($listaCursos)) {

    $template = array(
        "table_open" => "<table class='tabela'>",
    );
    $this->table->set_template($template);
    $this->table->set_heading('','CURSO (clique para editar)', 'EDITAL', 'INÍCIO', 'TÉRMINO', 'LISTAR'); //, 'EXCLUIR CURSO');
    $i = count($listaCursos);
    foreach ($listaCursos as $row) {
        $this->table->add_row($i,anchor("Admin/editar_curso/$row[id_curso]", $row['nomeCurso']), $row['edital'], $row['dataIni'], $row['dataFim'], anchor("Admin/listarAlunosDoCurso/$row[id_curso]", 'Inscritos')); //, anchor("Admin/excluirCurso/$row[id_curso]", 'Excluir'));
        $i--;
    }
    echo $this->table->generate();
} else {
    echo '<h5>NENHUM CERTIFICADO REGISTRADO</h5>';
}

echo br(2);
