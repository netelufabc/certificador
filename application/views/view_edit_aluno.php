<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (isset($error))://?
    echo $error;
endif;

if ($this->session->flashdata('success') == TRUE):
    echo $this->session->flashdata('success');
endif;

if ($_SESSION['status'] == 1) {

    echo form_open("Admin/editar_aluno/$id_curso/$id_aluno");
    echo validation_errors('<h5 style="color:red">', '</h5>');

    echo br(1);
    echo "<div id='borda'>";
    echo "<h4><b>Alterar dados do Aluno: $dados_aluno->nome</b></h4>";
    echo br(1);
    echo "<div id='col_left'>";
    echo form_label('Nome do aluno: ');
    echo br(2);
    echo form_label('E-mail: ');
    echo br(2);
    echo form_label('Conceito: ');
    echo br(2);
    echo form_label('Faltas (em horas): ');
    echo br(2);
	echo form_label('CPF: ');
    echo br(2);
    echo form_label('RNE: ');
    echo br(2);
  //  echo form_label('Nível (somente idiomas): ');
  //  echo br(2);
    echo form_label('Status: ');
    echo br(2);
    echo "</div>"; //coluna esquerda

    echo "<div id='col_right'>";
    echo form_input(array('name' => 'nomeAluno', 'required' => 'required'), set_value('edital', $dados_aluno->nome), '', 'autofocus');
    echo br(2);
    echo form_input(array('name' => 'email', 'required' => 'required', 'readonly' => 'readonly'), set_value('edital', $dados_aluno->email));
    echo br(2);
    echo form_input(array('name' => 'conceito'), set_value('edital', $dados_aluno->conceito));
    echo br(2);
    echo form_input(array('name' => 'faltas_em_horas'), set_value('edital', $dados_aluno->faltas_em_horas));
    echo br(2);
	echo form_input(array('name' => 'cpf'), set_value('cpf', $dados_aluno->cpf));
    echo br(2);
    echo form_input(array('name' => 'rne'), set_value('rne', $dados_aluno->rne));
    echo br(2);
   // echo form_input(array('name' => 'nivel_idiomas'), set_value('edital', $nivel_idiomas));
   // echo br(2);
    echo form_dropdown('status', array('' => 'Selecione...', 'Aprovado' => 'Aprovado', 'Reprovado' => 'Reprovado'),'','required');
    echo br(2);

    echo "</div>"; //coluna direita

    echo br(2);
    echo form_submit(array('name' => 'botao_alterar'), 'Alterar Dados do Aluno');
    echo form_close();
    echo br(2);
    echo "</div>";

    echo br(1);
    echo anchor("Admin/listarAlunosDoCurso/$id_curso", 'Retornar à lista de alunos do curso');
} else {
    redirect('Admin');
}