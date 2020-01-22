<!--<link rel="stylesheet" type="text/css" href="../css/style.css">-->
<!--<link rel="stylesheet" href="./css/bootstrap.min.css">-->
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//logado
//if (isset($_SESSION['status']) && $_SESSION['status'] == 1) {
//    echo br(1);
//    $nomeLogado = $_SESSION['nome'];
//    echo "Logado: ".$nomeLogado;
//    echo " (";
//    echo anchor('Admin/logout', 'Logout');
//    echo ")";
//    echo br(1);
    //listar alunos de um curso
//    if ($_SESSION['admin_view'] == 'alunos' && (isset($_SESSION['listaAlunos']) && ($_SESSION['listaAlunos'] != NULL && $_SESSION['listaAlunos'] != FALSE))) {
//        $this->load->view('listaAlunosDoCurso');
//    }
//    elseif ($_SESSION['admin_view'] == 'erro') {//lista de e-mails com erro
//        $this->load->view('listaEmailErrorCsv', $listaEmailError);//ufabc-famt: lista de email errado
//    }
//    elseif ($_SESSION['admin_view'] == 'form') {//form gerar certificado de novo curso
//        $this->load->view('formCertificadoNovoCurso'/*,$certificados*/);
//    } elseif ($_SESSION['admin_view'] == 'edit_curso') {//carrega view para editar dados do curso (GUC)
////        $ch = $dados_do_curso->cargaHoraria;
//        $this->load->view('view_edit_curso');
        
        
   // } else {
     
//        if ($_SESSION['admin_view'] == 'principal' || isset($_SESSION['listaCursos'])) {
//            $listaCursos = $_SESSION['listaCursos'];
//        }
//
//        if ($this->session->flashdata('alterar_curso_ok')) { //mostrar msg de alterado curso com sucesso
//            echo "<div class=\"message_success\">";
//            echo $this->session->flashdata('alterar_curso_ok');
//            echo "</div>";
//         }
//        echo form_label('<h4>Cursos</h4>');
//        echo br(1);
//
//        if ($listaCursos != NULL && $listaCursos != '') {
//
//            $template = array(
//                "table_open" => "<table class='tabela'>",
//            );
//            $this->table->set_template($template);
//            $this->table->set_heading('CURSO', 'EDITAL', 'INÍCIO', 'TÉRMINO', 'LISTAR', 'EDITAR' , 'EXCLUIR CURSO');
//            foreach ($listaCursos as $row) {
//
//                $this->table->add_row($row['nomeCurso'], $row['edital'], $row['dataIni'], $row['dataFim'], anchor("Admin/listarAlunosDoCurso/$row[id_curso]", 'Inscritos'), anchor("Admin/editar_curso/$row[id_curso]", 'Editar') , anchor("Admin/excluirCurso/$row[id_curso]", 'Excluir'));
//            }
//            echo $this->table->generate();
//        } else {
//            echo '<h5>NENHUM CERTIFICADO REGISTRADO</h5>';
//        }
//
//        echo br(2);
//        echo anchor('Admin/gerarCertificadoNovoCurso', 'GERAR CERTIFICADO DE NOVO CURSO');
 //   }
//} else {
//    //não logado
//    echo br(1);
//    $this->load->view('login');
//}