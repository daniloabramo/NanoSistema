<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('listarOpcoes')) {
    function listarOpcoes($CI, $tabela, $valor_coluna, $exibir_coluna, $opcao_padrao = 'Selecione', $where = null)
    {
        if ($where !== null) {
            $CI->db->where($where);
        }
        
        $dados = $CI->db->get($tabela)->result_array();
        
        $select_data = array(
            'dados' => $dados,
            'valor_coluna' => $valor_coluna,
            'exibir_coluna' => $exibir_coluna,
            'opcao_padrao' => $opcao_padrao
        );
        
        return $CI->load->view('partials/select', $select_data, TRUE);
    }
}
