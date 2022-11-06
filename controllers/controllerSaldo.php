<?php
    $validate=new Classes\ClassValidateSaldo();
    
    $validate->validateFields($_POST);
    $validate->validateAgencia($_codigo_agencia);                
    $validate->validateConta($_codigo_conta);   
    
    echo $validate->validateFinalSaldo($_codigo_conta);