<?php
    namespace Classes;

    use Models\ModelLogin;
    use Models\ModelRegister;

    class ClassValidateSaldo{
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
                $this->setErr("Preencha todos os dados!");
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


        #Validação final do Saldo
        public function  validateFinalSaldo($_codigo_conta)
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
                        "page"=>"saldo"
                        
                    ];

                    session_start(); // session start
                    ob_start(); // Clear buffer                  

                    //Gravando valores dentro da sessão aberta:                   
                    $_SESSION["id_conta"]=$this->login->getDataUser($_codigo_conta)['_data']['id_conta'];
                    $_SESSION["agencia"]=$this->login->getDataUser($_codigo_conta)['_data']['codigo_agencia'];
                    $_SESSION["conta"]=$this->login->getDataUser($_codigo_conta)['_data']['codigo_conta'];
                    $_SESSION["saldo"]=$this->login->getDataUser($_codigo_conta)['_data']['saldo'];

                

                
            } 

            //gravar log
            //$this->cadastro_db->isLogLogin($_codigo_conta);

            return json_encode($arrayResponse);
        }
    }