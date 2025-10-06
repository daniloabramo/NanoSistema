<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function sanitizar_input($input) {
    $CI =& get_instance();
    $clean = strip_tags($input); 
    $clean = $CI->security->xss_clean($clean); 
    $clean = html_escape($clean); 
    $clean = preg_replace('/[^a-zA-Z0-9\s\-@\.]/', '', $clean); 
    return $clean;
}
