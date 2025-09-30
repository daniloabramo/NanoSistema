<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function filtro_codigo($db, $tabela_coluna, $valor = '')
{
    if (!empty($valor) && !empty($tabela_coluna)) {
        $db->where($tabela_coluna, $valor);
    }
    
    return $db;
}