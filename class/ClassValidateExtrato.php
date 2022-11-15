<?php
    namespace Classes;

    use Models\ModelLogin;
    use Models\ModelRegister;

    class ClassValidateExtrato
    {
        private array $err = [];
        private $cadastro_db;
        private $extrato_dados;
        
        public function __construct(){
            $this->extrato_dados = new ModelLogin();
            $this->password=new ClassPassword();
            $this->cadastro_db=new ModelRegister();

        }

        public function getErr(){
            return $this->err;
        }
        public function setErr($erro){
            array_push($this->err, $erro);
        }

        public function validateFields($par)
        {
            $i=0;
            foreach ($par as $key => $value)
            {
                if(empty($value)){
                    $i++;
                }
            }
            if($i==0){
                return true;
            } else {
                $this->setErr("Preencha todos os dados\n");
                return false;
            }
        }
        
        #validacao agencia
        public function validateAgencia($_codigo_agencia)
        {
            $res_agencia = $this->cadastro_db->getIssetAgencia($_codigo_agencia);

            if($res_agencia > 0 )
            {
               return true; 
            } else {
                $this->setErr("Agencia Inválida!\n");
                return false; 
            }

        } 

        #validação conta
        public function validateConta($_codigo_conta)
        {
            $res_conta = $this->cadastro_db->getIssetConta($_codigo_conta);

            if($res_conta > 0 )
            {
               return true;
            } else {
                $this->setErr("Conta Inválida!\n");
                return false; 
                
            }

        }    

        #Validação final da transferencia
        public function  validateFinalExtrato($arrayVarExtrato)
        {
            
          
            if(count($this->getErr()) > 0)
            {
                $arrayResponse=[
                    "retorno"=>"erro",
                    "erros"=>$this->getErr()
                ];

               
            }else {
                    $arrayResponse=[
                        "retorno"=>"success",
                        "page"=>"exibir-extrato"
                                                
                    ];   
                    
                    session_start(); 
                    ob_start(); // Clear buffer                  

                      
                    $_SESSION["id_conta"]=$this->extrato_dados->getDataUser($arrayVarExtrato['conta'])['_data']['id_conta'];
                    $_SESSION["agencia"]=$this->extrato_dados->getDataUser($arrayVarExtrato['conta'])['_data']['codigo_agencia'];
                    $_SESSION["conta"]=$this->extrato_dados->getDataUser($arrayVarExtrato['conta'])['_data']['codigo_conta'];
                    $_SESSION["saldo"]=$this->extrato_dados->getDataUser($arrayVarExtrato['conta'])['_data']['saldo'];

                    // Dados das transações 
                    $_SESSION["codigo"]=$this->cadastro_db->getTransacao($arrayVarExtrato['conta'])['data_trans']['codigo'];
                    $_SESSION["fk_conta"]=$this->cadastro_db->getTransacao($arrayVarExtrato['conta'])['data_trans']['fk_conta'];
                                              

                             
            }           

            return json_encode($arrayResponse);
        }
    }