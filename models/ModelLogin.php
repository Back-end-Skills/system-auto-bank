<?php
    namespace Models;

    use Traits\TraitGetIp;

    class ModelLogin extends ModelCrud{

        private $trait;
        private $dateNow;

        public function __construct(){

            $this->trait=TraitGetIp::getUserIp();
            $this->dateNow=date("Y-m-d H:i:s");

        }      
        
        #Retorna os dados do usuário
        public function getDataUser(string $_codigo_conta){

            $b=$this->selectDB("*", "conta","where codigo_conta=?", array($_codigo_conta));
            $f=$b->fetch(\PDO::FETCH_ASSOC);
            $r=$b->rowCount();
            
            // return $arrayData=[ 
            //                     "data"=>$f, 
            //                     "rows"=>$r
            //                   ]; 
            
            $fk_cliente = $f['fk_cliente'];
            
            $query_cliente=$this->selectDB(
                "*", 
                "clientes",
                "where cpf=?", 
                array(
                    $fk_cliente
                )
            );
            
            $fetch_cliente = $query_cliente->fetch(\PDO::FETCH_ASSOC);
            $r_cliente = $query_cliente->rowCount();  
            
            return $_arrayData=[ 
                "data"=>$fetch_cliente, 
                "rows"=>$r_cliente
              ]; 
        }


    }