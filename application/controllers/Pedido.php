<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedido extends CI_Controller {
	
    public function index()
    {
        $this->load->view('pages/pedido'); 
    }

    public function listar()
    {
        $this->load->model("Produto_model");
        $data['produto'] = $this->Produto_model->getAll();
        $this->load->view('/partials/lista_produto', $data); 
    }
    ////////////////////////////////////////

    public function adicionado()
    {
        $ids = $this->input->post('ids'); 

        if (!empty($ids)) {
            $this->load->model("Produto_model");
            $data['produto'] = $this->Produto_model->getByIds($ids);
        } else {
            $data['produto'] = [];
        }

        $this->load->view('partials/produto_adicionado', $data);
    }

}



