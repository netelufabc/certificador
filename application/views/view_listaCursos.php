<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//if (!isset($_SESSION['status']) || $_SESSION['status'] != 1) {
//    redirect('Login');
//}

if ($this->session->flashdata('notificacao_ok')) {
    echo "<div class=\"message_success\">";
    echo $this->session->flashdata('notificacao_ok');
    echo "</div>";
}
if ($this->session->flashdata('alterar_curso_ok')) { //mostrar msg de alterado curso com sucesso
    echo "<div class=\"message_success\">";
    echo $this->session->flashdata('alterar_curso_ok');
    echo "</div>";
}

if ($this->session->flashdata('novo_curso_ok')) { //mostrar msg de alterado curso com sucesso
    echo "<div class=\"message_success\">";
    echo $this->session->flashdata('novo_curso_ok');
    echo "</div>";
}

if ($this->session->flashdata('inserir_alunos_ok')) { 
    echo "<div class=\"message_success\">";
    echo $this->session->flashdata('inserir_alunos_ok');
    echo "</div>";
}

if ($this->session->flashdata('senha_atualizada')) { 
    echo "<div class=\"message_success\">";
    echo $this->session->flashdata('senha_atualizada');
    echo "</div>";
}


if (isset($listaCursos)) {
    
//    if (isset($_SESSION['status']) && $_SESSION['status'] == 1) {
//        echo form_label('<h3><b>' . mb_strtoupper($lista[0]['nome']) . '</b></h3>');//anchor("Admin/editar_aluno/$id_curso/$row[id_aluno]", $row['nome'])
//    } else {
//    echo form_label('<h3><b>' . mb_strtoupper($lista[0]['nome']) . '</b></h3>');
//    }
//    echo br(1);
//    if (isset($msg)) {
//        echo "<h5 style='color: #0000FF'>" . $msg . "</h5>";
//    }
    
    
//    echo "<br>";
    echo "<div id='borda'>";
    //echo "<h4><b>Selecione o evento para notificar os participantes</b></h4>";
    echo br(1);

    $this->table->set_template(array("table_open" => "<table class='tabela'>"));
    $this->table->set_heading('', 'EVENTO', 'EDITAL', 'INÍCIO', 'TÉRMINO', 'ENVIADOS', 'FUNCIONALIDADES'); //, 'EXCLUIR CURSO');

    $qtd_cursos = count($listaCursos);

    foreach ($listaCursos as $curso) {

        //imagens dos links das ações
        $img_del_evento = img(array('src' => 'images/icons/deletar.png', 'border' => '0', 'alt' => "Deletar evento", 'title' => 'Deletar evento',  'height' => '18', 'width' => '18'));
        $img_editar = img(array('src' => 'images/icons/edit.png', 'border' => '0', 'alt' => "Editar evento", 'title' => 'Editar evento', 'width' => '20', 'height' => '20'));
        $img_notificar = img(array('src' => 'images/icons/notificar.png', 'border' => '0', 'alt' => "Notificar participantes", 'title' => 'Notificar participantes', 'width' => '20', 'height' => '20'));
        $img_inserir = img(array('src' => 'images/icons/inserir.png', 'border' => '0', 'alt' => "Inserir participantes", 'title' => 'Inserir participantes', 'height' => '20'));
        $img_inscritos = img(array('src' => 'images/icons/inscritos.png', 'border' => '0', 'alt' => "Visualizar participantes", 'title' => 'Visualizar participantes', 'height' => '20'));
        
        //links das ações
        $esp = nbs(2);
        $link_img_del_evento = anchor("Admin/confirm_del/$curso[id_curso]", $img_del_evento);
        $link_img_editar = $esp.anchor("Admin/editar_curso/$curso[id_curso]", $img_editar);
        $link_img_notificar = $esp.anchor("Admin/listarAlunosDoCurso/$curso[id_curso]", $img_notificar);
        $link_img_inserir = $esp.anchor("Admin/inserir_alunos_novo_curso/$curso[id_curso]", $img_inserir);
        $link_img_inscritos = $esp.anchor("Admin/listarAlunosDoCurso/$curso[id_curso]", $img_inscritos);

        $flag = FALSE;
        $nobody = TRUE;
        if (!empty($qtd_aluno_por_curso)) {
            foreach ($qtd_aluno_por_curso as $ac) {
                if ($curso['id_curso'] == $ac['id_curso']) {
                    $nobody = FALSE;
                    if (!empty($enviados)) {
                        foreach ($enviados as $env) {
                            if ($curso['id_curso'] == $env['id_curso']) {
                                if ($env['qtd_alunos'] < $ac['qtd_alunos']) {
                                    $qtds = '<span style="color:red"><b>' . $env['qtd_alunos'] . '/' . $ac['qtd_alunos'] . '</b></span>';
                                } else {
                                    $qtds = '<span style="color:blue"><b>' . $env['qtd_alunos'] . '/' . $ac['qtd_alunos'] . '</b></span>';
                                }
                                $this->table->add_row($qtd_cursos, $curso['nomeCurso'], $curso['edital'], $curso['dataIni'], $curso['dataFim'],$qtds, $link_img_del_evento. $link_img_editar . $link_img_notificar . $link_img_inserir . $link_img_inscritos); //, anchor("Admin/excluirCurso/$row[id_curso]", 'Excluir'));
                                $flag = TRUE;
                                break;
                            }
                        }
                    }
                } //se tem isncritos no curso
            }//foreach inscritos
            //sem participantes cadastrados
            if ($nobody) {
                $this->table->add_row($qtd_cursos, $curso['nomeCurso'], $curso['edital'], $curso['dataIni'], $curso['dataFim'], '<span style="color:gray"><b>0/0</b></span>', $link_img_del_evento. $link_img_editar . $link_img_notificar . $link_img_inserir . $link_img_inscritos);
            }
        }//if inscritos
        //exibir curso que não teve envios
        if (!$flag) {
            foreach ($qtd_aluno_por_curso as $ac) {
                if ($curso['id_curso'] == $ac['id_curso'])
                    $this->table->add_row($qtd_cursos, $curso['nomeCurso'], $curso['edital'], $curso['dataIni'], $curso['dataFim'], '<span style="color:red"><b>0/' . $ac['qtd_alunos'] . '</span>', $link_img_del_evento. $link_img_editar . $link_img_notificar . $link_img_inserir . $link_img_inscritos);
            }
        }
        $qtd_cursos--;
    }

    echo $this->table->generate();
} else {
    echo '<h5>NENHUM CERTIFICADO REGISTRADO</h5>';
}