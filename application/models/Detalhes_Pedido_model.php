<?php
class Detalhes_Pedido_model extends CI_Model{

    /*

    public function baseQuery()
    {
        #$this->db->select('pedido, pedido_status, pedido_pagamento, pedido_item');
        $this->db->from('pedido');
        $this->db->select('pedido*, pedido_item*');
        $this->db-join('pedido_item.pedido_id = pedido.id');
        #$this->db-join('')
        #$this->db-join('')
        #$this->db-join('')
    }*/

    public function baseQuery()
    {
        $this->db->from('pedido');
        #$this->db->select('pedido');
    }

    // Aqui precisa alterar o nome para get_detalhes_pedido($id)
    public function get_detalhes_pedido()
    {   
        $this->baseQuery();

        $this->db->select('pedido.id AS pedido_id, pedido.data_cadastro AS pedido_data_cadastro');
        $this->db->select('pedido_item.quantidade, pedido_item.preco_unitario, pedido_item.id AS pedido_item_id');
        $this->db->select('produto.id AS produto_id, produto.descricao AS produto_nome, produto.codigo, produto.altura, produto.largura, produto.profundidade');
        $this->db->join('pedido_item', 'pedido_item.pedido_id = pedido.id');
        $this->db->join('produto', 'pedido_item.produto_id = produto.id');
        return $this->db->get()->result_array();
    }

    public function listar()
    {   
        $this->db->select('pedido.*, cliente.nome_completo, cliente.cpf, pedido_status.descricao AS status_descricao');
        $this->db->select("DATE_FORMAT(pedido.data_cadastro, '%d/%m/%Y %H:%i:%s') AS data_cadastro");
        $this->db->join('cliente', 'pedido.cliente_id = cliente.id');
        $this->db->join('pedido_status', 'pedido.pedido_status_id = pedido_status.id');
        return $this->db->get('pedido')->result_array();
    }


}