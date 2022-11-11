<?php
    $validate=new Classes\ClassValidateTransferencia();
    $validate_saldo=new Classes\ClassValidateSaldo();
    
    $validate->validateFields($_POST);
    $validate->validateAgencia($_codigo_agencia);                
    $validate->validateConta($_codigo_conta); 
    $validate_saldo->validateFinalSaldo($_codigo_conta);
    
    $validate->validateAgenciaDestino($_codigo_agencia_destino);                
    $validate->validateContaDestino($_codigo_conta_destino);                      
       
    echo $validate->validateFinalTransf($arrayVarTransf);
    
    
