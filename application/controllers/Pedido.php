<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedido extends CI_Controller {
	
    public function index(): void
    {
        $this->load->model('Pedido_model');
        $this->load->model('Produto_model');
        $this->load->helper('select');


        $data['produto'] = $this->db->get('produto')->result_array();

        $data['menu'] = $this->load->view('partials/menu', NULL, TRUE);
        $data['selecionarFornecedor'] = listarOpcoes($this, 'fornecedor', 'descricao', 'descricao', 'Selecione fornecedor');
        $data['selecionarModelo'] = listarOpcoes($this, 'produto', 'modelo', 'modelo', 'Selecione modelo');
        $data['selecionarGrupo'] = listarOpcoes($this, 'produto', 'grupo', 'grupo', 'Selecione grupo');
        $this->load->view('pages/pedido', $data);
    }

    public function inserirPedido(): void
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

    public function listar(): void
    {
        $this->load->model('Produto_model');

        $filtro = array(
            'codigo' =>  sanitizarEntrada($this->input->get('codigo')),
            'nome_produto' =>  sanitizarEntrada($this->input->get('nome_produto')),
            'nome_fornecedor' =>  sanitizarEntrada($this->input->get('nome_fornecedor'))
        );

        $filtro = array_filter($filtro);
        $data['produto'] = $this->Produto_model->listar($filtro);

        $this->load->view('/partials/lista_produto', $data); 
    }
    
    ////////////////////////////////////////

    public function adicionado(): void
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

    public function buscarFormaPagamento(): void
    {
        $this->load->model('Instituicao_model');
        $formaPagamento = $this->Instituicao_model->buscarFormaPagamento();
        echo json_encode($formaPagamento);
    }

	public function buscarInstituicao(int $formaPagamentoId): void
    {
        $this->load->model('Instituicao_model');
        
        $instituicao = $this->Instituicao_model->buscarInstituicao($formaPagamentoId);
        echo json_encode($instituicao);
    }

    public function adicionarPagamento(): void
    {
        $instituicaoId =  sanitizarEntrada($this->input->post('instituicao_id'));
        $valor =  sanitizarEntrada($this->input->post('valor'));

        if ($instituicaoId && is_numeric($valor) && $valor > 0) {
            $this->load->model('Instituicao_model');
            $dados = $this->Instituicao_model->buscarPagamentoInstituicao($instituicaoId);

            if ($dados) {
                $dados['valor_total'] = $valor;
                $numParcelas = (int)$dados['numero_parcelas'];
                $dados['valor_parcela'] = ($numParcelas > 0) ? $valor / $numParcelas : $valor;
                
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'data' => $dados]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Instituição não encontrada.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
        }
    }

    public function buscarCliente(): void
    {
        $this->load->model('Cliente_model');
        $cliente = $this->Cliente_model->buscarTodos();
        echo json_encode($cliente);
    }

    // Detalhes Pedido
    public function DetalhesPedido(string $idCodificado): void
    {
        $id = base64_decode(urldecode($idCodificado));
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






