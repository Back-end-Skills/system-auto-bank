<?php
    namespace Classes;

    use Models\ModelLogin;

    class ClassPassword{

        private $db;

        public function __construct(){

            $this->db=new ModelLogin();
            
        }

        #Criar o hash da senha para salvar no banco de dados
        public function passwordHash($senha){

            return password_hash($senha, PASSWORD_DEFAULT);
            
        }

        #Verificar se o hash da senha está correto
        public function verifyHash($_codigo_conta, $senha)
        {
            //echo "<br>" . $_codigo_conta."-". $senha;
            $hashDb=$this->db->getDataUser($_codigo_conta);
            //echo "<br>";
            //var_dump($hashDb);
            //if($hashDb) 
            //{
                return password_verify($senha, $hashDb["data"]["senha"]);
            //}
           
        }

    }
