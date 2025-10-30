<?php
class Cliente_model extends CI_Model
{
    public function getAll(): array
    {   $this->db->select('cliente.id, cliente.nome_completo');
        return $this->db->get('cliente')->result_array();
    }
}