<?php
    $validate=new Classes\ClassValidateDeposito();
    
    $validate->validateFields($_POST);
    $validate->validateAgencia($_codigo_agencia);                
    $validate->validateConta($_codigo_conta);                      
       
    echo $validate->validateFinalDeposito($arrayVarDep);
    
    
