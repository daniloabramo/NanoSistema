<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lista_Pagamento extends CI_Controller {
    public function index(): void
    {
        $this->load->model('Pagamento_model');
        $data['instituicao'] = $this->Pagamento_model->Index();
        $this->load->view('partials/lista_pagamento', $data);
    }

    public function adicionarPagamento(): void
    {
        $this->load->model('Pagamento_model');
        $adicionarPagamento = $this->Pagamento_model->Index();
        echo json_encode($adicionarPagamento);
    }
}

