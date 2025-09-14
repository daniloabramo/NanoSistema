<?php
class Instituicao_model extends CI_Model{

    public function get_forma_pagamento()
    {
        return $this->db->get('forma_pagamento')->result_array();
    }

    // Instituicao correspondente a forma de pagamento selecionada
    public function get_instituicao($forma_pagamento_id)
    {
        $this->db->where('forma_pagamento_id', $forma_pagamento_id);
        return $this->db->get('instituicao')->result_array();
    }

    public function get_dados_instituicao($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('instituicao')->row_array();
    }

        public function get_pagamento_instituicao($id)
    {
        $this->db->select('instituicao.id, instituicao.descricao, instituicao.numero_parcelas, forma_pagamento.descricao AS descricao_pagamento');
        $this->db->from('instituicao'); 
        $this->db->join('forma_pagamento', 'forma_pagamento.id = instituicao.forma_pagamento_id');
        $this->db->where('instituicao.id', $id);
        return $this->db->get()->row_array();
    }


}

