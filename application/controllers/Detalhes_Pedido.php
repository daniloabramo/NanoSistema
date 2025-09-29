<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detalhes_Pedido extends CI_Controller {
    public function index(){

        $this->load->model('Detalhes_Pedido_model');
        $this->load->view('pages/detalhes_pedido');
    }

    public function get_pedido($id){
        $this->load->model('Detalhes_Pedido_model');
        $Detalhes_Pedido = $this->Detalhes_Pedido_model->get_detalhes_pedido($id);
        echo '<pre>';
        echo json_encode($Detalhes_Pedido, JSON_PRETTY_PRINT);
        echo '</pre>';
    }

    public function inserir_pedido()
    {
        echo "<pre>";
        print_r($this->input->post());
        echo "</pre>";
    
        $dados = $this->input->post();
        $this->load->model('Detalhes_Pedido_model');
        $this->Detalhes_Pedido_model->inserir_pedido($dados);
    }
}

