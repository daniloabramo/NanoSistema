<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('mostrar_modal')) {
    function mostrar_modal($mensagem = '', $tipo = 'info') {
        $CI =& get_instance();
        return $CI->load->view('partials/modal', ['mensagem' => $mensagem, 'tipo' => $tipo], TRUE);
    }
}


