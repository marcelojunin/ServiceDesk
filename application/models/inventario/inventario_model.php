<?php

class inventario_model extends CI_Model{
    
    function __construct() {
        
        parent::__construct();
        
    }    
  
    
    //HARDWARE
    
    function m_hardware_list(){
        
        $this->db->select('*');
        $this->db->from('inventario');
        $this->db->order_by("idinventario", "desc");
        
        $variaveis = $this->db->get();
        
        foreach($variaveis -> result() as $linha){
       
        $arr[] = array( 
            
                "idinventario" => $linha->idinventario, 
                "nome" => $linha->nome, 
                "modelo" => $linha->modelo, 
                "marca" => $linha->marca
           
        );
        
        }
        
        if(isset($arr)){
        
        return json_encode($arr);
        }
    }
    
    function m_registro_hardware(){
        
        $_POST = json_decode(file_get_contents('php://input'), true);
        
        $nome = $this->input->post('nome');
        $modelo = $this->input->post('modelo');
        $marca = $this->input->post('marca');
        
        $dados = array(
           'nome'=> $nome,
           'modelo'=>$modelo,
           'marca'=>$marca
        );
        
        $id = $this->input->post('idinventario');
        
        if($id != 0){
            
            $this->db->where('idinventario', $id);
            $query = $this->db->update('inventario', $dados);
            
        }else{
            
            $query = $this->db->insert('inventario', $dados);
            
        }
        
        if($query){
            
            return TRUE;
            
        }else{
            
            return FALSE;
            
        }
        
    }
    
    function m_exclui_hardware(){
        
        
       $data = json_decode(file_get_contents("php://input"));     
 
       $idinvantario  = $data->idinventario;
       
       $this->db->where('idinventario', $idinvantario);
       $query = $this->db->delete('inventario');
       
       
       if($query){
           
           return  TRUE;
           
       }else{
           
           return $this->db->_error_number();
           
       }
    
    }
    
    //SOFTWARE
    
    function m_software_list(){
        
        $this->db->select('*');
        $this->db->from('software');
        $this->db->order_by('idsoftware', 'desc');
        
        $variaveis = $this->db->get();
        
        foreach($variaveis -> result() as $linha){
            
            $arr[] =  array(
                
                "idsoftware" => $linha->idsoftware,
                "nomesoftware" => $linha->nomesoftware,
                "modelosoftware" => $linha->modelosoftware,
                "marcasoftware" => $linha->marcasoftware
                
            );
            
        }
        
        return json_encode($arr);
    }
    
    function m_registrar_software(){
        
         $_POST = json_decode(file_get_contents('php://input'), true);
         
         $idsoftware = $this->input->post('idsoftware');
         $nomesoftware = $this->input->post('nomesoftware');
         $marcasoftware = $this->input->post('marcasoftware');
         $modelosoftware = $this->input->post('modelosoftware');
         
         $arr = array(
             
             'nomesoftware' => $nomesoftware,
             'marcasoftware' => $marcasoftware,
             'modelosoftware' => $modelosoftware
             
         );
         
         if($idsoftware != 0){
             
             $this->db->where('idsoftware', $idsoftware);
             $query = $this->db->update('software', $arr);
             
         }else{
             
             $query = $this->db->insert('software', $arr);
             
         }
     
         if($query){
             
             return TRUE;
             
         }else{
             
             return FALSE;
             
         }
     
    }
    
    function m_excluir_software(){
        
        $data = json_decode(file_get_contents("php://input"));
        
        $idsoftware = $data->idsoftware;
        
        $this->db->where('idsoftware', $idsoftware);
        $exclusao = $this->db->delete('software');
        
        if($exclusao){
            
            return TRUE;
            
        }else{
            
            return $this->db->_error_number();
            
        }
    }
    
    
}