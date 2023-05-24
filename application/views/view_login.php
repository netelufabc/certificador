<?php

if($this->session->flashdata('invalid_credentials')){
    echo "<p style='color: red'>".$this->session->flashdata('invalid_credentials')."</p>";
    echo br(1);
}
echo form_open('Login/logarLocal', array('class' => 'basic-grey'));

echo form_label('Login: ');
echo form_input(array('name' => 'login', 'required'=>'required'), set_value('login'), 'autofocus');

echo br(2);
echo form_label('Senha: ');
echo form_password(array('name' => 'pass','required'=>'required'));

echo "<br><br>";
echo form_submit(array('name' => 'Login'), 'Efetuar Login');

echo form_close();

//echo phpinfo();
