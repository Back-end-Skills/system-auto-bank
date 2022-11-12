<?php    

session_start(); 



    echo "Exibir Extrato <br><br> ";

    echo "id_cont = " . $_SESSION["id_conta"] ."<br> Agência  = ". $_SESSION["agencia"] . "<br>";
    echo "Código da Transação = " . $_SESSION["fk_conta"];