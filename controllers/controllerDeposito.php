<?php
    $_validate=new Classes\ClassValidate();
    
    $_validate->validateFields($_POST);
    $_validate->validateAgencia($_codigo_agencia);                
    $_validate->validateConta($_codigo_conta);                      
       
    echo $_validate->validateFinalDeposito($arrayVarDep);
    
    
