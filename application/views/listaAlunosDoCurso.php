<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if ($_SESSION['status'] > 0) {

    if ($this->session->flashdata('notificacao_ok')) {
        echo "<div class=\"message_success\">";
        echo $this->session->flashdata('notificacao_ok');
        echo "</div>";
    }

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

    if ($this->session->flashdata('inserir_alunos_ok')) {
        echo "<div class=\"message_success\">";
        echo $this->session->flashdata('inserir_alunos_ok');
        echo "</div>";
    }

    if (!isset($listaAlunos)) {
        //echo "<h4>" . $curso['nomeCurso'] . "</h4>";
        echo form_label($curso['nomeCurso']);
        echo br(1);
        echo form_label('Edital: ' . $curso['edital']);
        echo br(1);
        echo "$curso[dataIni] / $curso[dataFim]";
        echo br(1);
        echo "<h5><b>NÃO HÁ PARTICIPANTES CADASTRADOS NO CURSO</b></h5>";
        echo anchor("Admin/inserir_alunos_novo_curso/$curso[id_curso]", 'Inserir participantes');
        echo br(1);
    } else {
        echo form_label($listaAlunos[0]['nomeCurso']);
        echo br(1);
        echo form_label('Edital: ' . $listaAlunos[0]['edital']);
        echo br(1);
        echo form_label($listaAlunos[0]['dataIni'] . ' a ' . $listaAlunos[0]['dataFim']);
        echo br(2);
        echo anchor("Admin/notificar_now/$id_curso", 'NOTIFICAR PARTICIPANTES APROVADOS');
        echo br(2);
        echo anchor("Admin/inserir_alunos_novo_curso/$id_curso", 'INSERIR PARTICIPANTES');
        echo br(2);

        $i = 1;
        $template = array(
            'table_open' => '<table border="1" cellpadding="10" >',
        );
        $this->table->set_template($template);
        $this->table->set_heading('', 'Nome', 'E-mail', 'Conceito', 'Aprovado', 'Enviado', 'Funcionalidades');

        foreach ($listaAlunos as $row) {
            if (strtolower($row['aprovado']) == 'n') {//reprovado
                $aprovado = img(array('src' => "images/icons/no.png", 'height' => '25', 'width' => '25'));
                $mail_img = img(array('src' => "images/icons/no_mail.png", 'height' => '25', 'width' => '25','alt' => "Reprovado", 'title' => 'Reprovado'));;
                $link_notif = $mail_img;
                $link_vis = img(array('src' => 'images/icons/no_visible.png', 'border' => '0', 'alt' => "Reprovado", 'title' => 'Reprovado', 'height' => '22'));
            } else {//aprovado
                $aprovado = img(array('src' => "images/icons/ok.png", 'height' => '25', 'width' => '25'));
                $mail_img = img(array('src' => 'images/icons/mail_icon.png', 'border' => '0', 'alt' => "Notificar o participante", 'title' => 'Notificar o participante', 'target' => '_blank', 'height' => '25'));
                $link_notif = anchor("Admin/notificar_um_aluno/$row[id_curso]/$row[id_aluno]/$row[id_alunocurso]/$row[cod_validacao]/" . urlencode($row['email']), $mail_img);
                
                $link_vis = anchor("GerarPdf/gerarFPdf/$row[id_aluno]/$id_curso/$row[id_alunocurso]/$row[cod_validacao]", img(array('src' => 'images/icons/preview_icon.png', 'border' => '0', 'alt' => "Visualizar Certificado", 'title' => 'Visualizar o certificado', 'height' => '25')), array('target' => '_blank'));
            }

            $flag = FALSE;
            if ($dados_notificacao) {
                $flag = in_array($row['id_aluno'], $dados_notificacao);
            }
            if ($flag) {
                $col_enviado = img(array('src' => "images/icons/email_enviado.png", 'height' => '25', 'width' => '25'));
            } else {
                $col_enviado = img(array('src' => "images/icons/no.png", 'height' => '25', 'width' => '25'));
            }

            $esp = nbs(1);
            $link_del = anchor("Admin/confirm_del/$row[id_alunocurso]/$row[id_aluno]/$id_curso/$row[cod_validacao]", img(array('src' => 'images/icons/deletar.png', 'border' => '0', 'alt' => "Cancelar inscrição do partipante neste evento", 'title' => 'Cancelar inscrição do partipante neste evento', 'height' => '22')));
            $link_editar = anchor("Admin/editar_aluno/$row[id_aluno]/$id_curso", img(array('src' => 'images/icons/edit.png', 'border' => '0', 'alt' => 'Editar dados do participante', 'title' => 'Editar dados do participante', 'height' => '25')));
            //$link_vis = anchor("GerarPdf/gerarFPdf/$row[id_aluno]/$id_curso/$row[id_alunocurso]/$row[cod_validacao]", img(array('src' => 'images/icons/preview_icon.png', 'border' => '0', 'alt' => "Visualizar Certificado", 'title' => 'Visualizar o certificado', 'height' => '25')), array('target' => '_blank'));

            $this->table->add_row($i, $row['nome'], $row['email'], $row['conceito'], $aprovado, $col_enviado, $link_del . ' ' . $link_editar . ' ' . $link_notif . ' ' . $link_vis);

            $i++;
        }
        echo $this->table->generate();
    }

    echo br(1);
    echo anchor('Admin', 'Listar eventos');
} else {
    redirect('Admin');
}