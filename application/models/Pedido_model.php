<?php
class Pedido_model extends CI_Model{

    public function consultaBase(): void
    {
        $this->db->from('pedido');
    }

    // Inserir Pedido ----------------------------------------
    public function inserirPedido($dados): void
    {
        $pedido = [
            'pedido_status_id' => 1,
            'empresa_id'       => 1,
            'cliente_id'       => $dados['cliente_id'],
        ];

        $this->db->insert('pedido', $pedido);
        $pedido_id = $this->db->insert_id();

        if (!empty($dados['produtos'])) {
            $this->inserirItemPedido($dados['produtos'], $pedido_id);
        }

        if (!empty($dados['instituicao']) && count($dados['instituicao']) === count($dados['total_parcela'])) {
            $this->inserirPagamentoPedido($dados, $pedido_id);
        }
    }

    private function inserirItemPedido(array $produtos, int $pedido_id): void
    {
        $produto_ids = array_column($produtos, 'id');

        $this->db->select('id, preco_unitario');
        $this->db->where_in('id', $produto_ids);
        $produtos_do_banco = $this->db->get('produto')->result_array();

        $mapaPrecos = array_column($produtos_do_banco, 'preco_unitario', 'id');

        $itemInserir = [];
        $valorTotal = 0.0;

        $this->load->model('Produto_model');

        foreach ($produtos as $p) {
            $produto_id = $p['id'];
            $quantidade = $p['quantidade'];

            if (isset($mapaPrecos[$produto_id])) {
                try {
                    $this->Produto_model->subtrairEstoque($produto_id, $quantidade);
                } catch (Exception $e) {
                    log_message('error', $e->getMessage());
                    throw $e;
                }

                $itemInserir[] = [
                    'pedido_id'      => $pedido_id,
                    'produto_id'     => $produto_id,
                    'quantidade'     => $quantidade,
                    'preco_unitario' => $mapaPrecos[$produto_id]
                ];
                $valorTotal += $mapaPrecos[$produto_id] * $quantidade;
            }
        }

        if (!empty($itemInserir)){
            $this->db->insert_batch('pedido_item', $itemInserir);
        }

        $this->db->where('id', $pedido_id);
        $this->db->update('pedido', ['valor_total' => $valorTotal]);
    }

    private function inserirPagamentoPedido(array $dados, int $pedido_id): void
    {
        $pagamentoInserir = [];
        foreach ($dados['instituicao'] as $key => $instituicao_id) {
            $pagamentoInserir[] = [
                'pedido_id'      => $pedido_id,
                'instituicao_id' => $instituicao_id,
                'valor'          => $dados['total_parcela'][$key]
            ];
        }
        $this->db->insert_batch('pedido_pagamento', $pagamentoInserir);
    }

    // Listar Pedidos -----------------------------------------
    public function listar(array $filtro = []): array
    {   
        $data_inicio = $filtro['data_inicio'] ?? null;
        $data_fim = $filtro['data_fim'] ?? null;
    
        if (!empty($data_inicio) && empty($data_fim)) {
            $data_inicio .= ' 00:01:00';
            $data_fim = date('Y-m-d') . ' 23:59:59';

        } elseif (empty($data_inicio) && !empty($data_fim)) {
            $data_inicio = (new DateTime())->modify('-3 months')->format('Y-m-d') . ' 00:01:00';
            $data_fim .= ' 23:59:59';

        } elseif (empty($data_inicio) || empty($data_fim)) {
            $data_fim = date('Y-m-d') . ' 23:59:59';
            $data_inicio = (new DateTime())->modify('-3 months')->format('Y-m-d') . ' 00:01:00';

        } else {
            $data_inicio .= ' 00:01:00';
            $data_fim .= ' 23:59:59';
        }
    
        $filtro['periodo'] = array($data_inicio, $data_fim);

        $this->db = filtro($this->db, 'pedido.id', $filtro['id'] ?? '' );
        $this->db = filtro($this->db, 'cliente.nome_completo', $filtro['nome_completo'] ?? '', 'LIKE');
        $this->db = filtro($this->db, 'pedido_status.descricao', $filtro['status'] ?? '', 'LIKE');
        $this->db = filtro($this->db, 'pedido.data_cadastro', $filtro['periodo'] ?? '', 'BETWEEN');

        $this->db->select('pedido.*, cliente.nome_completo, cliente.cpf, cliente.ie, pedido_status.descricao AS status_descricao');
        $this->db->select("DATE_FORMAT(pedido.data_cadastro, '%d/%m/%Y %H:%i:%s') AS data_cadastro");
        $this->db->join('cliente', 'pedido.cliente_id = cliente.id');
        $this->db->join('pedido_status', 'pedido.pedido_status_id = pedido_status.id', 'left');

        $this->db->order_by('pedido.id', 'DESC');
        return $this->db->get('pedido')->result_array();
    }

    // Listar Detalhes Pedido --------------------------------
    public function buscarDetalhesPedido(int $id): array
    {   
        $pedido_base = $this->buscarPedidoBase($id);
        $pedido_item = $this->buscarPedidoItem($id);
        $pagamento = $this->buscarPagamento($id);
        
        return [
        'pedido_detalhes' => $pedido_base,
        'pedido_item' => $pedido_item,
        'pagamento' => $pagamento
    ];
    }

    private function buscarPedidoBase(int $id): array
    {
        $this->consultaBase(); 
        $this->db->where('pedido.id', $id);
    
        $this->db->select('pedido.id AS pedido_id, pedido.data_cadastro AS pedido_data_cadastro, pedido.valor_total');
        $this->db->select('cliente.nome_completo, cliente.cpf, cliente.rg, cliente.ie, cliente.email, cliente.celular');
        $this->db->select('empresa.nome_fantasia, empresa.cnpj, empresa.celular AS empresa_celular, empresa.email AS empresa_email, empresa.logo');

        $this->db->join('cliente', 'pedido.cliente_id = cliente.id');
        $this->db->join('empresa', 'pedido.empresa_id = empresa.id');

        return $this->db->get()->result_array();
    }

    private function buscarPedidoItem(int $id): array
    {
        $this->db->reset_query();
        $this->consultaBase(); 
    
        $this->db->where('pedido.id', $id);
        $this->db->select('pedido_item.quantidade, pedido_item.preco_unitario, pedido_item.id AS pedido_item_id');
        $this->db->select('produto.id AS produto_id, produto.descricao AS produto_nome, produto.codigo, produto.altura, produto.largura, produto.profundidade');
    
        $this->db->join('pedido_item', 'pedido_item.pedido_id = pedido.id');
        $this->db->join('produto', 'pedido_item.produto_id = produto.id');

        return $this->db->get()->result_array();
    }

    private function buscarPagamento(int $id): array
    {
    
        $this->db->reset_query();
        $this->consultaBase(); 
    
        $this->db->where('pedido.id', $id);
        $this->db->select('pedido_pagamento.data_cadastro AS pedido_pagamento_data_cadastro, pedido_pagamento.valor, pedido_pagamento.pedido_id, pedido_pagamento.instituicao_id');
        $this->db->select('instituicao.numero_parcelas, instituicao.descricao AS instituicao_descricao');
        $this->db->select('forma_pagamento.id AS forma_pagamento_id, forma_pagamento.descricao AS forma_pagamento_descricao');

        $this->db->join('pedido_pagamento', 'pedido_pagamento.pedido_id = pedido.id');
        $this->db->join('instituicao', 'pedido_pagamento.instituicao_id = instituicao.id');
        $this->db->join('forma_pagamento', 'instituicao.forma_pagamento_id = forma_pagamento.id');

        return $this->db->get()->result_array();
    }

    // Atualizar status do pedido ----------------------------
    public function atualizarStatus(int $id, string $acao): array
    {
        $statusMapa = [
            'Em_Andamento' => 1,
            'Finalizado'   => 2,
            'Cancelado'    => 3,
        ];

        $pedido = $this->db->select('pedido_status_id')
            ->where('id', $id)
            ->get('pedido')
            ->row();

        if (!$pedido) {
            return ['status' => 'erro', 'msg' => 'Pedido não encontrado'];
        }

        $statusAtual = $pedido->pedido_status_id;
        $novoStatus = null;
        $mensagem = '';

        if ($acao === "finalizar") {
            list($novoStatus, $mensagem, $status) = $this->finalizarPedido($statusAtual, $statusMapa);
        } elseif ($acao === "cancelar") {
            list($novoStatus, $mensagem, $status) = $this->cancelarPedido($statusAtual, $statusMapa);
        }

        if ($novoStatus !== null) {
            $this->db->where('id', $id);
            $this->db->update('pedido', ['pedido_status_id' => $novoStatus]);
            
            if ($this->db->affected_rows() > 0 || $this->db->trans_status() !== FALSE) {
            return ['status' => 'sucesso', 'msg' => $mensagem];
        } else {
            return ['status' => 'erro', 'msg' => 'Erro ao atualizar o banco de dados'];
        }
        }

        return ['status' => $status ?? 'info', 'msg' => $mensagem];
    }

    private function finalizarPedido(int $statusAtual, array $statusMapa): array
    {
        if ($statusAtual == $statusMapa['Em_Andamento']) {
            return [$statusMapa['Finalizado'], 'Pedido Finalizado com Sucesso.','sucesso'];
        }
        if ($statusAtual == $statusMapa['Finalizado']) {
            return [null, 'Pedido Já Finalizado', 'erro'];
        }
        if ($statusAtual == $statusMapa['Cancelado']) {
            return [null, 'Reative o Pedido Para Dar Seguimento', 'info'];
        }
        return [null, 'Status inválido para finalização','erro'];
    }

    private function cancelarPedido(int $statusAtual, array $statusMapa): array
    {
        if ($statusAtual == $statusMapa['Em_Andamento']) {
            return [$statusMapa['Cancelado'], 'Pedido Cancelado com Sucesso.','sucesso'];
        }
        if ($statusAtual == $statusMapa['Finalizado']) {
            return  [null, 'Não é Possível Cancelar Pedido Finalizado','erro'];
        }
        if ($statusAtual == $statusMapa['Cancelado']) {
            return [$statusMapa['Em_Andamento'], 'Pedido Reativado','sucesso'];
        }
        return [null, 'Status inválido para cancelamento','erro'];
    }

}