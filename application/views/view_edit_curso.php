<!-- view para edição de cursos (GUC) -->
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (isset($error)):
    echo $error;
endif;
if ($this->session->flashdata('success') == TRUE):
    echo $this->session->flashdata('success');
endif;

if ($_SESSION['status'] > 0) {

//    if (isset($mail)/* $mail != NULL || $mail != ''*/) {
//        foreach ($mail as $valor) {
//            echo $valor['nome'];
//            echo br(2);
//        }
//    }

    echo form_open("Admin/editar_curso/$curso_id");
    echo validation_errors('<h5 style="color:red">', '</h5>');

    echo br(1);
    echo "<div id='borda'>";
    echo "<h4><b>Edição de dados do evento</b></h4>";
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
    echo form_label('Atividade presencial (%)');
    echo br(2);
    echo form_label('Atividade remota (%)');
    echo br(2);
    echo form_label('Modelo do certificado');
    echo br(2);
    echo form_label('Nível do módulo');
    
    echo "</div>"; //coluna esquerda

    echo "<div id='col_right'>";
    echo form_input(array('name' => 'nomeCurso', 'required' => 'required', 'maxlength'=>'255', 'placeholder'=>'máx. 255 caracteres'), htmlspecialchars_decode(set_value('nomeCurso', $dados_do_curso['nomeCurso'])), '', 'autofocus');
    echo br(2);
    echo form_input(array('name' => 'edital', 'required' => 'required'), set_value('edital', $dados_do_curso['edital']));
    echo br(2);
    echo "<input type=\"date\" name=\"dataInicio\" min=\"2016-01-01\" max=\"2025-12-31\" value=\"" . date("Y-m-d", strtotime(str_replace('/', '-', $dados_do_curso['dataIni']))) . "\">";
    echo br(2);
    echo "<input type=\"date\" name=\"dataFim\" min=\"2016-01-01\" max=\"2025-12-31\" value=\"" . date("Y-m-d", strtotime(str_replace('/', '-', $dados_do_curso['dataFim']))) . "\">";
    echo br(2);
    echo form_input(array('name' => 'cargaHoraria', 'size' => '2', /*'required' => 'required'*/), set_value('cargaHoraria', $dados_do_curso['cargaHoraria']));
    echo form_label(' horas');
    echo br(2);
    echo form_input(array('name' => 'ativ_presencial', 'size'=>'2'), set_value('ativ_presencial', $dados_do_curso['ativ_presencial']));
    echo br(2);
    echo form_input(array('name' => 'ativ_remota', 'size'=>'2'), set_value('ativ_remota', $dados_do_curso['ativ_remota']));
    echo '<font size=1px >Obs: verificar total 100%</font>';
    echo br(2);

    $mod_certificado = array("" => 'Selecione o modelo do certificado');
    foreach ($modelos_certificados as $value) {
        $mod_certificado[$value['id_certificado']] = $value['nome_certificado'];
    }
    
    echo form_dropdown('mod_certificado', $mod_certificado, set_value('mod_certificado', $dados_do_curso['id_certificado']));
    echo br(2);
    
    foreach ($niveis as $row) {
        $n[$row['nivel']] = $row['desc_nivel'];
    }
    echo form_dropdown('nivel', $n,set_value('nivel', $dados_do_curso['nivel']));
    echo br(3);

    echo form_submit(array('name' => 'botao_alterar'), 'Alterar Dados do Evento');
    echo form_close();

    echo "</div>"; //coluna direita

    echo br(24);

    echo "</div>"; //div borda
    echo br(1);
    echo anchor('Admin', 'Lista de Eventos');
} else {
    redirect('Admin');
}