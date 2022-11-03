<?php
    namespace Models;

    use Traits\TraitGetIp;

    class ModelLogin extends ModelCrud{

        private $trait;
        private $dateNow;

        public function __construct(){

            $this->trait=TraitGetIp::getUserIp();
            $this->dateNow=date("Y-m-d H:i:s");

        }        

        #Retorna os dados do usuário
        public function getDataUser($email){

            $b=$this->selectDB("*", "account","where email=?", array($email));
            $f=$b->fetch(\PDO::FETCH_ASSOC);
            $r=$b->rowCount();
            
            return $arrayData=[ 
                                "data"=>$f, 
                                "rows"=>$r
                              ];           
        }

        #Conta as tentativas de login e efetuar o bloqueio.
        public function countAttempt(){

            $b=$this->selectDB("*", "attempt", "where ip=?",array($this->trait));
            $r=0;
            
            while($f=$b->fetch(\PDO::FETCH_ASSOC)){

                //tempo de bloqueio em segundos
                if(strtotime($f["date"]) > strtotime($this->dateNow) - 10){  $r++;   }
            }
            return $r;
        }

        #INSERE AS TENTATIVAS DE LOGIN NO DB 
        public function insertAttempt(){

            if($this->countAttempt() < 5)
            {
                $this->insertDB("attempt", "?,?,?", 
                            array(
                                0, 
                                $this->trait, 
                                $this->dateNow
                            )
                        );
            }
        }

        #Deleta as tentativas do DB
        public function deleteAttempt(){
            
            $this->deleteDB("attempt", "ip=?", array($this->trait));
        }

    }