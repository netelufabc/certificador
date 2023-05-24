<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (isset($error))://?
    echo $error;
endif;

if ($this->session->flashdata('success') == TRUE):
    echo $this->session->flashdata('success');
endif;

if ($_SESSION['status'] > 0) {

    echo form_open("Admin/editar_aluno/$id_aluno/$id_curso");
    echo validation_errors('<h5 style="color:red">', '</h5>');
    $no_curso = null;
    if ($id_curso != NULL) {
        $no_curso = 'no curso<br/>';
    }

    echo br(1);
    echo "<div id='borda'>";
    echo "<h4><b>Alterar dados do participante $no_curso</b></h4>"; //$dados_aluno->nome
    echo br(1);
    echo "<div id='col_left'>";
    echo form_label('Nome do aluno: ');
    echo br(2);
    echo form_label('E-mail: ');
    echo br(2);
    echo form_label('Tipo do documento: ');
    echo br(2);
    echo form_label('Número do documento: ');
    echo br(2);
//    echo form_label('Passaporte: ');
//    echo br(2);
    if ($id_curso != NULL) {
        echo form_label('Conceito: ');
        echo br(2);
        echo form_label('Faltas (em horas): ');
        echo br(2);
        echo form_label('Aprovado: ');
        echo br(2);
    }
    if ($id_curso != NULL) {
        echo anchor("Admin/listarAlunosDoCurso/$id_curso", '<button type="button"><span style="color: black;">Cancelar</span></button>'). nbs(2);
    } else {
        echo anchor("Alunos/listarCertificadosDoAluno/".urlencode($dados_aluno->email), 'Voltar');
    }
    echo "</div>"; //coluna esquerda

    echo "<div id='col_right'>";
    echo form_input(array('name' => 'nomeAluno', 'required' => 'required'), set_value('edital', $dados_aluno->nome), '', 'autofocus');
    echo br(2);
    echo form_input(array('name' => 'email', 'required' => 'required'), set_value('edital', $dados_aluno->email));
    echo br(2);
    echo form_input(array('name' => 'tipo_doc'), set_value('tipo_doc', $dados_aluno->tipo_doc));
    echo br(2);
    echo form_input(array('name' => 'num_doc'), set_value('num_doc', $dados_aluno->num_doc));
    echo br(2);
//    echo form_input(array('name' => 'passaporte'), set_value('passaporte', $dados_aluno->passaporte));
//    echo br(2);
    if ($id_curso != NULL) {
        echo form_input(array('name' => 'conceito'), set_value('edital', $dados_aluno->conceito));
        echo br(2);
        echo form_input(array('name' => 'faltas_em_horas'), set_value('edital', $dados_aluno->faltas_em_horas));
        echo br(2);
        echo form_dropdown('aprovado', array('' => 'Selecione...', 's' => 'Sim', 'n' => 'Não',), set_value('aprovado', $dados_aluno->aprovado));
        echo br(2);
    }
    echo nbs(2).form_submit(array('name' => 'botao_alterar'), 'Enviar Dados');
    echo form_close();
    echo "</div>"; //coluna direita
    if ($id_curso != NULL) {
        echo br(20);
    } else {
        echo br(14);
    }
    echo "</div>"; //borda
    echo br(1);
//    if ($id_curso != NULL) {
//        echo anchor("Admin/listarAlunosDoCurso/$id_curso", 'Cancelar edição');
//    } else {
//        echo anchor("Alunos/listarCertificadosDoAluno/".urlencode($dados_aluno->email), 'Voltar');
//    }
} else {
    redirect('Admin');
}