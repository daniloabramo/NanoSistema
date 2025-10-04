<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function filtro($db, $campo, $valor = '', $operador = '=')
{
    if (empty($valor) || empty($campo)) {
        return $db;
    }

    switch (strtoupper($operador)){
        // Dentro da coluna/ tabela X contém o valor *Y*
        case 'LIKE':
            $db->like($campo, $valor);
            break;
        
        // Dentro da coluna/ tabela X contém o valor de maneira idêntica a Y, Z ou W...
        case 'IN':
            $db->where_in($campo, is_array($valor) ? $valor : array($valor));
            break;
        // Dentro da coluna/ tabela X contém o valor entre A e B.
        case 'BETWEEN':
            if (is_array($valor) && count($valor) == 2) {
                $db->where($campo . ' >=', $valor[0]);
                $db->where($campo . ' <=', $valor[1]);
            }
            break;
        default:
            // Para operadores =, >, <, >=, <=, !=
            $db->where($campo . ' ' . $operador, $valor);
            break;
    }
    
    return $db;
}