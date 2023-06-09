<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Base extends CI_Controller {
  /**
    * Método construtor
    *
    * @access  public
    * @return  void
    */
	function __construct() {
		parent::__construct();
		$this->load->model('csv_model');
		$this->load->library('csvimport');
	}
  /**
    * Método que carrega a home
    *
    * @access  public
    * @return  void
    */
	function Index() {
    // Recuperar os registros cadastrados na tabela contatos
//		$data['alunos'] = $this->csv_model->get_contatos();
		$this->load->view('main', $data);
	}
  /**
    * Faz a improtação do CSV
    *
    * @access  public
    * @return  void
    */
	function ImportCsv() {
    // Recuperar os registros cadastrados na tabela contatos
//		$data['alunos'] = $this->csv_model->get_contatos();
		$data['error'] = '';
    // Define as configurações para o upload do CSV
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'csv';
		$config['max_size'] = '1000';
		$this->load->library('upload', $config);
		// Se o upload falhar, exibe mensagem de erro na view
		if (!$this->upload->do_upload('csvfile')) {
			$data['error'] = $this->upload->display_errors();
			$this->load->view('main', $data);
		} else {
			$file_data = $this->upload->data();
			$file_path =  './uploads/'.$file_data['file_name'];
      // Chama o método 'get_array', da library csvimport, passando o path do
      // arquivo CSV. Esse método retornará um array.
      $csv_array = $this->csvimport->get_array($file_path);
			if ($csv_array) {
        // Faz a interação no array para poder gravar os dados na tabela 'contatos'
				foreach ($csv_array as $row) {
					$insert_data = array(
						'nome' => $row['nome'],
                                                'conceito' => $row['conceito'],
						'email' => $row['email'],
					);
          // Insere os dados na tabela 'contatos'
					$this->csv_model->set_aluno($insert_data);
				}
        
				$this->session->set_flashdata('success', 'Dados importados com sucesso!');
				redirect();
			} else
			   $data['error'] = "Ocorreu um erro, desculpe!";
			$this->load->view('main', $data);
		}
	}
}