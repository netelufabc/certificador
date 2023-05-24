<?php

defined('BASEPATH') OR exit('No direct script access allowed');

echo br(1);
echo "<div id='borda'>";
echo br(1);
echo "<h4><b>Notificar o Aluno: $dados_aluno->nome</b></h4>";
echo br(1);

if ($dados_notificacao) {
    echo "<h4><b>Última notifficação em: $dados_notificacao->last_sent por: $dados_notificacao->last_sent_by</b></h4>";
} else {
    echo "<h4><b>Aluno nunca foi notificado individualmente</b></h4>";
}
echo form_open("Admin/notificar_um_aluno/$id_curso/$id_aluno/$dados_aluno->id_alunocurso/$dados_aluno->cod_validacao/".urlencode($dados_aluno->email));

echo br(1);

echo form_submit(array('name' => 'notificar_um_aluno'), 'Notificar Aluno');

echo form_close();
echo br(1);
echo "</div>";

echo br(1);
echo anchor("Admin/listarAlunosDoCurso/$id_curso", 'Retornar à lista de alunos do curso');