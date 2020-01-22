<link rel="stylesheet" type="text/css" href="./css/style.css">
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if(isset($nome)){
	echo br(1);
    echo "<div id='borda'>";
    echo "<h3 align='center'>CERTIFICADO VÁLIDO EMITIDO PARA</h3>";
    echo br(1);
    echo "Participante: <b>".$nome."</b>";
    echo br(2);
    echo "Curso: <b>$nomeCurso</b>";
    echo br(2);
    if($nivel != NULL || $nivel != ''){
        
        echo "Nível (QCER): <b>$nivel</b>";
        echo br(2);
    }
    
    if($conceito != NULL || $conceito != ''){
        echo "Conceito: <b>$conceito</b>";
    }else{
        echo "Conceito: <b>Curso sem avaliação</b>";
    }
    echo br(2);
    echo "Carga horária: <b>$cargaHoraria horas</b>";
    echo br(2);
    
    $freq = 100 - ($faltas_em_horas * 100) / $cargaHoraria;
    echo "Frequência do aluno: <b>".ceil($freq)."%</b>";
    echo br(2);
    echo "Período: <b>$dataIni</b> a <b>$dataFim</b>";
    //echo br(2);
    //echo "Término: <b>$dataFim</b>";
    echo br(2);
    echo '</div>';
	echo br(1);
	echo anchor('/main/validar_certificado', 'Validar outro certificado');
}else{
	echo br(1);
    echo '<h4>Validação de certificado</h4>';
    
    if (isset($cod_invalido)) {
        echo "<h5 style='color:red'>$cod_invalido</h5>";
    }

    echo form_open('Validar');
        echo 'Código de validação: ';
        echo form_input(array(
            'name'=>'cod_validacao',
            'required'=>'required',
            'autofocus'=>'autofocus'));
        echo br(2);
        echo form_submit('','Consultar');
        echo form_close();
}