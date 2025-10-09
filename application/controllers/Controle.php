<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controle extends CI_Controller {

    public function index(){
        
        $this->load->model('Pedido_model');
        
        $Detalhes_Pedido = $this->Pedido_model->listar();
        /*echo '<pre>';
        echo json_encode($Detalhes_Pedido, JSON_PRETTY_PRINT);
        echo '</pre>';*/

        $data['menu'] = $this->load->view('partials/menu', NULL, TRUE);
        $data['select_status'] = select_opcoes($this, 'pedido_status', 'descricao', 'descricao', 'Selecione');
        $this->load->view('pages/controle', $data);
        $this->load->view('partials/modal', $data);
    }

    public function listar()
    {
        $this->load->model("Pedido_model");

        $filtro = array(
            'id' => sanitizar_input($this->input->get('id')),
            'nome_completo' =>  sanitizar_input($this->input->get('nome_completo')),
            'status' => sanitizar_input($this->input->get('status')),
            'data_inicio' => sanitizar_input($this->input->get('data_inicio')),
            'data_fim' => sanitizar_input($this->input->get('data_fim'))
        );
        
        $data['pedido'] = $this->Pedido_model->listar($filtro);
        
        $this->load->view('/partials/lista_pedido', $data); 
    }

    public function atualizar_status()
    {
        $id   = sanitizar_input($this->input->post('id'));
        $acao = sanitizar_input($this->input->post('acao'));

        log_message('debug', "Recebido: id={$id}, acao={$acao}");

        if (!$id || !$acao) {
            $res = array(
                "status" => "erro",
                "msg" => "Dados inválidos - ID ou ação não informados"
            );
        
        } else {
            $this->load->model("Pedido_model");
            $resultado = $this->Pedido_model->update_status($id, $acao);
        
            $res = [
            'status' => $resultado['status'],
            'msg' => $resultado['msg']
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($res));
        }
}