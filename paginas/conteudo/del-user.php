<?php 
    include_once('../../config/conexao.php');

    if(isset($_GET['id'])){
        $id_user = $_GET['id'];
    
        try{
            $fotoSelect = "SELECT foto_user FROM tb_user WHERE id_user = :id_user";
            $resultado = $conexao->prepare($fotoSelect);
            $resultado->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            $resultado->execute();

            if($resultado-> rowCount() > 0){
                if($foto_user != 'default-user.png'){
                    $path = "../../dist/img/user/" . $foto_user;
                    unlink($path);
                }
            }
            try{
                $delete = "DELETE FROM tb_user WHERE id_user = :id_user";
                $resultado = $conexao->prepare($delete);
                $resultado->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $resultado-> execute();
        
                if($resultado->rowCount() > 0){
                    header("Location: ../../home.php");
                }else{
                    echo "ERRO AO DELETAR";
                }
            }catch(PDOException $err){
                echo "ERRO DE PDO(DELETE): " . $err;
            }
        }catch(PDOException $err){
            echo "ERRO DE PDO(DELETE DA FOTO): " . $err;
        }
        try{
            $delete = "DELETE FROM tb_user WHERE id_user = :id_user";
            $resultado = $conexao->prepare($delete);
            $resultado->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            $resultado-> execute();
    
            if($resultado->rowCount() > 0){
                header("Location: ../index.php");
            }else{
                echo "ERRO AO DELETAR";
            }
        }catch(PDOException $err){
            echo "ERRO DE PDO(DELETE): " . $err;
        }
    }else{
        header('../index.php');
    }
    
?>
