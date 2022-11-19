<?php
    $validate=new Classes\ClassValidate();
    
    $validate->validateFields($_POST);
    $validate->validateAgencia($_codigo_agencia);                
    $validate->validateConta($_codigo_conta);  
    $validate->validateDataExtrato($arrayVarExtrato);               
       
    echo $validate->validateFinalExtrato($arrayVarExtrato);