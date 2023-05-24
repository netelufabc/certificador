<?php

if($this->session->flashdata('senha_atual_errada')){
    echo "<p style='color: red'>".$this->session->flashdata('senha_atual_errada')."</p>";
    echo br(1);
}
echo form_open('Login/update_pass', array('class' => 'basic-grey'));

echo form_label('Senha atual: ');
echo form_password(array('name' => 'pass_atual', 'required'=>'required'), 'autofocus');

echo br(2);
echo form_label('Nova Senha: ');
echo form_password(array('name' => 'pass_new','required'=>'required'));

echo "<br><br>";
echo form_submit(array('name' => 'Alterar'), 'Alterar Senha');

echo form_close();

//echo phpinfo();
