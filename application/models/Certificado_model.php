<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Certificado_model extends CI_Model {

    function get_certificado($id_certificado) {
        $array = array(
            'id_certificado' => $id_certificado,
        );
        $res = $this->db->get_where('cert_certificados', $array);

        if ($res->num_rows() > 0) {
            return $res->row_array();
        } else {
            return FALSE;
        }
    }

    function get_allCertificados() {
        $this->db->order_by('nome_certificado', 'ASC');
        $query = $this->db->get('cert_certificados');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

}
