<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controle extends CI_Controller {

    public function index(){
        $this->load->view('pages/controle');
        $this->load->model('Detalhes_Pedido_model');

        $Detalhes_Pedido = $this->Detalhes_Pedido_model->listar();
        echo '<pre>';
        echo json_encode($Detalhes_Pedido, JSON_PRETTY_PRINT);
        echo '</pre>';

    }

    public function listar()
    {
        $this->load->model("Detalhes_Pedido_model");
        $data['pedido'] = $this->Detalhes_Pedido_model->listar();
        $this->load->view('/partials/lista_pedido', $data); 
    }

public function atualizar_status() {
    // Recebe os dados do POST
    $id   = $this->input->post('id');
    $acao = $this->input->post('acao');

    // Log interno (só para verificar no CI)
    log_message('debug', "Recebido: id={$id}, acao={$acao}");

    // Validação básica dos dados
    if (!$id || !$acao) {
        $res = array(
            "status" => "erro",
            "msg" => "Dados inválidos - ID ou ação não informados"
        );
    } else {
        $this->load->model("Pedido_model");
        
        // Chama o model e verifica se a operação foi bem-sucedida
        $resultado = $this->Pedido_model->update_status($id, $acao);
        
        if ($resultado) {
            $res = array(
                "status" => "ok",
                "msg" => "Pedido {$id} atualizado para {$acao}"
            );
        } else {
            $res = array(
                "status" => "erro", 
                "msg" => "Erro ao atualizar o pedido {$id}"
            );
        }
    }

    // Retorna JSON
    $this->output
         ->set_content_type('application/json')
         ->set_output(json_encode($res));
}

}