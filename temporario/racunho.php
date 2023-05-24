
<script type="text/javascript">
    function marcarTodos(marcar){
        var itens = document.getElementsByName('cores[]');

        if(marcar){
            document.getElementById('acao').innerHTML = 'Desmarcar Todos';
        }else{
            document.getElementById('acao').innerHTML = 'Marcar Todos';
        }

        var i = 0;
        for(i=0; i<itens.length;i++){
            itens[i].checked = marcar;
        }

    }
</script>
<form>
    <input type="checkbox" name="cores[]" onclick="marcarTodos(this.checked);">
     <span id="acao">Marcar</span> <br>
    <input type="checkbox" name="cores[]" value="azul"> azul <br>
    <input type="checkbox" name="cores[]" value="verde"> verde <br>
    <input type="checkbox" name="cores[]" value="branco"> branco <br>
</form>




<?php

public function gerarPdf1($lista) {
//http://www.mpdfonline.com/repos/mpdfmanual.pdf

        foreach ($lista as $row) {
            $dados_aluno = array(
                'nome' => $row['nome'],
                'conceito' => $row['conceito'],
                'email' => $row['email']
            );

            $mpdf = new mPDF('utf-8', 'A4-L', '80');
            $mpdf->WriteHTML('<p>Nome: ' . $dados_aluno['nome'] . '</p>
                        <p>Conceito: ' . $dados_aluno['conceito'] . '</p>');
            $mpdf->Output('./uploads/' . $dados_aluno['nome'] . '.pdf', 'F');
        }
        return TRUE;
    }

//
//        $enviado = $mail->Send();
//        $mail->ClearAllRecipients();  //Limpa os destinatários e os anexos (DEMORA MUITO)
//        $mail->ClearAttachments();
//        
//
//        if ($enviado) {
//            echo "E-mail enviado com sucesso!";
//        } else {
//            echo "Não foi possível enviar o e-mail.";
//            echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
//
//        }
//    }
    
    
     public function EnviarEmail() {
// Carrega a library email
        $this->load->library('email');
//Recupera os dados do formulário
        $dados = $this->input->post();

//Inicia o processo de configuração para o envio do email
        $config['protocol'] = 'mail'; // define o protocolo utilizado
        $config['wordwrap'] = TRUE; // define se haverá quebra de palavra no texto
        $config['validate'] = TRUE; // define se haverá validação dos endereços de email

        /*
         * Se o usuário escolheu o envio com template, define o 'mailtype' para html, 
         * caso contrário usa text
         */
//        if(isset($dados['template']))
        $config['mailtype'] = 'html';
//        else
        $config['mailtype'] = 'text';

//           $config['protocolo'] ='smtp';
//           $config['smtp_host'] ='ssl://smtp.gmail.com';
//           $config['smtp_user'] ='suporte.tidia@gmail.com';
//           $config['smtp_pass'] = 'ufabc!@#tidia';
//           $config['smtp_port'] = 587;
//           $mail->SMTPOptions = array(
//'ssl' => array(
//    'verify_peer' => false,
//    'verify_peer_name' => false,
//    'allow_self_signed' => true
//));
// Inicializa a library Email, passando os parâmetros de configuração
        $this->email->initialize($config);

// Define remetente e destinatário
        $this->email->from('suporte.tidia@gmail.com', 'Remetente'); // Remetente
        $this->email->to('fabiomoto@yahoo.com.br', 'Fábio'); // Destinatário
// Define o assunto do email
        $this->email->subject('Enviando emails com a library nativa do CodeIgniter');

        /*
         * Se o usuário escolheu o envio com template, passa o conteúdo do template para a mensagem
         * caso contrário passa somente o conteúdo do campo 'mensagem'
         */
        if (isset($dados['template']))
            $this->email->message($this->load->view('email-template', $dados, TRUE));
        else
            $this->email->message('testeando email');

        /*
         * Se foi selecionado o envio de um anexo, insere o arquivo no email 
         * através do método 'attach' da library 'Email'
         */
//        if(isset($dados['anexo']))
//            $this->email->attach('./assets/images/unici/logo.png');

        /*
         * Se o envio foi feito com sucesso, define a mensagem de sucesso
         * caso contrário define a mensagem de erro, e carrega a view home
         */
        if ($this->email->send()) {
//            $this->session->set_flashdata('success','Email enviado com sucesso!');
            $this->load->view('main_admin');
        } else {
//            $this->session->set_flashdata('error',$this->email->print_debugger());
            echo $this->email->print_debugger();
            $this->load->view('main_admin');
        }
    }
    
    
    public function enviar_email($email, $assunto, $corpo/* , $emailarray = array() */) {

//require("/var/www/html/www.simtec.gr.unicamp.br/phpmailer/class.phpmailer.php"); 
//    require("C:/wamp/www/Sintec_V/phpmailer/class.phpmailer.php"); //acertar o caminho para phpmailer
// O BLOCO ABAIXO INICIALIZA O ENVIO
        $mail = new PHPMailer(); // INICIA A CLASSE PHPMAILER
        $mail->IsSMTP(); //ESSA OPÇAO HABILITA O ENVIO DE SMTP
        $mail->Host = "smtp.gmail.com"; //SERVIDOR DE SMTP, USE smtp.SeuDominio.com OU smtp.hostsys.com.br 
        $mail->Port = 465; //gmail 465 ou 587
        $mail->SMTPAuth = true; //ATIVA O SMTP AUTENTICADO
        $mail->SMTPSecure = 'ssl';
        $mail->Username = "suporte.tidia@gmail.com"; //"suporte.tidia@ufabc.edu.br"; //EMAIL PARA SMTP AUTENTICADO (pode ser qualquer conta de email do seu domínio)
        $mail->Password = "ufabc!@#tidia"; //SENHA DO EMAIL PARA SMTP AUTENTICADO
        $mail->From = "suporte.tidia@gmail.com"; //E-MAIL DO REMETENTE 
        $mail->FromName = "COPEX 2015"; //NOME DO REMETENTE
        $mail->AddAddress($email); //E-MAIL DO DESINATÁRIO, NOME DO DESINATÁRIO --> AS VARIÁVEIS ALI PODEM FAZER REFERENCIA A DADOS VINDO DE $_GET OU $_POST, OU AINDA DO BANCO DE DADOS
        $mail->WordWrap = 50; // ATIVAR QUEBRA DE LINHA
        $mail->IsHTML(true); //ATIVA MENSAGEM NO FORMATO HTML
        $mail->Subject = $assunto; //ASSUNTO DA MENSAGEM
        $mail->Body = $corpo;

//    foreach($emailarray as $item)
//    {
        $mail->AddAddress($item);
//    }

        if (!$mail->Send()) {
            echo "<span class='style1'>Mensagem não enviada para: $email </span><br>Erro: " . $mail->ErrorInfo;
//echo "<span class='style1'>Mensagem não enviada para: $email ($id)</span><br>Erro: " . $mail->ErrorInfo; 
            return FALSE;
        }

//    $mail->ClearAllRecipients();  //Limpa os destinatários e os anexos (DEMORA MUITO)
//    $mail->ClearAttachments();
        return TRUE;
    }
    
    
     public function gerarCertificadoNovoCurso() {

        //validação dos campos
        $this->form_validation->set_rules('nomeCurso', 'NOME DO CURSO', 'trim|required|mb_strtoupper');
        $this->form_validation->set_rules('cargaHoraria', 'CARGA HORÁRIA', 'required|is_natural');

        if ($this->form_validation->run() == TRUE) {
            //insere dados do curso no bd
            $id_curso = $this->cadastrarCurso();
            //faz upload da lista de alunos
            $file_path = $this->uploadCsv();

            //acessa o arquivo CSV que foi salvo no server
            $csv_array = $this->csvimport->get_array($file_path);
            if ($csv_array) {

            //verificar se todos os e-mails do csv estão corretos
            $listaErroEmail['listaErroEmail'] = array();
            $line = 2;//indicar a linha do csv
            foreach ($csv_array as $row) {
                if(!$this->validaEmail($row['email'])){
                    $row['line']=$line;
                    array_push($listaErroEmail['listaErroEmail'], $row);
                }        
                $line++;
            }
            foreach ($csv_array as $row) {
                    $aluno = $this->cadastrarAlunoPorCsv($row);

//                    $insert_data = array(
//                        'nome' => mb_strtoupper($row['nome']),
//                        'email' => strtolower($row['email']),
//                        'statusEmail' => $statusEmail
//                    );

                    $cod_validacao = $this->randomPassword();
                    
                    $dadosAlunoCurso = array(
                        'id_aluno'=>$aluno['id_aluno'],
                        'id_curso'=>$id_curso,
                        'conceito'=>strtoupper($row['conceito']),
                        'cod_validacao' => $cod_validacao
                    );
                    
                    $id_alunocurso = $this->cadastrarAlunoCurso($dadosAlunoCurso);

//                        // verifica e-mail único na tabela 'alunos' e insere
//                        $aluno = $this->aluno_model->get_aluno_by_email($insert_data['email']);
//                        if ($aluno == NULL) {
//                            $id_aluno = $this->aluno_model->set_aluno($insert_data);
//                            $id_alunocurso = $this->alunocurso_model->set_alunocurso(array(
//                                'id_aluno' => $id_aluno,
//                                'id_curso' => $id_curso,
//                                'conceito' => strtoupper($row['conceito']),
//                                'cod_validacao' => $cod_validação
//                            ));
//                            //dados que serão enviados como parâmetro para construir link
//                            $dados = array(
//                                'email' => $row['email'],
//                                'id_aluno' => $id_aluno,
//                                'id_curso' => $id_curso,
//                                'id_alunocurso' => $id_alunocurso,
//                                'cod_validacao' => $cod_validação
//                            );
//                        } else {
//                            $id_alunocurso = $this->alunocurso_model->set_alunocurso(array(
//                                'id_aluno' => $aluno['id'],
//                                'id_curso' => $id_curso,
//                                'conceito' => strtoupper($row['conceito']),
//                                'cod_validacao' => $cod_validação
//                            ));
//                            //dados que serão enviados como parâmetro para construir link
//                            $dados = array(
//                                'email' => $row['email'],
//                                'id_aluno' => $aluno['id'],
//                                'id_curso' => $id_curso,
//                                'id_alunocurso' => $id_alunocurso,
//                                'cod_validacao' => $cod_validação
//                            );
//                        }
                    //enviar e-mail com o link personalizado
//                    $this->enviar($dados_form, $dados);
//                    } else {
//                        array_push($emailsInvalidos['mail'], $row);
//                    }
                }
            }
            redirect("Alunos/listarAlunosDoCurso/$id_curso");
        }
        $this->load->view('formCertificadoNovoCurso');
    }
    
    
    //    if (isset($error)):
//        echo $error;
//    endif;
//        if ($this->session->flashdata('success') == TRUE):
//        echo $this->session->flashdata('success');
//    endif;
//    
//    if($mail != NULL || $mail != ''){
//        foreach ($mail as $valor) {
//                echo $valor['nome'];
//                echo br(2);
//        }
//    }
//
//    echo form_open_multipart('GerarCertificado/certificar');
//    echo validation_errors('<h5 style="color:red">', '</h5>');
//    echo form_label('Nome do curso: ');
//    echo form_input(array('name' => 'nomeCurso'), '', 'autofocus');
//    echo br(3);
//        
//    $options_dia = array(''=>'Dia','01'=>1,'02'=>2,'03'=>3,'04'=>4,'05'=>5,'06'=>6,'07'=>7,'08'=>8,'09'=>9,
//        '10'=>10,'11'=>11,'12'=>12,'13'=>13,'14'=>14,'15'=>15,'16'=>16,'17'=>17,'18'=>18,'19'=>19,
//        '20'=>20,'21'=>21,'22'=>22,'23'=>23,'24'=>24,'25'=>25,'26'=>26,'27'=>27,'28'=>28,'29'=>29,
//        '30'=>30,'31'=>31);
//    $options_mes = array(''=>'Mês','janeiro'=>Janeiro,'fevereiro'=>Fevereiro,'março'=>Março,'abril'=>Abril,
//        'maio'=>Maio,'junho'=>Junho,'julho'=>Julho,'agosto'=>Agosto,'setembro'=>Setembro,
//        'outubro'=>Outubro,'novembro'=>Novembro,'dezembro'=>Dezembro);
//    $options_ano = array(''=>'Ano','2012'=>2012,'2013'=>2013,'2014'=>2014,'2015'=>2015,'2016'=>2016,'2017'=>2017,
//        '2018'=>2018,'2019'=>2019,'2020'=>2020,'2021'=>2021,'2022'=>2022);
//    
//    echo form_label('Data do início: ');
//
////    echo '<select name="dataIni-dia" required>';
////    foreach ($options_dia as $dia) {
////        echo "<option value=$dia[0]>$dia</option>";
////    }
////    echo '</select>';
////    echo nbs(2);
////    echo '<select name="dataIni-mes" required>';
////    foreach ($options_mes as $mes) {
////        echo "<option value=$mes[0]>$mes</option>";
////    }
////    echo '</select>';
////    echo nbs(2);
////    echo '<select name="dataIni-ano" required=>';
////    foreach ($options_ano as $ano) {
////        echo "<option value=$ano[0]>$ano</option>";
////    }
////    echo '</select>';
//    
//    echo form_dropdown('dataIni_dia',$options_dia, '');
//    echo form_dropdown('dataIni_mes',$options_mes, '');
//    echo form_dropdown('dataIni_ano',$options_ano, '');
//        
//    echo br(3);
//    echo form_label('Data do término: ');
//    
////    echo '<select name="dataFim-dia" required="required">';
////    foreach ($options_dia as $dia) {
////        echo "<option value=$dia[0]>$dia</option>";
////    }
////    echo '</select>';    
////    echo nbs(2);
////    echo '<select name="dataFim-mes" required="required">';
////    foreach ($options_mes as $mes) {
////        echo "<option value=$mes[0]>$mes</option>";
////    }
////    echo '</select>';
////    echo nbs(2);
////    echo '<select name="dataFim-ano" required="required">';
////    foreach ($options_ano as $ano) {
////        echo "<option value=$ano[0]>$ano</option>";
////    }
////    echo '</select>';
//
//    echo form_dropdown('dataFim_dia',$options_dia, '');
//    echo form_dropdown('dataFim_mes',$options_mes, '');
//    echo form_dropdown('dataFim_ano',$options_ano, '');
//    echo br(3);
//    echo form_label('Carga horária: ');
//    echo form_input(array('name' => 'cargaHoraria','size'=>'2'));
//    echo form_label(' horas');
//    echo br(3);
//    echo form_label('Selecione o arquivo CSV com os nomes e e-mails dos participantes: ');
//    echo form_input(array('name' => 'csvfile', 'type' => 'file'));
//    echo br(2);
//    echo form_submit(array('name' => 'cadastrar'), 'Gerar certificados');
//    echo form_close();
//    
//    if($erro_email != NULL){
//        foreach ($email as $mail) {
//            echo $mail;
//        }
//    }