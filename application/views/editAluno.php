<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    
    if (isset($error)):
        echo $error;
    endif;
    //    if ($this->session->flashdata('success') == TRUE):
//        echo $this->session->flashdata('success');
//    endif;
    
/*    <?php if ($this->session->flashdata('error') == TRUE): ?>
	<p><?php echo $this->session->flashdata('error'); ?></p>
<?php endif; ?>
<?php if ($this->session->flashdata('success') == TRUE): ?>
	<p><?php echo $this->session->flashdata('success'); ?></p>
<?php endif; ?>*/
    echo validation_errors('<h5 style="color:red">', '</h5>');

    if($aluno != NULL && $aluno != ''){
        
        echo form_open('Alunos/editarAluno','');
        echo form_hidden('id_aluno', $aluno['id_aluno']);
        echo form_label('Nome: ');
        echo form_input(array('name' => 'nome', 'value'=>$aluno['nome'], 'size'=>'40', 'style'=>'height:30px;'));
        echo br(2);
        echo form_label('E-mail: ');
        echo form_input(array('name' => 'email', 'type'=>'email' ,'value'=>$aluno['email'], 'size'=>'40', 'style'=>'height:30px'));
        echo br(2);
        echo form_submit(array('name' => 'editarAluno'), 'Editar');
        echo form_close();
                        
        
        /*<form method="post" action="<?=base_url('atualizar')?>" enctype="multipart/form-data">
		<div>
			<label>Nome:</label>
			<input type="text" name="nome" value="<?=$contato['nome']?>" required/>
		</div>
		<div>
			<label>Email:</label>
			<input type="email" name="email" value="<?=$contato['email']?>" required/>
		</div>
	<div>
		<label><em>Todos os campos são obrigatórios.</em></label>
		<input type="hidden" name="id" value="<?=$contato['id']?>"/>
		<input type="submit" value="Salvar" />
	</div>
</form>*/
        
        
        
            
//          echo  anchor("Listas/editarAlunoCurso/$row[id_aluno]/$row[id_curso]/$row[id]/$row[cod_validacao]",'Editar');
//          br(2);
//          echo  anchor("Listas/excluirAlunoCurso/$row[id_aluno]/$row[id_curso]/$row[id]/$row[cod_validacao]",'Excluir');
            
        
        
        
    }