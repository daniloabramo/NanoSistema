<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedido extends CI_Controller {
	
    public function index()
    {
        $this->load->view('pages/pedido'); 
        $this->load->model('Pedido_model');
    }

    public function inserir_pedido()
    {
        echo "<pre>";
        print_r($this->input->post());
        echo "</pre>";
    
        $dados = $this->input->post();
        $this->load->model('Pedido_model');
        $this->Pedido_model->inserir_pedido($dados);
    }

    public function listar()
    {
        $this->load->model("Produto_model");

        $codigo = $this->input->get('codigo');
        $data['produto'] = $this->Produto_model->listar($codigo);
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

    // Detalhes Pedido
    public function Detalhes_Pedido($id_codificado){
        $id = base64_decode(urldecode($id_codificado));
        $this->load->model('Pedido_model');
        $dados = $this->Pedido_model->get_detalhes_pedido($id);

        $data['pedido'] = $dados['pedido_detalhes'][0];
        $data['item']  = $dados['pedido_item'];
        $data['pagamento'] = $dados['pagamento'];
 
        
        #echo '<pre>';
        #echo json_encode($dados, JSON_PRETTY_PRINT);
        #echo '</pre>';
        $this->load->view('pages/impressao', $data);
        $this->load->view('pages/contrato');
    }




}






