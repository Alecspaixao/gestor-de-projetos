<?php 
    include_once('../../config/conexao.php');
    
    if(!isset($_GET['id'])){
        header('../home.php');
    }
    $id_todo = $_GET['id'];
    try{
    $delete = "DELETE FROM tb_todo WHERE id_todo=:id_todo";
    $resultado = $conexao->prepare($delete);
    $resultado->bindParam(':id_todo', $id_todo, PDO::PARAM_INT);
    $resultado->execute();
    if($resultado->rowCount() > 0){
        header('Location: ../home.php');
    } else{
        header('Location: ../home.php');
    }
    }catch(PDOException $e){
        echo "Erro ao deletar: ". $e->getMessage();
    }
?>