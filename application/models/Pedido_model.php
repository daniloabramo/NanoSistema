<?php
class Pedido_model extends CI_Model{

    // Atualizar status do pedido
    public function update_status($id, $acao)
    {
        $em_andamento = 1;
        $finalizado = 2;
        $cancelado = 3;
        $reembolsado = 4;

        $pedido = $this->db->select('pedido_status_id')
                            ->where('id', $id)
                            ->get('pedido')
                            ->row();

        if (!$pedido) 
        {
            return false;
        }

        $status_atual = $pedido->pedido_status_id;
        $novo_status = null; 
        $mensagem = '';
        
        if ($acao === "finalizar"){
            if ($status_atual == $em_andamento){
                $novo_status = $finalizado;
                $mensagem = 'Pedido Finalizado com Sucesso.';
            }
            else if ($status_atual == $finalizado){
                $mensagem = 'Pedido Já Finalizado';
            }

            else if ($status_atual == $cancelado){
                $mensagem = 'Reative o pedido para dar seguimento nele';
            }

            else if ($status_atual == $reembolsado){
                $mensagem = ' Pedido já reembolsado';
            }
        }

        if ($acao === "cancelar"){
            if ($status_atual == $em_andamento){
                $novo_status = $cancelado;
                $mensagem = 'Pedido Cancelado com Sucesso.';
            }
            
            else if ($status_atual == $finalizado){
                $novo_status = $reembolsado;
                $mensagem = 'Pedido Reembolsado';
            }

            else if ($status_atual == $cancelado){
                $novo_status = $em_andamento;
                $mensagem = 'Pedido Reativado';
            }
            
            else if ($status_atual == $reembolsado){
                $mensagem = 'Não é possível cancelar o reembolso';
            }                    
        }

        if ($novo_status !== null) {
            $this->db->where('id', $id);
            $this->db->update('pedido', ['pedido_status_id' => $novo_status]);
            return $this->db->affected_rows() > 0 || $this->db->trans_status() !== FALSE;
        }
    }
}