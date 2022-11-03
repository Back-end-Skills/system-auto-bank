<?php
    $validate=new Classes\ClassValidate();

    $validate->validateFields($_POST);               //valida se todos os campos via post estão preechidos
    $validate->validateEmail($Email);                // validação do email
    $validate->validateIssetEmail($Email, "login");  // verificação se o email está no banco de dados para o login
    $validate->validateSenha($Email, $senha);        //verificação de senhas
    $validate->validateAttemptLogin();               //controle d tentativas de login do usuário

    
       
    echo $validate->validateFinalLogin($Email);      //Validação Final
    
    
