<?php
    try{
    define('HOST', 'localhost');
    define('BD', 'gestor-de-projetos');
    define('USER', 'root');
    define('PASS', '');

    $conexao = new PDO('mysql:host='.HOST.';dbname='.BD,USER,PASS);
    $conexao -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $err){
        echo "ERRO DE PDO:". $err->getMessage();
    }
?>