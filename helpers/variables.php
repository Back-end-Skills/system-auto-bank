<?php
    
    $objPass=new \Classes\ClassPassword();
    
    if(isset($_POST['nome']))
    {
        $Nome=filter_input(INPUT_POST,'nome',FILTER_SANITIZE_SPECIAL_CHARS);
    } else { 
        $Nome="";
    }
  
    if(isset($_POST['email']))
    { 
        $Email=filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL); 
    } else { 
        $Email=""; 
    }

    if(isset($_POST['nascimento']))
    { 
        $_nascimento=filter_input(INPUT_POST,'nascimento',FILTER_SANITIZE_SPECIAL_CHARS); 
    }
    else{ $_nascimento=0; }

    if(isset($_POST['cpf']))
    { 
        $_cpf=filter_input(INPUT_POST,'cpf',FILTER_SANITIZE_SPECIAL_CHARS); 
    } else { 
        $_cpf=0; 
    }
 
    if(isset($_POST['senha']))
    {  
        $senha=$_POST['senha'];  $hashSenha=$objPass->passwordHash($senha);  
    } else {  
        $senha=null; $hashSenha=null;   
    }


    // if(isset($_POST['senhaConf'])){  
    //     $senhaConf=$_POST['senhaConf'];  
    // } else { 
    //     $senhaConf=null;  
    // }
 
    //Esqueci minha senha - Recuperação db account e db confimation
    $token=bin2hex(random_bytes(64));
    if(isset($_POST['token']))
    {   
        $token=$_POST['token'];    
    } else { 
        $token=bin2hex(random_bytes(64));  
    }

    // Array dos POST e GET
    $arrayVar=[
        "nome"=>$Nome,
        "nascimento"=>$_nascimento,
        "cpf"=> $_cpf,
        "email"=>$Email,
        "senha"=>$senha,
        "hashSenha"=>$hashSenha
    ];
    
    // var_dump($arrayVar);

    if(isset($_POST['codigo_agencia']))
    { 
        $_codigo_agencia=filter_input(INPUT_POST,'codigo_agencia',FILTER_SANITIZE_SPECIAL_CHARS); 
    } else { 
        $_codigo_agencia=""; 
    }

    if(isset($_POST['codigo_conta']))
    { $_codigo_conta=filter_input(INPUT_POST,'codigo_conta',FILTER_SANITIZE_SPECIAL_CHARS); 
    } else { 
        $_codigo_conta=""; 
    }


    $arrayVarLogin = [
        "agencia"=>$_codigo_agencia,
        "conta"=>$_codigo_conta,
        "senha"=>$senha,
        "hashSenha"=>$hashSenha
    ];

    if(isset($_POST['valor_deposito']))
    { 
        $_valor_deposito=filter_input(INPUT_POST,'valor_deposito',FILTER_SANITIZE_SPECIAL_CHARS); 
    } else { 
        $_valor_deposito=""; 
    }

    $arrayVarDep = [
        "agencia"=>$_codigo_agencia,
        "conta"=>$_codigo_conta,
        "valor_deposito"=>$_valor_deposito
    ];

    if(isset($_POST['valor_gift']))
    { 
        $_valor_gift=filter_input(INPUT_POST,'valor_gift',FILTER_SANITIZE_SPECIAL_CHARS); 
    } else { 
        $_valor_gift=""; 
    }

    
    if(isset($_POST['tipo']))
    { 
        $_tipo=filter_input(INPUT_POST,'tipo',FILTER_SANITIZE_SPECIAL_CHARS); 
    } else { 
        $_tipo=""; 
    }

    if(isset($_POST['stream']))
    { 
        $_stream=filter_input(INPUT_POST,'stream',FILTER_SANITIZE_SPECIAL_CHARS); 
    } else { 
        $_stream=""; 
    }

    if(isset($_POST['recarga']))
    { 
        $_recarga=filter_input(INPUT_POST,'recarga',FILTER_SANITIZE_SPECIAL_CHARS); 
    } else { 
        $_recarga=""; 
    }

    if(isset($_POST['empresa']))
    { 
        $_empresa=filter_input(INPUT_POST,'empresa',FILTER_SANITIZE_SPECIAL_CHARS); 
    } else { 
        $_empresa=""; 
    }

    $arrVarGiftCard = [
        "agencia"=>$_codigo_agencia,
        "conta"=>$_codigo_conta,
        "tipo"=>$_tipo,
        "empresa"=>$_empresa,
        "valor_gift"=>$_valor_gift
    ];

    //var_dump($arrVarGiftCard);
    