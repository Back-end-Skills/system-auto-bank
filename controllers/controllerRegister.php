<?php
    $validate=new Classes\ClassValidate();
    
    $validate->validateFields($_POST);              
    $validate->validateEmail($Email);                
    $validate->validateIssetEmail($Email);           
    $validate->validateData($_nascimento);
    $validate->validatePassword($senha);
    
    echo $validate->validateFinalCad($arrayVar);


