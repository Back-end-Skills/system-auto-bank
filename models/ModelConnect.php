<?php
    namespace Models;

    abstract class ModelConnect{

        protected function conectaDB(){

            try{

                $con=new \PDO("mysql:host=".HOST.";dbname=".DB."; charset=utf8","".USER."","".PASS."");
                
                return $con;

            }catch (\PDOException $erro){

                return $erro->getMessage();

            }
        }
    }