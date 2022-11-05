<?php
    namespace Models;

    class ModelRegister extends ModelCrud{
        
      
        private int $codigo_agencia;
        private int $codigo_conta;
        private int $saldo=0;
       
        #Realizará a inserção no banco de dados
        public function insertCad($arrayVar){

            $this->insertDB("clientes", "?,?,?,?,?,?",
                        array(
                            0,
                            $arrayVar['nome'],
                            $arrayVar['nascimento'],
                            $arrayVar['cpf'],
                            $arrayVar['email'],
                            $arrayVar['hashSenha']                                                                      
                        )
                    );
            
            $this->insConta($arrayVar);
            $this->insLog($arrayVar);
                
        }
        
        public function insConta($arrayVar){

            $dataCreatedAd=date('Y-m-d H:i:s', time());
            $this->codigo_agencia = rand(3,100);
            $this->codigo_conta = rand(100000,999999);

            $this->insertDB("conta", "?,?,?,?,?,?", 
                        array(
                            0,
                            $arrayVar['cpf'],
                            $this->codigo_agencia,
                            $this->codigo_conta,
                            $this->saldo,
                            $dataCreatedAd

                        )
                    );
        
        }

        public function insLog($arrayVar){
            
            $dataCreatedAd=date('Y-m-d H:i:s', time());

            $this->insertDB(
                "log",
                "?,?,?,?,?,?",
                array(
                    0,
                    $this->saldo,
                    $this->codigo_agencia,
                    $this->codigo_conta,
                    $this->saldo,
                    $dataCreatedAd
                )

            );

        } 
        
        public function getIssetEmail($email){

            $b=$this->selectDB("*", "clientes", "where email=?", array($email));
            return $b->rowCount();
            
        }
      
        #Veriricar se existe agencia
        public function getIssetAgencia(string $_codigo_agencia){

            $b=$this->selectDB("*", "conta", "where codigo_agencia=?", 
                            array($_codigo_agencia)
                        );

            return $b->rowCount();
            
        }

        #Veriricar se existe Conta
        public function getIssetConta(string $_codigo_conta){

            $b=$this->selectDB("*", "conta", "where codigo_conta=?", 
                            array($_codigo_conta)
                        );

            return $b->rowCount();
            
        }

       

        
    }