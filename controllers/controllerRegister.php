<?php
    $validate=new Classes\ClassValidate();
    
    $validate->validateFields($_POST);              
    $validate->validateEmail($Email);                // validação do email
    $validate->validateIssetEmail($Email);           // verificação se o email está ou não no banco de dados
    $validate->validateConfSenha($senha,$senhaConf); //verificação de senhas 
    $validate->validateData($_nascimento);
    
    echo $validate->validateFinalCad($arrayVar);


