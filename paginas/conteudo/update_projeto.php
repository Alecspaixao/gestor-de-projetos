<?php 

    include_once("../config/conexao.php");
    $select = "SELECT * FROM tb_project WHERE id_user=:id_user";
        $resultado = $conexao->prepare($select);
        $resultado->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $resultado->execute();
        if($resultado->rowCount() > 0){
            $fetch = $resultado->fetch(PDO::FETCH_OBJ);
            $old_name = $fetch->nome_projeto;
            $old_desc = $fetch->descricao_projeto;
            $old_banner = $fetch->banner_projeto;
        }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de conta</title>
    <link rel="stylesheet" href="../../dist/css/styleLogin/styleRegister.css">
</head>
<body>
    <main id="mainLogin">
        <section class="centerLogin">
            <form method="post" enctype="multipart/form-data" >
            <h1>Altere seu Projeto</h1>

            <div class="text-field" class="form-group" class="form-control">
                <label for="usuario">Atualize o nome do projeto:</label>
                <input type="text" name="name" placeholder="Nome" value=<?php echo $old_name?>>
            </div>
            <div class="text-field" class="form-group" class="form-control">
                <label for="usuario">Atualize a descrição:</label>
                <input type="text" name="desc" placeholder="Descrição" value=<?php echo $old_desc?>>
            </div>
            <div class="text-field" class="form-control">
                <label for="usuario">Atualize o banner(opcional)</label>
                <input type="file" name="banner" placeholder="Senha">
            </div>
            <button class="btnUpdate" name="btnUpdate" type="submit">Atualizar</button>
            <div class="message">
            </form>
                <a href="index.php">Cancelar/a>
            </div>
        

<?php

if(isset($_GET['idUpdate'])){
    $id_project = $_GET['idUpdate'];


    if(isset($_POST["btnUpdate"])){
        $new_name = $_POST["name"];
        $new_desc = $_POST["desc"];


            if(isset($_FILES['banner'])){

                if(!empty($_FILES['banner']['name'])){
                    $allowedFormats = array("png", "jpeg", "jpg");
                    $extention = pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION);

                    if(in_array(strtolower($extention), $allowedFormats)){
                        $tmpFolder = $_FILES['banner']['tmp_name'];
                        $destiny = "../dist/img/banner/";
                        $newBanner= uniqid() . ".$extention";

                        if(file_exists($destiny . $old_banner)){
                            unlink($destiny . $old_banner);
                        }
                        if(move_uploaded_file($tmpFolder, $destiny . $newBanner)){

                        }else{
                            echo"Falha no upload de arquivo!";
                            exit();
                        }
                    }else{
                        echo"Formato nao permitido!";
                        exit();
                    }
                }else{
                    $newBanner= $old_banner;
                }  
            }

            try{
                $register = "UPDATE tb_project SET nome_projeto=:new_name, descricao_projeto=:new_desc, banner_projeto=:newBanner WHERE id_project = :id_project";
        
                $resultado = $conexao->prepare($register);
                $resultado->bindParam(':id_project', $id_project, PDO::PARAM_INT);
                $resultado->bindParam(':new_name', $new_name, PDO::PARAM_STR);
                $resultado->bindParam(':new_desc', $new_desc, PDO::PARAM_STR);
                $resultado->bindParam(':newBanner', $newBanner, PDO::PARAM_STR);
                $resultado->execute();
        
                if($resultado->rowCount() > 0){
                    echo "<div>Projeto atualizado com sucesso!</div>";
                    header("Refresh: 2, home.php");
                }else{
                    echo "<div>Não foi possivel atualizar</div>";
                    header("Refresh: 2, home.php");
                }
                if ($new_name !== $new_name || $new_desc !== $old_desc) {
                    header("Location: home.php"); // Redireciona para sair se email ou senha foram alterados
                    exit(); // Garante que o redirecionamento ocorra
                } else {
                    header("Refresh: 3, home.php"); // Redireciona de volta ao perfil após 3 segundos
                    exit(); // Garante que o redirecionamento ocorra
                }
            }catch(PDOException $err){
                echo "ERRO DE PDO: ". $err;
            }
    }
}else{header("Location: ../home.php");}
?>
</body>
</html>