<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controle extends CI_Controller {

    public function index()
    {
        $this->load->view('pages/controle');
        $this->load->model('Pedido_model'); 

        $pedido = $this->Pedido_model->lista();
        echo json_encode($pedido);
    }
}