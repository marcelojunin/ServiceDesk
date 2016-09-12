<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perfil_pessoal_controller extends CI_Controller {
    
    function alterar_perfil(){
        
       $this->load->model('perfil_pessoal/perfil_pessoal_model');
       $this->load->model('usuario/usuario_model');
       
        
       $this->load->helper('setor_ativo/setor_ativo_helper');
       
       $variaveis['setor_ativo'] = getSetorAtivo();
       
       
       $this->load->helper('valida_login/valida_administrador_helper');
        
       $variaveis['validacao'] = getValidaAdministrador();
       
       
       $variaveis['consulta'] = $this->preenche_dados();
        
        $this->load->view('perfil_pessoal/perfil_pessoal_view', $variaveis);
        
    }
    
    function preenche_dados(){
        
        $this->load->model('perfil_pessoal/perfil_pessoal_model');
        
        $id = $this->session->userdata('id');
        
        $dados = $this->perfil_pessoal_model->m_list_usuario($id);
        
        return $dados;
        
    }
    
    function  atualiza_perfil(){
        
        //Criar caso precise de uma função unica para atualizar perfil.
    }
    
}