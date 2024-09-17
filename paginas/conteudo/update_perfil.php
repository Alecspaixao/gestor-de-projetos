
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
            <form method="post" enctype="multipart/form-data">
            <h1>Atualize seu perfil</h1>

            <div class="text-field">
                <label for="usuario">Atualize seu nome:</label>
                <input type="text" name="name" placeholder="Nome" value=<?php echo $nome_user?>>
            </div>
            <div class="text-field">
                <label for="usuario">Atualize seu e-mail:</label>
                <input type="email" name="email" placeholder="E-mail" value=<?php echo $email_user?>>
            </div>
            <div class="text-field">
                <label for="usuario">Atualize sua senha:</label>
                <input type="password" name="password" placeholder="Senha">
            </div>
            <div class="text-field">
                <label for="usuario">Atualize sua senha:</label>
                <input type="password" name="passwordConfirm" placeholder="Repita sua senha">
            </div>
            <div class="text-field">
                <label for="usuario">Atualize sua senha:</label>
                <input type="file" name="foto" placeholder="Repita sua senha">
            </div>
            <button class="btnLogin" name="btnUpdate" type="submit">Registrar</button>
            <div class="message">
            </form>
                <p>Enviaremos a você um e-mail de verificação com código. </p>
                <p>Acesse e insira-o na próxima página.</p>
                <a href="index.php">Voltar ao Login</a>
            </div>
        

<?php
    include_once("../config/conexao.php");

    if(isset($_POST["btnUpdate"])){
        $new_name = $_POST["name"];
        $new_email = $_POST["email"];
        $new_password = $_POST["password"];
        $passwordConfirm = $_POST["passwordConfirm"];

        $select = "SELECT email_user, senha_user FROM tb_user WHERE id_user=:id_user";
        $resultado = $conexao->prepare($select);
        $resultado->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $resultado->execute();
        if($resultado->rowCount() > 0){
            $fetch = $resultado->fetch(PDO::FETCH_OBJ);
            $old_email = $fetch->email_user;
            $old_password = $fetch->senha_user;
        }
        if($new_password == $passwordConfirm){
            $new_password = password_hash($new_password, PASSWORD_DEFAULT);

            if(isset($_FILES['foto'])){

                if(!empty($_FILES['foto']['name'])){
                    $allowedFormats = array("png", "jpeg", "jpg", "gif");
                    $extention = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

                    if(in_array(strtolower($extention), $allowedFormats)){
                        $tmpFolder = $_FILES['foto']['tmp_name'];
                        $destiny = "../dist/img/user/";
                        $newUserPhoto = uniqid() . ".$extention";

                        if(file_exists($destiny . $foto_user)){
                            unlink($destiny . $foto_user);
                        }
                        if(move_uploaded_file($tmpFolder, $destiny . $newUserPhoto)){

                        }else{
                            echo"Falha no upload de arquivo!";
                            exit();
                        }
                    }else{
                        echo"Formato nao permitido!";
                        exit();
                    }
                }else{
                    $newUserPhoto = $foto_user;
                }  
            }

            try{
                $register = "UPDATE tb_user SET nome_user=:new_name, email_user=:new_email, senha_user=:new_password, foto_user=:newUserPhoto WHERE id_user=:user_id";
        
                $resultado = $conexao->prepare($register);
                $resultado->bindParam(':user_id', $id_user, PDO::PARAM_INT);
                $resultado->bindParam(':new_name', $new_name, PDO::PARAM_STR);
                $resultado->bindParam(':new_email', $new_email, PDO::PARAM_STR);
                $resultado->bindParam(':new_password', $new_password, PDO::PARAM_STR);
                $resultado->bindParam(':newUserPhoto', $newUserPhoto, PDO::PARAM_STR);
                $resultado->execute();
        
                if($resultado->rowCount() > 0){
                    echo "<div>Usuario atualizado com sucesso!</div>";
                    header("Refresh: 3, ../index.php");
                }else{
                    echo "<div>Não foi possivel efetuar o cadastro</div>";
                    header("Refresh: 3, home.php");
                }
                if ($new_email !== $old_email || $new_password !== $old_password) {
                    header("Location: ../index.php"); // Redireciona para sair se email ou senha foram alterados
                    exit(); // Garante que o redirecionamento ocorra
                } else {
                    header("Refresh: 3, home.php?atualizar_perfil"); // Redireciona de volta ao perfil após 3 segundos
                    exit(); // Garante que o redirecionamento ocorra
                }
            }catch(PDOException $err){
                echo "ERRO DE PDO: ". $err;
            }
            
        }else{
            echo "<div>Senhas nao batem!</div>";
            exit();
        } 
    }
?>
</body>
</html>