<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!isset($_SESSION['status']) || $_SESSION['status'] != 1) {
    redirect('Admin');
}

if ($this->session->flashdata('notificacao_ok')) {
    echo "<div class=\"message_success\">";
    echo $this->session->flashdata('notificacao_ok');
    echo "</div>";
}

if (isset($listaCursos)) {
    echo "<br>";
    echo "<div id='borda'>";
    echo "<h4><b>Selecione o curso para notificar os participantes</b></h4>";
    echo br(1);

    $this->table->set_template(array("table_open" => "<table class='tabela'>"));
    $this->table->set_heading('', 'ENVIADO', 'CURSO (clique para selecionar)', 'EDITAL', 'INÍCIO', 'TÉRMINO', 'LISTAR'); //, 'EXCLUIR CURSO');

    $i = count($listaCursos);
    foreach ($listaCursos as $row) {
        foreach ($enviados_all as $sent) {
            if ($row['id_curso'] == $sent['id_curso']) {
                $this->table->add_row($i, img(array('src' => "images/ok.png", 'height' => '25', 'width' => '25')), anchor("Admin/notificar_participantes/$row[id_curso]", $row['nomeCurso']), $row['edital'], $row['dataIni'], $row['dataFim'], anchor("Admin/listarAlunosDoCurso/$row[id_curso]", 'Inscritos')); //, anchor("Admin/excluirCurso/$row[id_curso]", 'Excluir'));
                $flag = TRUE;
                break;
            } else {
                $flag = FALSE;
            }
        }
        if (!$flag) {
            $this->table->add_row($i, '', anchor("Admin/notificar_participantes/$row[id_curso]", $row['nomeCurso']), $row['edital'], $row['dataIni'], $row['dataFim'], anchor("Admin/listarAlunosDoCurso/$row[id_curso]", 'Inscritos'));
        }
        $i--;
    }

    echo $this->table->generate();
} else {
    echo "<div id='borda'>";

    echo "<br>";

    if ($listaAlunos == false) {
        echo "<h4>NÃO HÁ ALUNOS CADASTRADOS NO CURSO </h4>";
    } elseif (!$last_notif) {
        echo "<strong>Nunca foram enviadas notificações a todos participantes.</strong>";
    } else {
        echo "Última notificação em: " . $last_notif->last_sent . " por " . $last_notif->last_sent_by;
    }
    echo "<br><br>";

    if ($listaAlunos) {
        echo anchor("Admin/notificar_now/$dadosCurso[id_curso]", 'NOTIFICAR PARTICIPANTES', array('style' => 'color:red;font-size: 150%'));
        echo "</strong>";

        echo "<h4><b>Os seguintes alunos serão notificados:</b></h4>";
        echo "<h4>" . $dadosCurso['nomeCurso'] . "<br>Edital: " . $dadosCurso['edital'] . " (" . $dadosCurso['dataIni'] . " - " . $dadosCurso['dataFim'] . ")</h4>";
        echo br(1);
        $i = 1;
        $template = array(
            'table_open' => '<table border="1" cellpadding="10" >',
        );
        $this->table->set_template($template);
        $this->table->set_heading('', 'Nome (clique para editar)', 'E-mail', 'Conceito', 'Status', 'Ver Certificado'/* ,"Enviar e-mail<br/><input type='checkbox' name='ckb[]' onclick='marcarTodos(this.checked);' checked />" */);

        foreach ($listaAlunos as $row) {
            if ($row['status'] == 'reprovado') {
                $this->table->add_row($i, anchor("Admin/editar_aluno/$dadosCurso[id_curso]/$row[id_aluno]", $row['nome']), $row['email'], $row['conceito'], "<span style='color:red'>" . $row['status'] . "</span>");
            } else {
                $this->table->add_row($i, anchor("Admin/editar_aluno/$dadosCurso[id_curso]/$row[id_aluno]", $row['nome']), $row['email'], $row['conceito'], $row['status'], anchor("GerarPdf/gerarFPdf/$row[id_aluno]/$dadosCurso[id_curso]/$row[id_alunocurso]/$row[cod_validacao]", 'Ver Certificado', ['target' => '_blank']));
            }
            $i++;
        }
        echo $this->table->generate();
        echo "<br><br>";
        echo "</div>"; //borda    
    }
//    echo "<h4>NÃO HÁ ALUNOS CADASTRADOS NO CURSO </h4>";
    echo "<br>";
    echo anchor('Admin/notificar_participantes', 'Cancelar');
}