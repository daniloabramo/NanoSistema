<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controle extends CI_Controller {

    public function index(){
        
        $this->load->model('Pedido_model');
        
        $Detalhes_Pedido = $this->Pedido_model->listar();
        /*echo '<pre>';
        echo json_encode($Detalhes_Pedido, JSON_PRETTY_PRINT);
        echo '</pre>';*/


        $data['select_status'] = select_opcoes($this, 'pedido_status', 'descricao', 'descricao', 'Selecione status');
        $this->load->view('pages/controle', $data);


    }

    public function listar()
    {

        $this->load->model("Pedido_model");

        $filtro = array(
            'id' => $this->input->get('id'),
            'status' => $this->input->get('status'),
            'data_inicio' => $this->input->get('data_inicio'),
            'data_fim' => $this->input->get('data_fim')
        );

        $filtro = array_filter($filtro);
        $data['pedido'] = $this->Pedido_model->listar($filtro);
        
        $this->load->view('/partials/lista_pedido', $data); 
    }

    public function atualizar_status()
    {
        $id   = $this->input->post('id');
        $acao = $this->input->post('acao');

        log_message('debug', "Recebido: id={$id}, acao={$acao}");

        if (!$id || !$acao) {
            $res = array(
                "status" => "erro",
                "msg" => "Dados inválidos - ID ou ação não informados"
            );
        
        } else {
            $this->load->model("Pedido_model");
        
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

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($res));
        }

}