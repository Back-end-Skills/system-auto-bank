<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Cliente</title>
    <style>
        body{
            margin: 0;
            padding: 0;
            font-family: "montserrat",sans-serif;
            min-height: 100vh;
            background-image: linear-gradient(125deg,#6a89cc,#b8e994);
        }

        .container{
            width: 100%;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            text-align: center;
            color: #343434
        }

        .container h1{
            font-size: 160px;
            margin: 0;
            font-weight: 900;
            letter-spacing: 20px;
            -webkit-background-clip: text;
        }

        .container a{
            text-decoration: none;
            background: #e55039aa;
            color: #fff;
            padding: 12px 24px;
            display: inline-block;
            border-radius: 25px;
            font-size: 14px;
            text-transform: uppercase;
            transition: 0.4s;
        }

        .container a:hover{
            background: #e55039;
        }
    </style>   
</head>
<body>

    <div class="container">

        <h4>Cliente Autenticado Com Sucesso!</h4>       
        <h2>Bem - Vindo ! Dashboard do Cliente. </h2>

    </div>
    
</body>
</html>