<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controle extends CI_Controller {

    public function index(){
        $this->load->view('pages/controle');
        $this->load->model('Detalhes_Pedido_model');

        $Detalhes_Pedido = $this->Detalhes_Pedido_model->listar();
        echo '<pre>';
        echo json_encode($Detalhes_Pedido, JSON_PRETTY_PRINT);
        echo '</pre>';

    }

    public function listar()
    {
        $this->load->model("Detalhes_Pedido_model");
        $data['pedido'] = $this->Detalhes_Pedido_model->listar();
        $this->load->view('/partials/lista_pedido', $data); 


    }

}