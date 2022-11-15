<?php
    namespace Models;

    class ModelRegister extends ModelCrud
    {
        private int $codigo_agencia;
        private int $codigo_conta;
        private int $saldo=0;
       
        public function insertCad($arrayVar)
        {
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
            $this->insTransacao($arrayVar);
            $this->insLog($arrayVar);
                
        }
        
        #Cria a conta e agencia
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

        #log
        public function insLog($arrayVar)
        {
            $query_transacao=$this->selectDB("*", "transacao", "ORDER BY codigo DESC",array());

            if($result =  $query_transacao->fetch(\PDO::FETCH_ASSOC))
            {
                $codigo_transacao = $result['codigo'];
                $dataCreatedAd=date('Y-m-d H:i:s', time());

                $this->insertDB(
                    "log",
                    "?,?,?,?,?,?,?,?",
                    array(
                        0,
                        $codigo_transacao,
                        $this->codigo_agencia,
                        $this->codigo_conta,
                        "0",
                        "0",
                        $this->saldo,
                        $dataCreatedAd
                    )

                );
            }
            
           
        }

        #Transacao para gravaçaõ de log da criação da conta
        public function insTransacao($arrayVar)
        {
            $query_conta=$this->selectDB("*", "conta", "ORDER BY id_conta DESC",array());

            if($result=$query_conta->fetch(\PDO::FETCH_ASSOC))
            {
                $id_conta = $result['id_conta'];
                $dataCreatedAd=date('Y-m-d H:i:s', time());

                $this->insertDB("transacao", "?,?,?,?,?",
                            array(
                                0,
                                $id_conta,
                                "abetura de conta corrente",
                                "0",
                                $dataCreatedAd
                            )
                        );
            } else  {
                return false; 
            }

            
           
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

        public function getSaldo($arr)
        {
            //var_dump($arrVarGiftCard);        
           
            $conta = $this->selectDB("*", "conta", "WHERE codigo_conta=?", array($arr['conta']));
            if($conta_result = $conta->fetch(\PDO::FETCH_ASSOC))
            {                
                if($conta_result['saldo'] >= $arr['valor_transferencia']){
                    return $conta->rowCount();                
                } 
            } else {
                    false;
            }
        }

        public function getIssetSaldo($arrVarGiftCard)
        {
            //var_dump($arrVarGiftCard);        
           
            $conta = $this->selectDB("*", "conta", "WHERE codigo_conta=?", array($arrVarGiftCard['conta']));
            $conta_result = $conta->fetch(\PDO::FETCH_ASSOC);
                
            if($conta_result){
                $saldo=$conta_result['saldo'];
            } else {
                $saldo="";
            }
         
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
        public function isLogLogin($_codigo_conta)
        {
            $dataCreated=date('Y-m-d H:i:s', time());
         
            $query=$this->selectDB("*", "conta", "where codigo_conta=?", array($_codigo_conta));
            $f = $query->fetch(\PDO::FETCH_ASSOC);
            $id_conta = $f['id_conta'];

            $res=$this->insertDB("transacao", "?,?,?,?,?", array(0, $id_conta, 'login nova sessão', '0', $dataCreated));
            
            $res_select_transacao = $this->selectDB("*", "transacao", "where fk_conta=? ORDER BY codigo DESC LIMIT 1 ", array($id_conta));
            $trans_result =  $res_select_transacao->fetch(\PDO::FETCH_ASSOC);
            $codigo_transacao=$trans_result['codigo'];

          

            $this->insertDB(
                "log",
                "?,?,?,?,?,?,?,?",
                array(
                    0,
                    $codigo_transacao,
                    $f['codigo_agencia'],
                    $f['codigo_conta'],
                    "0",
                    "0",
                    0,
                    $dataCreated
                )
            );
            
        }

        public function getTransacao($arrTrans)
        {
            $b=$this->selectDB("*", "conta","where codigo_conta=?", array($arrTrans));
            
            $f=$b->fetch(\PDO::FETCH_ASSOC);            
            //$r=$b->rowCount();

            $id_conta = $f['id_conta'];  
                    
            //var_dump($arrTrans);
            $transacao=$this->selectDB("*", "transacao", "where fk_conta=?", array($id_conta));
            
            if($result = $transacao->fetch(\PDO::FETCH_ASSOC))
            {
                return $arrTrans = [
                    "data_trans"=>$result
                ];
            } else {
                return false;
            }
            
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
             
                $this->insertDB("log", "?,?,?,?,?,?,?,?",  
                        array(
                            0,
                            $codigo_transacao,
                            $arrayVarDep['agencia'],
                            $arrayVarDep['conta'],
                            "0",
                            "0",
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

        public function insertDebito($arr){
               //Select db conta

               //return  var_dump($arr);
                  //Select db conta
            $conta_origem = $this->selectDB("*", "conta", "WHERE codigo_conta=?", array($arr['conta']));
            $result_conta_origem = $conta_origem->fetch(\PDO::FETCH_ASSOC);
            $id_conta_origem = $result_conta_origem['id_conta'];

            $dataCreated=date('Y-m-d H:i:s', time());

            $res=$this->insertDB("transacao", "?,?,?,?,?",
                        array(
                            0,
                            $id_conta_origem,
                            'transferencia enviada',
                            'debito',
                            $dataCreated                                                                      
                        )
                    );

            if($res->rowCount() > 0)
            {   
                //select db transacao
                $transacao=$this->selectDB("*", "transacao", "where fk_conta=? ORDER BY codigo DESC LIMIT 1", array($id_conta_origem));
                $result = $transacao->fetch(\PDO::FETCH_ASSOC);
                $codigo_transacao = $result['codigo'];
             
                $this->insertDB("log", "?,?,?,?,?,?,?,?",  
                        array(
                            0,
                            $codigo_transacao,
                            $arr['agencia'],
                            $arr['conta'],
                            "0",
                            "0",
                            $arr['valor_transferencia'],
                            $dataCreated
                        )
                    );

                $saldo= $result_conta_origem['saldo'];
                $saldo = ($saldo - $arr['valor_transferencia']);

                //update conta origem
                $this->updateDB("conta", "saldo=?", "codigo_conta=?", array($saldo , $arr['conta'])); 
            }



        }

        #Realizará deposito na conta de destino
        public function insertTransf($arrayVarTransf){

            //Select db conta
            $conta_destino = $this->selectDB("*", "conta", "WHERE codigo_conta=?", array($arrayVarTransf['conta_destino']));
            $result_conta = $conta_destino->fetch(\PDO::FETCH_ASSOC);
            $id_conta_destino = $result_conta['id_conta'];

            $dataCreated=date('Y-m-d H:i:s', time());

            $res=$this->insertDB("transacao", "?,?,?,?,?",
                        array(
                            0,
                            $id_conta_destino,
                            'transferencia recebida',
                            'credito',
                            $dataCreated                                                                      
                        )
                    );

            if($res->rowCount() > 0)
            {   
                //select db transacao
                $transacao=$this->selectDB("*", "transacao", "where fk_conta=? ORDER BY codigo DESC LIMIT 1 ", array($id_conta_destino));
                $result = $transacao->fetch(\PDO::FETCH_ASSOC);
                $codigo_transacao = $result['codigo'];
             
                $this->insertDB("log", "?,?,?,?,?,?,?,?",  
                        array(
                            0,
                            $codigo_transacao,
                            $arrayVarTransf['agencia_destino'],
                            $arrayVarTransf['conta_destino'],
                            "0",
                            "0",
                            $arrayVarTransf['valor_transferencia'],
                            $dataCreated
                        )
                    );

                $saldo= $result_conta['saldo'];
                $saldo = ($saldo + $arrayVarTransf['valor_transferencia']);

                //update conta destino
                $this->updateDB("conta", "saldo=?", "codigo_conta=?", array($saldo , $arrayVarTransf['conta_destino']));

                $this->insertDebito($arrayVarTransf);
                 
                
            }
                
        }

       

        
    }