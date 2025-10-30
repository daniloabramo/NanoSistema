<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controle extends CI_Controller
{
    public function index(): void
    {
        $this->load->model('Pedido_model');
        
        $DetalhesPedido = $this->Pedido_model->listar();
        /*echo '<pre>';
        echo json_encode($DetalhesPedido, JSON_PRETTY_PRINT);
        echo '</pre>';*/

        $data['menu'] = $this->load->view('partials/menu', NULL, TRUE);
        $data['select_status'] = listarOpcoes($this, 'pedido_status', 'descricao','descricao', 'Selecione');
        $this->load->view('pages/controle', $data);
        $this->load->view('partials/modal', $data);
    }

    public function listar(): void
    {
        $this->load->model("Pedido_model");

        $filtro = array(
            'id' => sanitizarEntrada($this->input->get('id')),
            'nome_completo' =>  sanitizarEntrada($this->input->get('nome_completo')),
            'status' => sanitizarEntrada($this->input->get('status')),
            'data_inicio' => sanitizarEntrada($this->input->get('data_inicio')),
            'data_fim' => sanitizarEntrada($this->input->get('data_fim'))
        );
        
        $data['pedido'] = $this->Pedido_model->listar($filtro);
        
        $this->load->view('/partials/lista_pedido', $data); 
    }

    public function atualizarStatus(): void
    {
        $id   = sanitizarEntrada($this->input->post('id'));
        $acao = sanitizarEntrada($this->input->post('acao'));

        log_message('debug', "Recebido: id={$id}, acao={$acao}");

        if (!$id || !$acao) {
            $res = array(
                "status" => "erro",
                "msg" => "Dados inválidos - ID ou ação não informados"
            );
        
        } else {
            $this->load->model("Pedido_model");
            $resultado = $this->Pedido_model->atualizarStatus($id, $acao);
        
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