<?php
    try{
    define('HOST', 'localhost');
    define('BD', 'ProjectShelf');
    define('USER', 'root');
    define('PASS', 'bdjmf');

    $conexao = new PDO('mysql:host='.HOST.';dbname='.BD,USER,PASS);
    $conexao -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $err){
        echo "ERRO DE PDO:". $err->getMessage();
    }
?>