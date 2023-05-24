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

echo "<div id='borda'>";

if ($listaAlunos == false) {
    echo "<h4>" . $dadosCurso['nomeCurso'] . "<br/><br/>Edital: " . $dadosCurso['edital'] . " (" . $dadosCurso['dataIni'] . " - " . $dadosCurso['dataFim'] . ")</h4><br/>";
    echo "<h4>NÃO HÁ PARTICIPANTES NO EVENTO</h4>";
    echo anchor("Admin/inserir_alunos_novo_curso/$dadosCurso[id_curso]", 'Inserir participantes');
    echo br(1);
} elseif (!$last_notif) {
    echo "<strong>MSG notificações enviadas a corrigir.</strong>"; //nunca foram enviadas notificações
} else {
    echo "Última notificação em: "; //. $last_notif->last_sent . " por " . $last_notif->last_sent_by;
}

if ($listaAlunos) {
    echo br(2);
    echo anchor("Admin/notificar_now/$dadosCurso[id_curso]", '<button>NOTIFICAR TODOS OS PARTICIPANTES</button>', array('style' => 'color:red;font-size: 120%'));
    echo "<br/></strong>";
    echo br(1);
    echo form_label($dadosCurso['nomeCurso']);
    echo "<h5>Edital: " . $dadosCurso['edital'] . "<br/> (" . $dadosCurso['dataIni'] . " - " . $dadosCurso['dataFim'] . ")</h5>";
    echo br(1);
    $i = 1;
    $template = array(
        'table_open' => '<table border="1" cellpadding="10" >',
    );
    $this->table->set_template($template);
    $this->table->set_heading('', 'Nome', 'E-mail', 'Conceito', 'Aprovado', 'Enviado', 'Ver Certificado'/* ,"Enviar e-mail<br/><input type='checkbox' name='ckb[]' onclick='marcarTodos(this.checked);' checked />" */);

    foreach ($listaAlunos as $row) {
        if (strtolower($row['aprovado']) == 'n') {
            $this->table->add_row($i, $row['nome']/*anchor("Admin/editar_aluno/$dadosCurso[id_curso]/$row[id_aluno]", $row['nome'])*/, $row['email'], $row['conceito'], "<span style='color:red'>" . img(array('src' => "images/icons/no.png", 'height' => '25', 'width' => '25')) . "</span>", '-', '-');
        } else {//aprovado
            if (!is_array($dados_notificacao)) {
                $dados_notificacao = array();
            }

            if (in_array($row['id_aluno'], $dados_notificacao) == TRUE) {
                $img = img(array('src' => "images/icons/email_enviado.png", 'height' => '25', 'width' => '25'));
            } else {
                $img = img(array('src' => "images/icons/no.png", 'height' => '25', 'width' => '25'));
            }
            $this->table->add_row($i, $row['nome']/*anchor("Admin/editar_aluno/$dadosCurso[id_curso]/$row[id_aluno]", $row['nome'])*/, $row['email'], $row['conceito'], img(array('src' => "images/icons/ok.png", 'height' => '25', 'width' => '25')), $img, anchor("GerarPdf/gerarFPdf/$row[id_aluno]/$dadosCurso[id_curso]/$row[id_alunocurso]/$row[cod_validacao]", img(array('src' => "images/icons/preview_icon.png", 'height' => '25', 'width' => '25')), ['target' => '_blank']));
        }
        $i++;
    }
    echo $this->table->generate();
    echo "<br><br>";
    echo "</div>"; //borda    
}

echo "<br>";
echo anchor('Admin', 'Listar eventos');
