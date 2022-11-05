<?php
    $validate=new Classes\ClassValidateLogin();
    
    $validate->validateFields($_POST);
    $validate->validateAgencia($_codigo_agencia);                
    $validate->validateConta($_codigo_conta);               
    $validate->validateSenha($_codigo_conta,$senha);        
       
    echo $validate->validateFinalLogin($_codigo_conta);
    
    
