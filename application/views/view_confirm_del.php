<?php

if (isset($participante)) {//deleta inscrição de participante no curso
    echo form_open('Alunos/excluirAlunoDoCurso/' . $id_alunocurso . '/' . $participante['id_aluno'].'/' . $curso['id_curso'], array('class' => 'basic-grey'));
    echo '<h4>' . $participante['nome'] . '</h4>';
    echo $participante['email'];
    echo br(2);
    echo '<h5>' . $curso['nomeCurso'] . '</h5>';
    echo 'Edital: ' . $curso['edital'];
    echo br(1);
    echo "$curso[dataIni] a $curso[dataFim]";
    echo br(2);
    echo form_label('Deseja cancelar a inscrição do participante neste evento?');
    echo br(1);

    $img_del_evento = img(array('src' => 'images/icons/deletar.png', 'border' => '0', 'alt' => "Deletar evento", 'title' => 'Deletar evento', 'height' => '18', 'width' => '18'));
    echo br(1);
    echo '<a><button type="submit">' . 'CANCELAR INSCRIÇÃO ' . $img_del_evento . '</button></a>';
    echo form_close();

    echo br(1);
    echo '<a href="javascript:window.history.go(-1);"><button>MANTER PARTICIPANTE</button></a>';

    
} else {//deletar curso

    echo form_open('Admin/deletar_evento/' . $curso['id_curso'], array('class' => 'basic-grey'));
    echo '<h4>' . $curso['nomeCurso'] . '</h4>';
    echo 'Edital: ' . $curso['edital'];
    echo br(1);
    echo "$curso[dataIni] a $curso[dataFim]";
    echo br(2);
    echo form_label('<span style="color: red;">Deseja deletar o evento definitivamente?</span>');
    echo br(1);
    echo 'Os participantes não conseguirão gerar o certificado deste evento';

    $img_del_evento = img(array('src' => 'images/icons/deletar.png', 'border' => '0', 'alt' => "Deletar evento", 'title' => 'Deletar evento', 'height' => '18', 'width' => '18'));
    echo br(2);
    echo '<a><button type="submit">' . 'DELETAR EVENTO ' . $img_del_evento . '</button></a>';
    echo form_close();

    echo br(1);
    echo anchor('Admin', '<button>CANCELAR</button>');
}