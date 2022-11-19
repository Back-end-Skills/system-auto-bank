<?php
    namespace Models;

    class ModelRegister extends ModelCrud
    {
        private int $codigo_agencia;
        private int $codigo_conta;
        private int $saldo=0;

        public function dataNow()
        {
            return date('Y-m-d H:i:s', time());
           
        }
       
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
        public function insConta($arrayVar)
        {
            $this->codigo_agencia = rand(3,100);
            $this->codigo_conta = rand(100000,999999);

            $this->insertDB("conta", "?,?,?,?,?,?", 
                        array(
                            0,
                            $arrayVar['cpf'],
                            $this->codigo_agencia,
                            $this->codigo_conta,
                            $this->saldo,
                            $this->dataNow()
                        )
                    );
        
        }

        public function insLog($arrayVar)
        {
            $query_transacao=$this->selectDB("*", "transacao", "ORDER BY codigo DESC",array());

            if($result =  $query_transacao->fetch(\PDO::FETCH_ASSOC))
            {
                $codigo_transacao = $result['codigo'];

                $this->insertDB("log", "?,?,?,?,?,?,?,?",
                            array(
                                0,
                                $codigo_transacao,
                                $this->codigo_agencia,
                                $this->codigo_conta,
                                "0",
                                "0",
                                $this->saldo,
                                $this->dataNow()
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

                $this->insertDB("transacao", "?,?,?,?,?", array( 0, $id_conta, "abertura de conta corrente", "0",  $this->dataNow()));
            } else  {
                return false; 
            }

        }

        public function getConta($conta)
        {
            return $this->selectDB( "*", "conta", "WHERE codigo_conta=?", array($conta));
              
        }       

        #Compra de GIFT CARD
        public function insertGiftCard($arrVarGiftCard)
        {
            
            // $conta = $this->selectDB("*", "conta", "WHERE codigo_conta=?", array($arrVarGiftCard['conta']));
            $conta = $this->getConta($arrVarGiftCard['conta']);
            $c_result = $conta->fetch(\PDO::FETCH_ASSOC);
            $id_conta=$c_result['id_conta'];                   
 
            $res=$this->insertDB("transacao", "?,?,?,?,?", array(0, $id_conta, 'compra de gift card', 'debito', $this->dataNow()));
            
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
                                        $this->dataNow()
                                    )
                                );

            if($res_log->rowCount() > 0)
            {   
                $saldo= $c_result['saldo'];
                $saldo = ($saldo - $arrVarGiftCard['valor_gift']);

                $this->updateDB("conta", "saldo=?", "codigo_conta=?", array($saldo ,$arrVarGiftCard['conta']));
            }

        }

        public function getSaldo($arr)
        {

            // $conta = $this->selectDB("*", "conta", "WHERE codigo_conta=?", array($arr['conta']));
            $conta = $this->getConta($arr['conta']);

            if($conta_result = $conta->fetch(\PDO::FETCH_ASSOC))
            {                
                if($conta_result['saldo'] >= $arr['valor_transferencia'])
                {
                    return $conta->rowCount();                
                } 
            } else {
                false;
            }
        }

        // Verificar se existe saldo para comprar de giftCard
        public function getIssetSaldo($arrVarGiftCard)
        {       
           
            // $conta = $this->selectDB("*", "conta", "WHERE codigo_conta=?", array($arrVarGiftCard['conta']));
            $conta = $this->getConta($arrVarGiftCard['conta']);
            $conta_result = $conta->fetch(\PDO::FETCH_ASSOC);
                
            if($conta_result)
            {
                $saldo=$conta_result['saldo'];
            } else {
                $saldo="";
            }

            if($arrVarGiftCard['valor_gift'] > $saldo) 
            {
                return   $conta->rowCount();
            } 

        }
        
        public function getIssetEmail($email)
        {

            $b=$this->selectDB("*", "clientes", "where email=?", array($email));
            return $b->rowCount();
            
        }
      
        #Veriricar se existe agencia
        public function getIssetAgencia(string $_codigo_agencia)
        {

            $b=$this->selectDB("*", "conta", "where codigo_agencia=?", array($_codigo_agencia));
                        
            return $b->rowCount();
            
        }

        #Veriricar se existe Conta
        public function getIssetConta(string $_codigo_conta)
        {
            // $b=$this->selectDB("*", "conta", "where codigo_conta=?", array($_codigo_conta));
            $res=$this->getConta($_codigo_conta);

            return $res->rowCount();   
        }

        #Grava log de login
        public function isLogLogin($_codigo_conta)
        {
            // $query=$this->selectDB("*", "conta", "where codigo_conta=?", array($_codigo_conta));
            $query=$this->getConta($_codigo_conta);
            $f = $query->fetch(\PDO::FETCH_ASSOC);
            $id_conta = $f['id_conta'];

            $res=$this->insertDB("transacao", "?,?,?,?,?", array(0, $id_conta, 'login nova sessão', '0', $this->dataNow()));
            
            $res_select_transacao = $this->selectDB("*", "transacao", "where fk_conta=? ORDER BY codigo DESC LIMIT 1 ", array($id_conta));
            $trans_result =  $res_select_transacao->fetch(\PDO::FETCH_ASSOC);
            $codigo_transacao=$trans_result['codigo'];

            $this->insertDB("log", "?,?,?,?,?,?,?,?",
                        array(0, $codigo_transacao, $f['codigo_agencia'], $f['codigo_conta'], "0", "0", 0, $this->dataNow()));
            
        }

        // Pega as transações do cliente
        public function getTransacao($arrTrans)
        {
            // $b=$this->selectDB("*", "conta","where codigo_conta=?", array($arrTrans));
            $b=$this->getConta($arrTrans);            
            $f=$b->fetch(\PDO::FETCH_ASSOC);       
            $id_conta = $f['id_conta'];  
                
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

        #Realizar deposito
        public function insertDeposito($arrayVarDep)
        {   
            // $conta = $this->selectDB("*", "conta", "WHERE codigo_conta=?", array($arrayVarDep['conta']));
            $conta = $this->getConta($arrayVarDep['conta']);
            
            if($c_result = $conta->fetch(\PDO::FETCH_ASSOC))
            {
            
                $id_conta=$c_result['id_conta'];

                $res=$this->insertDB("transacao", "?,?,?,?,?",
                                array( 0, $id_conta, 'deposito em conta corrente', 'credito', $this->dataNow()));

                if($res->rowCount() > 0)
                {   
                           
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
                                    $this->dataNow()
                                )
                            );
            
                    $saldo= $c_result['saldo'];
                    $saldo = ($saldo + $arrayVarDep['valor_deposito']);
                           
                    $this->updateDB("conta", "saldo=?", "codigo_conta=?", array($saldo ,$arrayVarDep['conta']));
                            
                }
            }
                
        }

        public function insertDebito($arr)
        {
            // $conta_origem = $this->selectDB("*", "conta", "WHERE codigo_conta=?", array($arr['conta']));
            $conta_origem=$this->getConta($arr['conta']);
            $result_conta_origem = $conta_origem->fetch(\PDO::FETCH_ASSOC);
            $id_conta_origem = $result_conta_origem['id_conta'];

            $res=$this->insertDB("transacao", "?,?,?,?,?",
                            array( 0, $id_conta_origem, 'transferencia enviada', 'debito', $this->dataNow()));

            if($res->rowCount() > 0)
            {   
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
                                $this->dataNow()
                            )
                        );

                $saldo= $result_conta_origem['saldo'];
                $saldo = ($saldo - $arr['valor_transferencia']);

                //update conta origem
                $this->updateDB("conta", "saldo=?", "codigo_conta=?", array($saldo , $arr['conta'])); 
            }

        }

        #Realizará deposito na conta de destino
        public function insertTransf($arrayVarTransf)
        {
            // $conta_destino = $this->selectDB("*", "conta", "WHERE codigo_conta=?", array($arrayVarTransf['conta_destino']));
            $conta_destino = $this->getConta($arrayVarTransf['conta_destino']);
            $result_conta = $conta_destino->fetch(\PDO::FETCH_ASSOC);
            $id_conta_destino = $result_conta['id_conta'];

            $res=$this->insertDB("transacao", "?,?,?,?,?",
                            array( 0, $id_conta_destino, 'transferencia recebida', 'credito', $this->dataNow()));

            if($res->rowCount() > 0)
            {   
             
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
                                $this->dataNow()
                            )
                        );

                $saldo= $result_conta['saldo'];
                $saldo = ($saldo + $arrayVarTransf['valor_transferencia']);
           
                $this->updateDB("conta", "saldo=?", "codigo_conta=?", array($saldo , $arrayVarTransf['conta_destino']));

                $this->insertDebito($arrayVarTransf);                    
            }       
        }
    
    }