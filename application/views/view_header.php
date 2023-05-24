<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>NTE - UFABC</title>
        <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
        <script src="js/bootstrap-datetimepicker.min.js"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- <link rel="stylesheet" href="../css/style.css"> -->
        <link rel="stylesheet" href=/css/style.css>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript">
//            script para abrir a aba específica por link
//https://forum.imasters.com.br/topic/534967-abrir-tab-do-bootstrap-pela-url/
            $('#t a').click(function (e) {
                if ($(this).parent('li').hasClass('active')) {
                    $($(this).attr('href')).hide();
                } else {
                    e.preventDefault();
                    $(this).tab('show');
                }
            });

            var hash = document.location.hash;
            if (hash) {
                $('#t a[href=' + hash + ']').tab('show');
            }
//            script para abrir a aba específica por link

            $(function () {
                $("#datepicker").datepicker();
                dp_exp_prof();
            });

            function setActive() { //função para manter a janela ativa acionada na barra de menu (muda o css da opção ativa)
                aObj = document.getElementById('cssmenu').getElementsByTagName('a');
                for (i = 0; i < aObj.length; i++) {
                    if (document.location.href.indexOf(aObj[i].href) >= 0) {
                        aObj[i].className = 'active';
                    }
                }
            }
            window.onload = setActive;
        </script>
    </head>
    <body>
        <div class="container" align="center"><!--fecha esta div no view_footer -->
            <h3>NÚCLEO EDUCACIONAL DE TECNOLOGIAS E LÍNGUAS</h3>
            <h4>Universidade Federal do ABC</h4>
            <h3>Sistema de Certificados</h3>

            <br/>
<!--            <a href="<?php $_SERVER['SERVER_NAME'] ?>/Main/validar_certificado" class="myButton">Validar Certificado</a>
            <a href="<?php $_SERVER['SERVER_NAME'] ?>/Main/gerar_certificado" class="myButton">Obter Certificado</a>
            <a href="<?php $_SERVER['SERVER_NAME'] ?>/Main/admin" class="myButton">Administrativo</a>
            <a href="<?php $_SERVER['SERVER_NAME'] ?>/Main/admin" class="myButton">Administrativo</a>-->
            
            <?php
            echo anchor('Main/validar_certificado', 'Validar Certificado', array('class' => 'myButton'));
            echo nbs(3);
            echo anchor('Main/gerar_certificado', 'Certificados', array('class' => 'myButton'));
            echo nbs(3);
            echo anchor('Admin', 'Administrador', array('class' => 'myButton'));
            echo "<hr>";
            
            if (isset($_SESSION['status']) && $_SESSION['status'] > 0) {
                $nomeLogado = $_SESSION['nome'];
                echo "Logado: " . $nomeLogado;
                echo "<br>";
                //echo anchor('Admin', 'Listar Eventos') . " | " . anchor('Admin/cadastrarNovoCurso','Novo Evento') . " | ";
				echo anchor('Admin', 'Listar Eventos') . " | " . anchor('Admin/cadastrarNovoCurso','Novo Evento') . " | " . anchor('Login/update_pass','Alterar Senha') . " | ";
                //echo anchor('Admin/gerar_cert_avulso', 'Gerar Certificado Avulso')." | ";
                //echo anchor('Admin/criar_modelo_cert', 'Criar Modelo de Certificado')." | ";
                echo anchor('Admin/logout', 'Logout');
               
                echo "<hr>";
            }
            ?>
