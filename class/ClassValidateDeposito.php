<?php
    namespace Classes;

    use Models\ModelLogin;
    use Models\ModelRegister;

    class ClassValidateDeposito{
        private array $err = [];
        private $cadastro_db;
        
        public function __construct(){
            $this->login = new ModelLogin();
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
                $this->setErr("Agencia Inválida\n");
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


        #Validação final do Saldo
        public function  validateFinalDeposito($arrayVarDep)
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
                                                
                    ];   
                    
                    //gravar depósito
                    $this->cadastro_db->insertDeposito($arrayVarDep);            
            }           

            return json_encode($arrayResponse);
        }
    }