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
       
        //composições
        public function __construct()
        {
            $this->cadastro=new ModelRegister(); 
            $this->password=new ClassPassword();
            $this->login   =new ModelLogin();   
         
        }

        public function getErro()
        {   
            return $this->erro;  
        }

        public function setErro($erro)
        {  
            array_push($this->erro,$erro);  
        }

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

                if($b > 0)
                { 
                    $this->setErro("Email já cadastrado!");
                    return false; 
                } else { 
                    return true; 
                }

            
            } 
            else { //login 
                
            //     if($b > 0){ return true;  }
            //     else{$this->setErro("Email não cadastrado!"); return false; }
            // 
        }
        
        }

        #Validação data nasciemento > 17 
        public function validateData($nascimento)
        {
    
            $data = new \DateTime($nascimento );
           
            $idade = $data->diff( new \DateTime( date('Y-m-d')));
            //var_dump($idade);
            $_idade = $idade->format( '%Y anos' );
 
            if($_idade > 17) 
            {
                return true;
            } else {
                $this->setErro("Menor de 18 anos! \n Não permitido abertura de conta");
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
                    $this->setErro("Digite pelo menos 6 dígitos!");
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

        #Validação final do cadastro
        public function validateFinalCad($arrayVar)
        {
            if(count($this->getErro()) > 0)
            {
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
        

      

      



    }