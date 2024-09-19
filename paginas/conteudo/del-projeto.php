<?php 
    include_once('../../config/conexao.php');

    if(isset($_GET['idDel'])){
        $id_project = $_GET['idDel'];
    
        try{
            $fotoSelect = "SELECT banner_projeto FROM tb_project WHERE id_project = :id_project";
            $resultado = $conexao->prepare($fotoSelect);
            $resultado->bindParam(':id_project', $id_project, PDO::PARAM_INT);
            $resultado->execute();

            if($resultado-> rowCount() > 0){
                if($banner != 'default-user.png'){
                    $path = "../../dist/img/banner/" . $banner;
                    unlink($path);
                }
            }
            try{
                $delete = "DELETE FROM tb_project WHERE id_project = :id_project";
                $resultado = $conexao->prepare($delete);
                $resultado->bindParam(':id_project', $id_project, PDO::PARAM_INT);
                $resultado-> execute();
        
                if($resultado->rowCount() > 0){
                    header("Location: home.php?section=novo_projeto");
                }else{
                    echo "ERRO AO DELETAR";
                }
            }catch(PDOException $err){
                echo "ERRO DE PDO(DELETE): " . $err;
            }
        }catch(PDOException $err){
            echo "ERRO DE PDO(DELETE DA FOTO): " . $err;
        }
    }
?>
