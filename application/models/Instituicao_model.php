<?php
class Instituicao_model extends CI_Model{

    public function buscarFormaPagamento(): array
    {
        return $this->db->get('forma_pagamento')->result_array();
    }

    // Instituicao correspondente a forma de pagamento selecionada
    public function buscarInstituicao(int $formaPagamentoId): array
    {
        $this->db->where('forma_pagamento_id', $formaPagamentoId);
        return $this->db->get('instituicao')->result_array();
    }

    public function buscarDadosInstituicao(int $id): array
    {
        $this->db->where('id', $id);
        return $this->db->get('instituicao')->row_array();
    }

    public function buscarPagamentoInstituicao(int $id): array
    {
        $this->db->select('instituicao.id, instituicao.descricao, instituicao.numero_parcelas, forma_pagamento.descricao AS descricao_pagamento');
        $this->db->from('instituicao'); 
        $this->db->join('forma_pagamento', 'forma_pagamento.id = instituicao.forma_pagamento_id');
        $this->db->where('instituicao.id', $id);
        return $this->db->get()->row_array();
    }
}

