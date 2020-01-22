<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if ($_SESSION['status'] == 1) {

    if ($this->session->flashdata('alterar_aluno_ok')) {
        echo "<div class=\"message_success\">";
        echo $this->session->flashdata('alterar_aluno_ok');
        echo "</div>";
    }
    
    if ($this->session->flashdata('enviada_notificacao_ok')) {
        echo "<div class=\"message_success\">";
        echo $this->session->flashdata('enviada_notificacao_ok');
        echo "</div>";
    }

    if (!isset($listaAlunos)) {
        echo "<h3>" . $curso['nomeCurso'] . "</h3>";
        echo "$curso[dataIni] / $curso[dataFim]";
        echo br(2);
        echo "<h4>NÃO HÁ ALUNOS CADASTRADOS NO CURSO </h4>";
    } else {
        echo form_label($listaAlunos[0]['nomeCurso'] . ' - ' . $listaAlunos[0]['edital']);
        echo br(1);
        echo form_label($listaAlunos[0]['dataIni'] . ' a ' . $listaAlunos[0]['dataFim']);
        echo br(2);

        $i = 1;
        $template = array(
            'table_open' => '<table border="1" cellpadding="10" >',
        );
        $this->table->set_template($template);
        $this->table->set_heading('', 'Nome (clique para editar)', 'E-mail', 'Conceito', 'Status', 'Ações'/* ,"Enviar e-mail<br/><input type='checkbox' name='ckb[]' onclick='marcarTodos(this.checked);' checked />" */);

        foreach ($listaAlunos as $row) {
            if ($row['status'] == 'reprovado' || $row['status'] == 'Reprovado') {
                $this->table->add_row($i, anchor("Admin/editar_aluno/$id_curso/$row[id_aluno]", $row['nome']), $row['email'], $row['conceito'], img(array('src' => "images/no.png", 'height' => '25', 'width' => '25')));
            } else {
                $this->table->add_row($i, anchor("Admin/editar_aluno/$id_curso/$row[id_aluno]", $row['nome']), $row['email'], $row['conceito'], img(array('src' => "images/ok.png", 'height' => '25', 'width' => '25')), anchor("GerarPdf/gerarFPdf/$row[id_aluno]/$id_curso/$row[id_alunocurso]/$row[cod_validacao]", img(array('src' => 'images/preview_icon.png', 'border' => '0', 'alt' => "Visualizar Certificado", 'title' => 'Visualizar o certificado', 'target' => '_blank', 'height' => '25'))) . anchor("Admin/notificar_um_aluno/$row[id_curso]/$row[id_aluno]", img(array('src' => 'images/mail_icon.png', 'border' => '0', 'alt' => "Notificar Usuário", 'title' => 'Enviar certifiado para o e-mail do aluno', 'target' => '_blank', 'height' => '25'))));
                }
            $i++;
        }
        echo $this->table->generate();
    }

    echo br(1);
    echo anchor('Admin', 'LISTA DE CURSOS');
} else {
    redirect('Admin');
}