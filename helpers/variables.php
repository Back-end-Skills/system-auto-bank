<?php
    
    $objPass=new \Classes\ClassPassword();
    $filter = new \Classes\ClassAuxilia();

    if(isset($_POST['id'])){ $Id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_SPECIAL_CHARS); }
    elseif(isset($_GET['id'])){ $Id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_SPECIAL_CHARS); }
    else{ $Id=0; }
    
    if(isset($_POST['nome'])){$Nome=filter_input(INPUT_POST,'nome',FILTER_SANITIZE_SPECIAL_CHARS);}
    elseif(isset($_GET['nome'])){$Nome=filter_input(INPUT_GET,'nome',FILTER_SANITIZE_SPECIAL_CHARS);}
    else{ $Nome="";}
  
    if(isset($_POST['email'])){ $Email=filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL); }
    elseif(isset($_GET['email'])){ $Email=filter_input(INPUT_GET,'email',FILTER_VALIDATE_EMAIL);  }
    else{ $Email=""; }

    if(isset($_POST['nascimento'])){ $_nascimento=filter_input(INPUT_POST,'nascimento',FILTER_SANITIZE_SPECIAL_CHARS); }
    elseif(isset($_GET['nascimento'])){ $_nascimento=filter_input(INPUT_GET,'nascimento',FILTER_SANITIZE_SPECIAL_CHARS); }
    else{ $_nascimento=0; }

    if(isset($_POST['cpf'])){ $_cpf=filter_input(INPUT_POST,'cpf',FILTER_SANITIZE_SPECIAL_CHARS); }
    elseif(isset($_GET['cpf'])){ $_cpf=filter_input(INPUT_GET,'cpf',FILTER_SANITIZE_SPECIAL_CHARS); }
    else{ $_cpf=0; }
 
    // Senha e senhaConf
    if(isset($_POST['senha'])){  $senha=$_POST['senha'];  $hashSenha=$objPass->passwordHash($senha);  }
    else{  $senha=null; $hashSenha=null;   }
    if(isset($_POST['senhaConf'])){  $senhaConf=$_POST['senhaConf'];  }
    else{ $senhaConf=null;  }
 
    //Esqueci minha senha - Recuperação db account e db confimation
    $token=bin2hex(random_bytes(64));
    if(isset($_POST['token'])){   $token=$_POST['token'];    }
    else{ $token=bin2hex(random_bytes(64));  }

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
    

    