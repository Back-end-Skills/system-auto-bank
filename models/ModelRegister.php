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
      

        #Veriricar se já existe o mesmo email cadastro no db
        public function getIssetEmail($email){

            $b=$this->selectDB("*", "clientes", "where email=?", 
                            array($email)
                        );

            return $b->rowCount();
            
        }

       

        
    }