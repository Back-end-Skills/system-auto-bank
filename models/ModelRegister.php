<?php
    namespace Models;

use PDO;

    class ModelRegister extends ModelCrud{
        
      
        private int $codigo_agencia;
        private int $codigo_conta;
        private int $saldo=0;
       

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
                "?,?,?,?,?,?,?,?",
                array(
                    0,
                    '0',
                    $this->codigo_agencia,
                    $this->codigo_conta,
                    "",
                    "",
                    $this->saldo,
                    $dataCreatedAd
                )

            );

        }

        
        #Compra de GIFT CARD
        public function insertGiftCard($arrVarGiftCard)
        {
            
            $conta = $this->selectDB("*", "conta", "WHERE codigo_conta=?", array($arrVarGiftCard['conta']));
            $c_result = $conta->fetch(\PDO::FETCH_ASSOC);
            $id_conta=$c_result['id_conta'];                   

            $dataCreated=date('Y-m-d H:i:s', time());
 
            $res=$this->insertDB("transacao", "?,?,?,?,?", array(0, $id_conta, 'compra de gift card', 'debito', $dataCreated));
            
            $res_select_transacao = $this->selectDB("*", "transacao", "where fk_conta=? ORDER BY codigo DESC LIMIT 1", array($id_conta));
            $trans_result =  $res_select_transacao->fetch(\PDO::FETCH_ASSOC);
            $codigo_transacao=$trans_result['codigo'];

            $res_log = $this->insertDB("log", "?,?,?,?,?,?,?,?", 
                                array(
                                    0,
                                    $codigo_transacao, 
                                    $arrVarGiftCard['agencia'], 
                                    $arrVarGiftCard['conta'],
                                    $arrVarGiftCard['tipo'],
                                    $arrVarGiftCard['empresa'],
                                    $arrVarGiftCard['valor_gift'],
                                    $dataCreated
                                    )
                                );

            if($res_log->rowCount() > 0)
            {   
                $saldo= $c_result['saldo'];
                $saldo = ($saldo - $arrVarGiftCard['valor_gift']);

                 //update conta 
                 $this->updateDB("conta", "saldo=?", "codigo_conta=?", array($saldo ,$arrVarGiftCard['conta']));
            }

        }

        public function getIssetSaldo($arrVarGiftCard)
        {
            //var_dump($arrVarGiftCard);
          

            $conta = $this->selectDB("*", "conta", "WHERE codigo_conta=?", array($arrVarGiftCard['conta']));
            $conta_result = $conta->fetch(\PDO::FETCH_ASSOC);
            $saldo=$conta_result['saldo'];

            //echo $saldo;

            if($arrVarGiftCard['valor_gift'] > $saldo) {
                return   $conta->rowCount();
            } 

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