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
    public function listar($filtro = array())
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

    // Atualizar status do pedido ----------------------------
    public function update_status($id, $acao)
    {
        $status_map = [
            'em_andamento' => 1,
            'finalizado'   => 2,
            'cancelado'    => 3,
            'reembolsado'  => 4,
        ];

        $pedido = $this->db->select('pedido_status_id')
            ->where('id', $id)
            ->get('pedido')
            ->row();

        if (!$pedido) {
            return false;
        }

        $status_atual = $pedido->pedido_status_id;
        $novo_status = null;
        $mensagem = '';

        if ($acao === "finalizar") {
            list($novo_status, $mensagem) = $this->finalizar_pedido($status_atual, $status_map);
        } elseif ($acao === "cancelar") {
            list($novo_status, $mensagem) = $this->cancelar_pedido($status_atual, $status_map);
        }

        if ($novo_status !== null) {
            $this->db->where('id', $id);
            $this->db->update('pedido', ['pedido_status_id' => $novo_status]);
            return $this->db->affected_rows() > 0 || $this->db->trans_status() !== FALSE;
        }

        return $mensagem;
    }

    private function finalizar_pedido($status_atual, $status_map)
    {
        if ($status_atual == $status_map['em_andamento']) {
            return [$status_map['finalizado'], 'Pedido Finalizado com Sucesso.'];
        }
        if ($status_atual == $status_map['finalizado']) {
            return [null, 'Pedido Já Finalizado'];
        }
        if ($status_atual == $status_map['cancelado']) {
            return [null, 'Reative o pedido para dar seguimento nele'];
        }
        if ($status_atual == $status_map['reembolsado']) {
            return [null, 'Pedido já reembolsado'];
        }
        return [null, 'Status inválido para finalização'];
    }

    private function cancelar_pedido($status_atual, $status_map)
    {
        if ($status_atual == $status_map['em_andamento']) {
            return [$status_map['cancelado'], 'Pedido Cancelado com Sucesso.'];
        }
        if ($status_atual == $status_map['finalizado']) {
            return [$status_map['reembolsado'], 'Pedido Reembolsado'];
        }
        if ($status_atual == $status_map['cancelado']) {
            return [$status_map['em_andamento'], 'Pedido Reativado'];
        }
        if ($status_atual == $status_map['reembolsado']) {
            return [null, 'Não é possível cancelar o reembolso'];
        }
        return [null, 'Status inválido para cancelamento'];
    }

}