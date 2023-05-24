<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->helper('custom');
//if (isset($error)):
//    echo "<span style='color:red'>" . $error . "</span>";
//endif;
//if ($this->session->flashdata('success') == TRUE):
//    echo $this->session->flashdata('success');
//endif;
//
//if ($this->session->flashdata('no_file_selected')) {
//    echo "<div class=\"message_error\">";
//    echo $this->session->flashdata('no_file_selected');
//    echo "</div><br>";
//}

if ($_SESSION['status'] > 0) {

//    if (isset($mail)/* &&$mail != NULL || $mail != '' */) {
//        foreach ($mail as $valor) {
//            echo $valor['nome'];
//            echo br(2);
//        }
//    }

    echo form_open_multipart('Admin/cadastrarNovoCurso');
    echo validation_errors('<h5 style="color:red">', '</h5>');

    //echo br(1);
    echo "<div id='borda'>";
    echo "<h4><b>Cadastro de novo Curso</b></h4>";
    echo br(1);
    echo "<div id='col_left'>";
    echo form_label('Nome do curso: ');
    echo br(2);
    echo form_label('Edital: ');
    echo br(2);
    echo form_label('Data do início: ');
    echo br(2);
    echo form_label('Data do término: ');
    echo br(2);
    echo form_label('Carga horária: ');
    echo br(2);
    echo form_label('Modelo do certificado: ');
    echo br(2);
    echo form_label('Nível do módulo: ');
    echo br(2);

    echo "</div>"; //coluna esquerda

    echo "<div id='col_right'>";
    echo form_input(array('name' => 'nomeCurso', 'required' => 'required'), '', 'autofocus');
    echo br(2);
    echo form_input(array('name' => 'edital', 'required' => 'required'), '', "placeholder='ex: NTME 01/2018'");
    echo br(2);
    echo "<input type=\"date\" name=\"dataInicio\" min=\"2016-01-01\" max=\"2021-12-31\"  required>";
    echo br(2);
    echo "<input type=\"date\" name=\"dataFim\" min=\"2016-01-01\" max=\"2021-12-31\" required>";
    echo br(2);
    echo form_input(array('name' => 'cargaHoraria', 'size' => '3', 'required' => 'required'));
    echo form_label(' horas');
    echo br(2);
    
    $mod_certificado = array("" => 'Selecione o modelo do certificado');
    foreach ($modelos_certificados as $value) {
        $mod_certificado[$value['id_certificado']]= $value['nome_certificado'];
    }
    echo form_dropdown('mod_certificado', $mod_certificado, '', 'required');
    
    echo br(2);
    
    //echo form_input(array('name' => 'nivel', 'size' => '2', 'maxlength'=>'2'));
    $data = array(
        'name'          => 'nivel',
        'id'            => 'nivel',
    );
    
    
    $indice = array( NULL => 'selecione somente para cursos de línguas');
    $options = NiveisLinguas();
    foreach ($options as $key => $value) {
        //array_push($indice,$indice[$key]=$key);
        switch ($key) {
            default:
                array_push($indice,$indice[$key]=$key);//INICAINTE
                break;
            case "A1":
                array_push($indice,$indice[$key]=$key . " - Elementar I - II");
                break;
            case "A2":
                array_push($indice,$indice[$key]=$key . " - Pré-intermediário I - III");
                break;
            case "B1":
                array_push($indice,$indice[$key]=$key . " - Intermediário I - III");
                break;
            case "B2":
                array_push($indice,$indice[$key]=$key . " - Pós-intermediário I - III");
                break;
            case "C1":
                array_push($indice,$indice[$key]=$key . " - Avançado I - VII");
                break;
            case "C2":
                array_push($indice,$indice[$key]=$key . " - Avançado superior I - VII");
                break;
        }
        $indice2 = array_unique($indice);//elimina valores duplicados criados com a função array_push acima
    }
    
    echo form_dropdown($data,$indice2);
    echo br(2);
    echo "</div>"; //coluna direita

//    if ($certificados != FALSE) {
//        foreach ($certificados as $row) {
//            $mod_certificado = array(//precisa fazer dinâmico carregando a partir do bd
//            $row['id_certificado'] => $row['nome_certificado'],
//                );
//        }
//    }
//    $mod_certificado = array(//precisa fazer dinâmico carregando a partir do bd
//        '' => 'Selecione o modelo do certificado',
//        '1' => 'NTE - Padrão',
//        '2' => 'REA'
//    );
//    echo form_dropdown('mod_certificado', $mod_certificado, '', 'required');
//    echo br(2);

//    echo form_label('Selecione o arquivo CSV com os nomes e e-mails dos participantes: ');
//    echo "<br/><a href='../templates/1_MODELO_CSV.csv'>(Modelo CSV)</a>";
//    echo form_input(array('name' => 'csvfile', 'type' => 'file'));
//    echo br(2);
    echo form_submit(array('name' => 'cadastrar_curso'), 'Inserir Curso');
    echo form_close();
    echo br(2);
    echo "</div>"; //borda    
//    if ($erro_email != NULL) {
//        foreach ($email as $mail) {
//            echo $mail;
//        }
//    }
    echo anchor('Admin', 'LISTA DE CURSOS');
} else {
    redirect('Admin');
}