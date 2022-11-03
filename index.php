<?php
       
    header("Content-Type: text/html; charset=utf-8"); 
    date_default_timezone_set("America/Belem");       
    //error_reporting(0);            

    include "Core/composer/vendor/autoload.php";   
    include "helpers/variables.php";               
      
    $dispatch = new Classes\ClassDispatch(); 
    include ($dispatch ->getInclusao());       
     
    


