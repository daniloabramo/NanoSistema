<?php
class Produto_model extends CI_Model{

    private function baseQuery()
    {
        $this->db->select('produto.id, produto.codigo, produto.altura, produto.largura, produto.profundidade, produto.estoque, produto.custo_unitario, produto.descricao AS produto_nome, fornecedor.descricao AS fornecedor_nome, modelo.descricao AS modelo_nome, grupo.descricao AS grupo_nome');
        $this->db->join('fornecedor', 'fornecedor.id = produto.fornecedor_id');
        $this->db->join('modelo', 'modelo.id = produto.modelo_id');
        $this->db->join('grupo', 'grupo.id = produto.grupo_id');
    }

    public function listar($codigo = '')
    {
        $this->baseQuery();

        $this->db = filtro_codigo($this->db, 'produto.codigo', $codigo);

        $this->db->order_by('produto.codigo', 'DESC');
        return $this->db->get('produto')->result_array();
    }

    public function getByIds($ids = [])
    {
        if (empty($ids)) {
            return [];
        }

        $this->baseQuery();
        $this->db->where_in('produto.id', $ids);
        return $this->db->get('produto')->result_array();
    }

    public function get_produto_pedido_item()
    {
        $this->db->select('produto.id AS produto_id, produto.descricao AS produto_nome, produto.codigo, produto.altura, produto.largura, produto.profundidade');
    }

    public function subtrair_estoque($produto_id, $quantidade)
    {
        $this->db->set('estoque', 'estoque - ' . (int)$quantidade, FALSE);
        $this->db->where('id', $produto_id);
        $this->db->where('estoque >=', $quantidade);
        $result = $this->db->update('produto');
    
        if ($this->db->affected_rows() === 0) {
            throw new Exception('Estoque insuficiente para produto ID: ' . $produto_id);
        }
    
        return $result;
    }


    
}




