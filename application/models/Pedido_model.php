<?php
class Pedido_model extends CI_Model{

    public function baseQuery()
    {
        $this->db->from('pedido');
    }

    // Inserir Pedido ----------------------------------------
    public function inserir_pedido($dados)
    {
        $pedido = [
            'pedido_status_id' => 1,
            'empresa_id'       => 1,
            'cliente_id'       => $dados['cliente_id'],
        ];

        $this->db->insert('pedido', $pedido);
        $pedido_id = $this->db->insert_id();

        if (!empty($dados['produtos'])) {
            $this->inserir_item_pedido($dados['produtos'], $pedido_id);
        }

        if (!empty($dados['instituicao']) && count($dados['instituicao']) === count($dados['total_parcela'])) {
            $this->inserir_pagamento_pedido($dados, $pedido_id);
        }
    }

    private function inserir_item_pedido($produtos, $pedido_id)
    {
        $produto_ids = array_column($produtos, 'id');

        $this->db->select('id, custo_unitario');
        $this->db->where_in('id', $produto_ids);
        $produtos_do_banco = $this->db->get('produto')->result_array();

        $mapa_de_precos = array_column($produtos_do_banco, 'custo_unitario', 'id');

        $item_inserir = [];
        $valor_total = 0.0;

        $this->load->model('Produto_model');

        foreach ($produtos as $p) {
            $produto_id = $p['id'];
            $quantidade = $p['quantidade'];

            if (isset($mapa_de_precos[$produto_id])) {
                try {
                    $this->Produto_model->subtrair_estoque($produto_id, $quantidade);
                } catch (Exception $e) {
                    log_message('error', $e->getMessage());
                    throw $e;
                }

                $item_inserir[] = [
                    'pedido_id'      => $pedido_id,
                    'produto_id'     => $produto_id,
                    'quantidade'     => $quantidade,
                    'custo_unitario' => $mapa_de_precos[$produto_id]
                ];
                $valor_total += $mapa_de_precos[$produto_id] * $quantidade;
            }
        }

        if (!empty($item_inserir)) {
            $this->db->insert_batch('pedido_item', $item_inserir);
        }

        $this->db->where('id', $pedido_id);
        $this->db->update('pedido', ['valor_total' => $valor_total]);
    }

    private function inserir_pagamento_pedido($dados, $pedido_id)
    {
        $pagamento_inserir = [];
        foreach ($dados['instituicao'] as $key => $instituicao_id) {
            $pagamento_inserir[] = [
                'pedido_id'      => $pedido_id,
                'instituicao_id' => $instituicao_id,
                'valor'          => $dados['total_parcela'][$key]
            ];
        }
        $this->db->insert_batch('pedido_pagamento', $pagamento_inserir);
    }

    // Listar Pedidos -----------------------------------------
        public function listar()
    {   
        $this->db->select('pedido.*, cliente.nome_completo, cliente.cpf, cliente.ie, pedido_status.descricao AS status_descricao');
        $this->db->select("DATE_FORMAT(pedido.data_cadastro, '%d/%m/%Y %H:%i:%s') AS data_cadastro");
        $this->db->join('cliente', 'pedido.cliente_id = cliente.id');
        $this->db->join('pedido_status', 'pedido.pedido_status_id = pedido_status.id', 'left');
        $this->db->order_by('pedido.id', 'DESC');
        return $this->db->get('pedido')->result_array();
    }

    // Listar Detalhes Pedido --------------------------------
    public function get_detalhes_pedido($id)
    {   
        $pedido_base = $this->get_pedido_base($id);
        $pedido_item = $this->get_pedido_item($id);
        $pagamento = $this->get_pagamento($id);
        
        return [
        'pedido_detalhes' => $pedido_base,
        'pedido_item' => $pedido_item,
        'pagamento' => $pagamento
    ];
    }

    private function get_pedido_base($id)
    {
        $this->baseQuery(); 
        $this->db->where('pedido.id', $id);
    
        $this->db->select('pedido.id AS pedido_id, pedido.data_cadastro AS pedido_data_cadastro, pedido.valor_total');
        $this->db->select('cliente.nome_completo, cliente.cpf, cliente.rg, cliente.ie, cliente.email, cliente.celular');
        $this->db->select('empresa.nome_fantasia, empresa.cnpj, empresa.celular AS empresa_celular, empresa.email AS empresa_email, empresa.logo');

        $this->db->join('cliente', 'pedido.cliente_id = cliente.id');
        $this->db->join('empresa', 'pedido.empresa_id = empresa.id');

        return $this->db->get()->result_array();
    }

    private function get_pedido_item($id)
    {
        $this->db->reset_query();
        $this->baseQuery(); 
    
        $this->db->where('pedido.id', $id);
        $this->db->select('pedido_item.quantidade, pedido_item.custo_unitario, pedido_item.id AS pedido_item_id');
        $this->db->select('produto.id AS produto_id, produto.descricao AS produto_nome, produto.codigo, produto.altura, produto.largura, produto.profundidade');
    
        $this->db->join('pedido_item', 'pedido_item.pedido_id = pedido.id');
        $this->db->join('produto', 'pedido_item.produto_id = produto.id');

        return $this->db->get()->result_array();
    }

    private function get_pagamento($id)
    {
    
        $this->db->reset_query();
        $this->baseQuery(); 
    
        $this->db->where('pedido.id', $id);
        $this->db->select('pedido_pagamento.data_cadastro AS pedido_pagamento_data_cadastro, pedido_pagamento.valor, pedido_pagamento.pedido_id, pedido_pagamento.instituicao_id');
        $this->db->select('instituicao.numero_parcelas, instituicao.descricao AS instituicao_descricao');
        $this->db->select('forma_pagamento.id AS forma_pagamento_id, forma_pagamento.descricao AS forma_pagamento_descricao');

        $this->db->join('pedido_pagamento', 'pedido_pagamento.pedido_id = pedido.id');
        $this->db->join('instituicao', 'pedido_pagamento.instituicao_id = instituicao.id');
        $this->db->join('forma_pagamento', 'instituicao.forma_pagamento_id = forma_pagamento.id');

        return $this->db->get()->result_array();
    }

    // REFATORAR PARA PRIVATE A AÇÃO DE CANCELAR E FINALIZAR
    // Atualizar status do pedido ----------------------------
    public function update_status($id, $acao)
    {
        $em_andamento = 1;
        $finalizado = 2;
        $cancelado = 3;
        $reembolsado = 4;

        $pedido = $this->db->select('pedido_status_id')
                            ->where('id', $id)
                            ->get('pedido')
                            ->row();

        if (!$pedido) 
        {
            return false;
        }

        $status_atual = $pedido->pedido_status_id;
        $novo_status = null; 
        $mensagem = '';
        
        if ($acao === "finalizar"){
            if ($status_atual == $em_andamento){
                $novo_status = $finalizado;
                $mensagem = 'Pedido Finalizado com Sucesso.';
            }
            else if ($status_atual == $finalizado){
                $mensagem = 'Pedido Já Finalizado';
            }

            else if ($status_atual == $cancelado){
                $mensagem = 'Reative o pedido para dar seguimento nele';
            }

            else if ($status_atual == $reembolsado){
                $mensagem = ' Pedido já reembolsado';
            }
        }

        if ($acao === "cancelar"){
            if ($status_atual == $em_andamento){
                $novo_status = $cancelado;
                $mensagem = 'Pedido Cancelado com Sucesso.';
            }
            
            else if ($status_atual == $finalizado){
                $novo_status = $reembolsado;
                $mensagem = 'Pedido Reembolsado';
            }

            else if ($status_atual == $cancelado){
                $novo_status = $em_andamento;
                $mensagem = 'Pedido Reativado';
            }
            
            else if ($status_atual == $reembolsado){
                $mensagem = 'Não é possível cancelar o reembolso';
            }                    
        }

        if ($novo_status !== null) {
            $this->db->where('id', $id);
            $this->db->update('pedido', ['pedido_status_id' => $novo_status]);
            return $this->db->affected_rows() > 0 || $this->db->trans_status() !== FALSE;
        }
    }
}