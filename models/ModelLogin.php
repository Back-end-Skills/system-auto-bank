<?php
    namespace Models;

   
    class ModelLogin extends ModelCrud{

        private $trait;
        private $dateNow;

        public function __construct(){

            $this->date =new ModelRegister();
            $this->dateNow=date("Y-m-d H:i:s");

        }      
        
        #Retorna os dados do usuário
        public function getDataUserOff($_codigo_conta)
        {

            $b=$this->selectDB("*", "conta","where codigo_conta=?", array($_codigo_conta));
            $f=$b->fetch(\PDO::FETCH_ASSOC);
            //$r=$b->rowCount(); 
            
            //if($f=$b->fetch(\PDO::FETCH_ASSOC)){

                if($r=$b->rowCount() > 0){ 
                $fk_cliente = $f['fk_cliente'];  
                        
                $query_cliente=$this->selectDB( "*", "clientes", "where cpf=?", array($fk_cliente) );                
                $result_cliente = $query_cliente->fetch(\PDO::FETCH_ASSOC);
                    
                // $r_cliente = $query_cliente->rowCount();
                }  if ($r_cliente = $query_cliente->rowCount() > 0) 
                {
                    return $_arrayData=[ 
                        "data"=>$result_cliente, 
                        "rows"=>$r_cliente,
                        "_data"=>$f, 
                        "_rows"=>$r
                    ]; 
                }              
                    

            //} else {
              //  return false;
            //}
             
        }

        #Retorna os dados do usuário
        public function getDataUser(string $_codigo_conta){

            $b=$this->selectDB("*", "conta","where codigo_conta=?", array($_codigo_conta));
            $f=$b->fetch(\PDO::FETCH_ASSOC);            
            $r=$b->rowCount();


            $fk_cliente = $f['fk_cliente'];  
                      
            $query_cliente=$this->selectDB( "*", "clientes", "where cpf=?", array( $fk_cliente ) );                
            $fetch_cliente = $query_cliente->fetch(\PDO::FETCH_ASSOC);
                
            $r_cliente = $query_cliente->rowCount();                 
                return $_arrayData=[ 
                    "data"=>$fetch_cliente, 
                    "rows"=>$r_cliente,
                    "_data"=>$f, 
                    "_rows"=>$r
                ]; 
        }

       
    }