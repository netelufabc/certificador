<?php

echo heading('Recuperar senha', 1);

echo form_open('ctrl_senha/email_recuperar_senha', array('name' => 'recupera_form', 'class' => 'basic-grey'));

if (validation_errors() != NULL) {
    echo "<div class=\"validation_errors\">";
    echo validation_errors('<p>', '</p>');
    echo "</div><br>";
}

if ($this->session->flashdata('not_found')) {
    echo "<div class=\"message_error\">";
    echo $this->session->flashdata('not_found');
    echo "</div><br>";
}
//<input type="text" name="cpf" onBlur="ValidarCPF(form1.cpf);" 
//onKeyPress="MascaraCPF(form1.cpf);" maxlength="14">
echo form_label('CPF: ');
$so_num = 'onkeyup="apenasnumero(cpf)"';
echo form_input(array('type' => 'text', 'name' => 'cpf', 'maxlength' => '11', 'pattern' => '[0-9]+$', 'title' => 'Digite apenas números'), set_value('cpf'), $so_num); //mascara do cpf deve ser o terceiro parâmetro
echo "<div class='form-tooltip'>Digite seu CPF, apenas números.</div>";

echo "<br><br>";
echo form_submit(array('name' => 'recuperar_senha'), 'Recuperar Senha');
echo form_close();

echo form_open('ctrl_main');
echo form_submit(array('name' => 'voltar'), 'Cancelar');
echo form_close();
