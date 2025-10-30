<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('exibirModal')) {
    function exibirModal($mensagem = '', $tipo = 'info') {
        $CI =& get_instance();
        return $CI->load->view('partials/modal', ['mensagem' => $mensagem, 'tipo' => $tipo], TRUE);
    }
}


