<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detalhes_Pedido extends CI_Controller {
    public function index(){
        $this->load->view('pages/detalhes_pedido');
        $this->load->model('Detalhes_Pedido_model');

        $Detalhes_Pedido = $this->Detalhes_Pedido_model->get_detalhes_pedido();
        echo '<pre>';
        echo json_encode($Detalhes_Pedido, JSON_PRETTY_PRINT);
        echo '</pre>';
    }
}