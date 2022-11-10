<?php
    $validate=new Classes\ClassValidateGift();
    
    $validate->validateFields($_POST);
    $validate->validateAgencia($_codigo_agencia);                
    $validate->validateConta($_codigo_conta);
    $validate->validateSaldoGiftCard($arrVarGiftCard);                     
       
    echo $validate->validateFinalGift($arrVarGiftCard);
    
    
