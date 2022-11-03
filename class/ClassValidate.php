<?php
    namespace Classes;

    use Models\ModelRegister;
    use Models\ModelLogin;
    use Classes\ClassPassword;

   
    class ClassValidate{

        private $erro=[]; 
        private $cadastro;
        private $password;
        private $login;       
        private $tentativas;
        private $session;
       
        //composições
        public function __construct()
        {
            $this->cadastro=new ModelRegister(); 
            $this->password=new ClassPassword();
            $this->login   =new ModelLogin();   
         
        }

        public function getErro(){   return $this->erro;  }
        public function setErro($erro){  array_push($this->erro,$erro);  }

        #Validar se os campos desejados foram preenchidos
        public function validateFields($par){
            
            $i=0;
            foreach ($par as $key => $value){
                if(empty($value)){ $i++;  }
            }

            if($i==0){  
                return true;  
            } else{ 
                $this->setErro("Preencha todos os dados!"); 
                return false;  
            }

        }

        #Validação se o dado é um email
        public function validateEmail($par){
            
            if(filter_var($par, FILTER_VALIDATE_EMAIL)){ 
                return true;  
            } else{ 
                $this->setErro("Email inválido!"); 
                return false;     
            }
        
        }

        #Validar se o email existe no banco de dados (action null para cadastro)
        public function validateIssetEmail($email, $action=null){

            $b=$this->cadastro->getIssetEmail($email);

            if($action==null){

                if($b > 0){ $this->setErro("Email já cadastrado!"); return false; }
                else{ return true; }
            
            } else { //login 
                
                if($b > 0){ return true;  }
                else{$this->setErro("Email não cadastrado!"); return false; }
            }
        
        }


        #Verificar se a senha é igual a confirmação de senha
        public function validateConfSenha($senha,$senhaConf){

            if($senha === $senhaConf){   
                return true;  
            } else {   
                $this->setErro("Senha diferente de confirmação de senha!");  
            }

        }

        #Verificação da senha digitada com o hash no banco de dados
        public function validateSenha($email,$senha)
        {
            if($this->password->verifyHash($email,$senha)){   return true;  }
            else{  $this->setErro("Usuário ou Senha Inválidos!");  return false;  }
        
        }

        #Validação final do cadastro
        public function validateFinalCad($arrayVar)
        {
            if(count($this->getErro()) > 0){
                $arrayResponse=[ 
                    "retorno"=>"erro",
                    "erros"=>$this->getErro()
                ];
            }else{
                $arrayResponse=[
                    "retorno"=>"success",
                    "erros"=>null
                ];
                $this->cadastro->insertCad($arrayVar);
            }
            return json_encode($arrayResponse);
        }
        
      

        #Validação final do login
        public function validateFinalLogin($email)
        {
            if(count($this->getErro()) >0)
            {
                $this->login->insertAttempt();

                $arrayResponse=[
                    "retorno"=>"erro",
                    "erros"=>$this->getErro(),
                    "tentativas"=>$this->tentativas
                ];
            }else {
               
                    $this->login->deleteAttempt();
                    $this->session->setSessions($email);
                  
                    $arrayResponse=[
                        "retorno"=>"success",
                        "page"=>"home",
                        "tentativas"=>$this->tentativas
                    ];
                
            } 
            return json_encode($arrayResponse);
        }

      



    }