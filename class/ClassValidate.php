<?php
    namespace Classes;

    use Models\ModelRegister;
    use Models\ModelLogin;
    use Classes\ClassPassword;

    class ClassValidate
    {
        private $erro=[]; 
        private $cadastro;
        private $extrato_dados;
        private $login;       

        public function __construct()
        {
            $this->cadastro=new ModelRegister(); 
            $this->password=new ClassPassword();
            $this->login   =new ModelLogin(); 
            $this->extrato_dados = new ModelLogin();  
        }

        public function getErro() { return $this->erro; }

        public function setErro($erro) { array_push($this->erro,$erro); }

        #Validar se os campos desejados foram preenchidos
        public function validateFields($par){
            
            $i=0;
            foreach ($par as $key => $value){
                if(empty($value)){ $i++;  }
            }

            if($i==0){ return true; } 
            else{ $this->setErro("Preencha todos os dados!"); return false; }

        }

        public function validateEmail($par)
        {
            if(filter_var($par, FILTER_VALIDATE_EMAIL)){ return true; } 
            else{ $this->setErro("Email inválido!"); return false; }
        }

        #Validar se o email existe no banco de dados (action null para cadastro)
        public function validateIssetEmail($email, $action=null)
        {
            $b=$this->cadastro->getIssetEmail($email);
            if($action==null)
            {
                if($b > 0) { $this->setErro("Email já cadastrado!"); return false; } 
                else { return true; }
            } 
        }

        #Validação data nasciemento > 17 
        public function validateData($nascimento)
        {
            $data = new \DateTime($nascimento );           
            $idade = $data->diff( new \DateTime( date('Y-m-d')));
            $_idade = $idade->format( '%Y anos' );
 
            if($_idade > 17) { return true; } 
            else { $this->setErro("Menor de 18 anos! \n Não permitido abertura de conta"); }
        }

        public function validateAgencia($_codigo_agencia)
        {
            $res_agencia = $this->cadastro->getIssetAgencia($_codigo_agencia);
 
            if($res_agencia > 0 ) {   return true; } 
            else { $this->setErro("Agencia Inválida!\n"); return false; }
 
        } 
 
        public function validateConta($_codigo_conta)
        {
            $res_conta = $this->cadastro->getIssetConta($_codigo_conta);
 
            if($res_conta > 0 ) { return true; } 
            else { $this->setErro("Conta Inválida!\n"); return false; }
 
        } 
        
        public function validateDataExtrato($arrayVarExtrato)
        {
            if($arrayVarExtrato['data_inicial'] > $arrayVarExtrato['data_final'])
            {
                $this->setErro("Data inicial Inválida!\n");
                return false;
                
            } else {
                if($arrayVarExtrato['data_final'] > date('Y-m-d h:i:s'))
                {
                    $this->setErro("Data Final Inválida\n");
                    return false;
                } else {
                    if($arrayVarExtrato['data_final'] > $arrayVarExtrato['data_inicial']) 
                    {
                        $this->setErro("Data final não pode ser \n maior que data inicial\n");
                        return false;
                    } else {
                        return true;
                    }
                }
            } 
        }

        public function validatePassword(string $input)
        {
            $quant = strlen($input);
            $array_quant = str_split($input);         

            if(!is_numeric($input))
            {
                $this->setErro("Valores devem conter apenas dígitos!");
                return false;
            } else {
                if($quant < 6) 
                {
                    $this->setErro("Senha Inválida!\nDigite pelo menos 6 dígitos!");
                    return false;
                } else {
                
                    if(array_unique(array_diff_assoc($array_quant, array_unique($array_quant))))
                    {
                        $this->setErro("Dígitos iguais não permitido!");
                         return false;
                    } else {
                        return true;
                    }
                }
            } 
         
        }

        public function validateFinalCad($arrayVar)
        {
            if(count($this->getErro()) > 0)
            {
                $arrayResponse=[ "retorno"=>"erro", "erros"=>$this->getErro() ];
            }else{
                $arrayResponse=[ "retorno"=>"success", "erros"=>null ];
                $this->cadastro->insertCad($arrayVar);
            }
            return json_encode($arrayResponse);
        }

        public function validateFinalDeposito($arrayVarDep)
        {
            
            if(count($this->getErro()) > 0)
            {
                $arrayResponse=[ "retorno"=>"erro", "erros"=>$this->getErro() ];
            } else {
                $arrayResponse=[ "retorno"=>"success", ];   
                    
                $this->cadastro->insertDeposito($arrayVarDep);            
            }           
            return json_encode($arrayResponse);
        }

        public function  validateFinalExtrato($arrayVarExtrato)
        {
            
            if(count($this->getErro()) > 0)
            {
                $arrayResponse=[
                    "retorno"=>"erro",
                    "erros"=>$this->getErro()
                ];
            }else {
                    $arrayResponse=[
                        "retorno"=>"success",
                        "page"=>"exibir-extrato"
                                                
                    ];   
                    
                    session_start(); 
                    ob_start();                 
                      
                    $_SESSION["id_conta"]=$this->extrato_dados->getDataUser($arrayVarExtrato['conta'])['_data']['id_conta'];
                    $_SESSION["agencia"]=$this->extrato_dados->getDataUser($arrayVarExtrato['conta'])['_data']['codigo_agencia'];
                    $_SESSION["conta"]=$this->extrato_dados->getDataUser($arrayVarExtrato['conta'])['_data']['codigo_conta'];
                    $_SESSION["saldo"]=$this->extrato_dados->getDataUser($arrayVarExtrato['conta'])['_data']['saldo'];

                    // Dados das transações 
                    $_SESSION["codigo"]=$this->cadastro->getTransacao($arrayVarExtrato['conta'])['data_trans']['codigo'];
                    $_SESSION["fk_conta"]=$this->cadastro->getTransacao($arrayVarExtrato['conta'])['data_trans']['fk_conta'];
                                                 
            }           

            return json_encode($arrayResponse);
        }

        public function  validateFinalSaldo($_codigo_conta)
        {
            if(count($this->getErro()) > 0)
            {
                 $arrayResponse=[
                     "retorno"=>"erro",
                     "erros"=>$this->getErro()
                 ];
            }  else {
                     $arrayResponse=[
                         "retorno"=>"success",
                         "page"=>"saldo"
                         
                     ];
 
                     session_start(); 
                     ob_start(); 
                 
                     $_SESSION["id_conta"]=$this->login->getDataUser($_codigo_conta)['_data']['id_conta'];
                     $_SESSION["agencia"]=$this->login->getDataUser($_codigo_conta)['_data']['codigo_agencia'];
                     $_SESSION["conta"]=$this->login->getDataUser($_codigo_conta)['_data']['codigo_conta'];
                     $_SESSION["saldo"]=$this->login->getDataUser($_codigo_conta)['_data']['saldo'];
   
            } 
            return json_encode($arrayResponse);
        }

        public function validateSaldoGiftCard($arrVarGiftCard)
        {
            $res_conta = $this->cadastro->getIssetSaldo($arrVarGiftCard);
   
            if($res_conta > 0 ) { $this->setErro("Saldo Conta Insuficiente!\n"); return false; } 
            else { return true; }
        }        
       
        public function  validateFinalGift($arrVarGiftCard)
        {
            if(count($this->getErro()) > 0)
            {
                $arrayResponse=[ "retorno"=>"erro", "erros"=>$this->getErro() ]; 
            } else {
                $arrayResponse=[ "retorno"=>"success", ];  

                $this->cadastro->insertGiftCard($arrVarGiftCard);            
            }         
            return json_encode($arrayResponse);
        }
        
    }