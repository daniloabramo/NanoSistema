<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedido extends CI_Controller {
	
    public function index()
    {
        $this->load->model('Pedido_model');
        $this->load->model('Produto_model');
        $this->load->helper('select');


        $data['produto'] = $this->db->get('produto')->result_array();

        $data['menu'] = $this->load->view('partials/menu', NULL, TRUE);
        $data['select_fornecedor'] = select_opcoes($this, 'fornecedor', 'descricao', 'descricao', 'Selecione fornecedor');
        $data['select_modelo'] = select_opcoes($this, 'produto', 'modelo', 'modelo', 'Selecione modelo');
        $data['select_grupo'] = select_opcoes($this, 'produto', 'grupo', 'grupo', 'Selecione grupo');
        $this->load->view('pages/pedido', $data);
        
    }



    public function inserirPedido()
    {   
        /*
        echo "<pre>";
        print_r($this->input->post());
        echo "</pre>";
        */
    
        $dados = $this->input->post();
        $this->load->model('Pedido_model');
        $this->Pedido_model->inserirPedido($dados);
        redirect('controle');
    }

    public function listar()
    {
        $this->load->model('Produto_model');

        $filtro = array(
            'codigo' =>  sanitizar_input($this->input->get('codigo')),
            'nome_produto' =>  sanitizar_input($this->input->get('nome_produto')),
            'nome_fornecedor' =>  sanitizar_input($this->input->get('nome_fornecedor'))
        );

        $filtro = array_filter($filtro);
        $data['produto'] = $this->Produto_model->listar($filtro);

        $this->load->view('/partials/lista_produto', $data); 
    }

    
    ////////////////////////////////////////

    public function adicionado()
    {
        $ids = $this->input->post('ids'); 

        if (!empty($ids)) {
            $this->load->model("Produto_model");
            $data['produto'] = $this->Produto_model->buscarPorIds($ids);
        } else {
            $data['produto'] = [];
        }

        $this->load->view('partials/produto_adicionado', $data);
    }

    ///////////////////////////////////////////

    public function buscarFormaPagamento()
    {
        $this->load->model('Instituicao_model');
        $forma_pagamento = $this->Instituicao_model->buscarFormaPagamento();
        echo json_encode($forma_pagamento);
    }

	public function buscarInstituicao($forma_pagamento_id)
    {
        $this->load->model('Instituicao_model');
        
        $instituicao = $this->Instituicao_model->buscarInstituicao($forma_pagamento_id);
        echo json_encode($instituicao);
    }

    public function adicionar_pagamento()
    {
        $instituicao_id =  sanitizar_input($this->input->post('instituicao_id'));
        $valor =  sanitizar_input($this->input->post('valor'));

        if ($instituicao_id && is_numeric($valor) && $valor > 0) {
            $this->load->model('Instituicao_model');
            $dados = $this->Instituicao_model->buscarPagamentoInstituicao($instituicao_id);

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
        $dados = $this->Pedido_model->buscarDetalhesPedido($id);

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






