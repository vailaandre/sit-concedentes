<?php

$host = "localhost:3307";
$user = "root";
$pass = "";
$dbname = "sit";
$port = 3307;

try{
    //conexao com a porta
    $conn = new PDO("mysql:host=$host;port=$port;dbname=".$dbname, $user, $pass);
    
    //conexao sem a porta
    //$conn = new PDO("mysql:host=$host;dbname=".$dbname, $user, $pass);

    //echo "Conexao com o banco de dados realizado com sucesso!";
}catch(PDOException $err){
    echo "Erro: Conexão com o baco de dados não foi realizada com sucesso.". $err->getMessage();
}

?>