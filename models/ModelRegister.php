<?php
    namespace Models;

    class ModelRegister extends ModelCrud{
         

        #Realizará a inserção no banco de dados
        public function insertCad($arrayVar){

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
                
           
        }
        
        /* Inserção de confirmação,para recuperação de senha */
        public function insConfirmation($arrayVar){

            $this->insertDB("confirmation", "?,?,?", 
                        array(
                            0,
                            $arrayVar['email'],
                            $arrayVar['token']
                        )
                    );
        
        }
        
      

        #Veriricar se já existe o mesmo email cadastro no db
        public function getIssetEmail($email){

            $b=$this->selectDB("*", "clientes", "where email=?", 
                            array($email)
                        );

            return $b->rowCount();
            
        }

       

        
    }