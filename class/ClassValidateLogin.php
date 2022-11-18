<?php
    namespace Classes;

    use Models\ModelLogin;
    use Models\ModelRegister;

    class ClassValidateLogin
    {
        private array $err = [];
        private $password;
        private $cadastro_db;
        
        public function __construct()
        {
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
        
        public function validateAgencia(string $agencia)
        {
            $res = $this->cadastro_db->getIssetAgencia($agencia);
            
            if($res > 0)
            {
                return true;
            } else {
                $this->setErr("Agência Inexistente!\n");
                return false;
            }
        }

        public function validateConta(string $conta)
        {
            $res = $this->cadastro_db->getIssetConta($conta);
            
            if($res > 0)
            {
                return true;
            } else {
                $this->setErr("Conta Inexistente!\n");
                return false;
            }
        }

        public function validateSenhaoof($_codigo_conta, $senha)
        {
            //echo  $_codigo_conta ."-----".$senha . "<br>";
            //var_dump($this->password->verifyHash($_codigo_conta, $senha));

            if($this->password->verifyHash($_codigo_conta, $senha))
            {   
                return true;  
            } else {  
                $this->setErr("Senha Inválida!\n");  
                return false; 
            }
           
        }

        public function validateSenha($_codigo_conta,$senha)
        {
            $res = $this->cadastro_db->getIssetConta($_codigo_conta);
            
            if($res > 0)
            {
                if($this->password->verifyHash($_codigo_conta,$senha))
                {   
                    return true;  
                } else {  
                    $this->setErr("Senha Inválida!\n");  
                    return false; 
                }

            } else {
                $this->setErr("Conta Inexistente!\n");
                return false;
            }
        
            //echo  $_codigo_conta ."-----".$senha . "<br>";
            //var_dump($this->password->verifyHash($_codigo_conta, $senha));

            // if($this->password->verifyHash($_codigo_conta,$senha))
            // {   
            //     return true;  
            // } else {  
            //     $this->setErr("Senha Inválida!\n");  
            //     return false; 
            // }
           
        }

        public function validateFinalLogin($_codigo_conta)
        {

            if(count($this->getErr()) > 0)
            {
                $arrayResponse=[
                    "retorno"=>"erro",
                    "erros"=>$this->getErr()
                ];
            } else {
                    $arrayResponse=[
                        "retorno"=>"success",
                        "page"=>"home"
                        
                    ];
                       
                $this->cadastro_db->isLogLogin($_codigo_conta);
            } 

            return json_encode($arrayResponse);
        }
        
    }