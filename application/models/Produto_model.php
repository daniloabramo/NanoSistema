<?php
class Produto_model extends CI_Model{

    private function baseQuery()
    {
        $this->db->select('produto.id, produto.codigo, produto.altura, produto.largura, produto.profundidade, produto.estoque, produto.custo_unitario, produto.descricao AS produto_nome, fornecedor.descricao AS fornecedor_nome, modelo.descricao AS modelo_nome, grupo.descricao AS grupo_nome');
        $this->db->join('fornecedor', 'fornecedor.id = produto.fornecedor_id');
        $this->db->join('modelo', 'modelo.id = produto.modelo_id');
        $this->db->join('grupo', 'grupo.id = produto.grupo_id');
    }

    public function getAll()
    {
        $this->baseQuery();
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
}




