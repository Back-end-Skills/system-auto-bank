<?php
    $validate=new Classes\ClassValidateExtrato();
    
    $validate->validateFields($_POST);
    $validate->validateAgencia($_codigo_agencia);                
    $validate->validateConta($_codigo_conta);                     
       
    echo $validate->validateFinalExtrato($arrayVarExtrato);