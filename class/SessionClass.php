<?php
    namespace Classes;


    class SessionClass{

        public function __construct()
        {
                session_start(); 
                ob_start(); 
        }

    

    }