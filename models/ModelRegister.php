<?php
    namespace Models;

use PDO;

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
                    '0',
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

        #Grava log de login
        public function isLogLogin($_codigo_conta){

            $q=$this->selectDB("*", "conta", "where codigo_conta=?", array($_codigo_conta));
            $f = $q->fetch(\PDO::FETCH_ASSOC);

            $dataCreated=date('Y-m-d H:i:s', time());

            $this->insertDB(
                "log",
                "?,?,?,?,?,?",
                array(
                    0,
                    0,
                    $f['codigo_agencia'],
                    $f['codigo_conta'],
                    0,
                    $dataCreated
                )
            );
            
        }

        #Realizará deposito
        public function insertDeposito($arrayVarDep){

            //Select db conta
            $conta = $this->selectDB("*", "conta", "WHERE codigo_conta=?", array($arrayVarDep['conta']));
            $c_result = $conta->fetch(\PDO::FETCH_ASSOC);
            $id_conta=$c_result['id_conta'];

            $dataCreated=date('Y-m-d H:i:s', time());

            $res=$this->insertDB("transacao", "?,?,?,?,?",
                        array(
                            0,
                            $id_conta,
                            'deposito em conta corrente',
                            'credito',
                            $dataCreated                                                                      
                        )
                    );

            if($res->rowCount() > 0)
            {   
                //select db transacao
                $transacao=$this->selectDB("*", "transacao", "where fk_conta=?", array($id_conta));
                $result = $transacao->fetch(\PDO::FETCH_ASSOC);
                $codigo_transacao = $result['codigo'];
             
                $this->insertDB("log", "?,?,?,?,?,?",  
                        array(
                            0,
                            $codigo_transacao,
                            $arrayVarDep['agencia'],
                            $arrayVarDep['conta'],
                            $arrayVarDep['valor_deposito'],
                            $dataCreated
                        )
                    );

                $saldo= $c_result['saldo'];
                $saldo = ($saldo + $arrayVarDep['valor_deposito']);

                //update conta 
                $this->updateDB("conta", "saldo=?", "codigo_conta=?", array($saldo ,$arrayVarDep['conta']));
                 
                
            }
                
        }

       

        
    }