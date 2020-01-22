<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ImportCsv extends CI_Controller {

    public function index() {
        $this->load->view('main');
    }

    public function importar() {

        // Define as configurações para o upload do CSV
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '5000';
        $this->load->library('upload', $config);

        // Se o upload falhar, exibe mensagem de erro na view
        if (!$this->upload->do_upload('csvfile')) {
            $data['error'] = $this->upload->display_errors();
            $this->load->view('main', $data);
        } else {
            $file_data = $this->upload->data();
            $file_path = './uploads/' . $file_data['file_name'];

            // Chama o método 'get_array', da library csvimport, passando o path do
            // arquivo CSV. Esse método retornará um array.
            $csv_array = $this->csvimport->get_array($file_path);
//            if ($csv_array) {
//                $this->load->model('Csv_model');
//
//                // Faz a interação no array para poder gravar os dados na tabela 'curso'
//                foreach ($csv_array as $row) {
//                    $insert_data = array(
//                        'nome' => $row['nome'],
//                        'conceito' => $row['conceito'],
//                        'email' => $row['email'],
//                    );
//                    // Insere os dados na tabela 'curso'
//                    
//                    $this->Csv_model->set_alunos($insert_data);
//                $this->gerarPdf($csv_array);
//                    $this->session->set_flashdata('success', 'Dados importados com sucesso!');
//                    redirect();
        }
//                } 
//                $this->gerarPdf();
//                $this->load->view('main', $data);
//            } else {
//        $data['error'] = "Ocorreu um erro, desculpe!";
        echo 'erro import';
    }

}
