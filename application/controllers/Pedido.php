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

    ///////////////////////////////////////////

    public function get_forma_pagamento()
    {
        $this->load->model('Instituicao_model');
        $forma_pagamento = $this->Instituicao_model->get_forma_pagamento();
        echo json_encode($forma_pagamento);
    }

	public function get_instituicao($forma_pagamento_id)
    {
        $this->load->model('Instituicao_model');
        
        $instituicao = $this->Instituicao_model->get_instituicao($forma_pagamento_id);
        echo json_encode($instituicao);
    }

    public function adicionar_pagamento()
    {
        $instituicao_id = $this->input->post('instituicao_id');
        $valor = $this->input->post('valor');

        if ($instituicao_id && is_numeric($valor) && $valor > 0) {
            $this->load->model('Instituicao_model');
            $dados = $this->Instituicao_model->get_pagamento_instituicao($instituicao_id);

            if ($dados) {
                $dados['valor_total'] = $valor;
                $num_parcelas = (int)$dados['numero_parcelas'];
                $dados['valor_parcela'] = ($num_parcelas > 0) ? $valor / $num_parcelas : $valor;
                
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'data' => $dados]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Instituição não encontrada.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
        }
    }

    public function get_cliente()
    {
        $this->load->model('Cliente_model');
        $cliente = $this->Cliente_model->getAll();
        echo json_encode($cliente);
    }




}






