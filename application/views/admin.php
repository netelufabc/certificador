<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//logado
if (isset($_SESSION['status']) &&  $_SESSION['status'] > 0) {
    
    //listar alunos de um curso
    if ($_SESSION['admin_view']=='alunos' && (isset($_SESSION['listaAlunos']) &&($_SESSION['listaAlunos'] != NULL && $_SESSION['listaAlunos'] != FALSE))) {
        $this->load->view('listaAlunosDoCurso');
    
    } elseif ($_SESSION['admin_view']=='form') {//form gerar certificado de novo curso
        $this->load->view('formCertificadoNovoCurso');
    } else {


        if ($_SESSION['admin_view']=='principal' || isset($_SESSION['listaCursos'])) {
            $listaCursos = $_SESSION['listaCursos'];
        }

        //echo br(1);
        echo form_label('<h4>Cursos</h4>');
        echo br(1);

        if ($listaCursos != NULL && $listaCursos != '') {

            $template = array(
                'table_open' => '<table border="1" cellpadding="10" >',
            );
            $this->table->set_template($template);
            $this->table->set_heading('CURSO', 'EDITAL', 'INÍCIO', 'TÉRMINO', 'LISTAR', 'EXCLUIR CURSO');
            foreach ($listaCursos as $row) {

                $this->table->add_row($row['nomeCurso'], $row['edital'], $row['dataIni'], $row['dataFim'], anchor("Admin/listarAlunosDoCurso/$row[id_curso]", 'Inscritos'), anchor("Admin/excluirCurso/$row[id_curso]", 'Excluir')
                );
            }
            echo $this->table->generate();
        } else {
            echo '<h5>NENHUM CERTIFICADO REGISTRADO</h5>';
        }


        echo br(2);
        echo anchor('Admin/gerarCertificadoNovoCurso', 'GERAR CERTIFICADO DE NOVO CURSO');
        //echo br(2);
        //echo anchor('Main', 'PÁGINA INICIAL');
    }
} else {
    //não logado
    $this->load->view('login');
}



//elseif (isset($_SESSION['listaAlunos'])) {
//    $this->load->view('listaAlunosDoCurso');
//}



//if ($_SESSION['status'] != 1) {
//
////    $this->load->view('admin');
//    $this->load->view('login');
////    redirect('Admin/login');
//} else{
////    redirect('Admin');
////    echo br(1);
//    
////    if (isset($_SESSION['listaAlunos'])) {
////        $this->load->view('listaAlunosDoCurso');
////    } 
//    
//    echo br(2);
//    echo form_label('CURSOS');
//    echo br(1);
//
//    
//
//        if (isset($_SESSION['listaCursos'])) {
//            $listaCursos = $_SESSION['listaCursos'];
//        }
//
//        if ($listaCursos != NULL && $listaCursos != '') {
//
//            $template = array(
//                'table_open' => '<table border="1" cellpadding="10" >',
//            );
//            $this->table->set_template($template);
//            $this->table->set_heading('CURSO', 'EDITAL', 'INÍCIO', 'TÉRMINO', 'LISTAR', 'EXCLUIR CURSO');
//            foreach ($listaCursos as $row) {
//
//                $this->table->add_row($row['nomeCurso'], $row['edital'], $row['dataIni'], $row['dataFim'], anchor("Admin/listarAlunosDoCurso/$row[id_curso]", 'Inscritos'), anchor("Admin/excluirCurso/$row[id_curso]", 'Excluir')
//                );
//            }
//            echo $this->table->generate();
//        } else {
//            echo '<h5>NENHUM CERTIFICADO REGISTRADO</h5>';
//        }
//    
//    
//    echo br(2);
//    echo anchor('Admin/gerarCertificadoNovoCurso', 'GERAR CERTIFICADO DE NOVO CURSO');
//    echo br(2);
//    echo anchor('Main', 'PÁGINA INICIAL');
////    
//}

//    echo phpinfo();
//echo $this->session->userdata('login');
