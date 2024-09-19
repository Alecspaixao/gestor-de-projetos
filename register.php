<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de conta</title>
    <link rel="stylesheet" href="dist/css/styleLogin/styleRegister.css">
</head>
<body>
    <main id="mainLogin">
        <section class="centerLogin">
            <form method="post" enctype="multipart/form-data" id="formRegister">
            <h1>Resgistre-se para continuar</h1>

            <div class="text-field">
                <label for="usuario">Registre seu nome:</label>
                <input type="text" name="name" id="name" placeholder="Nome">
            </div>
            <div class="text-field">
                <label for="usuario">Registre seu e-mail:</label>
                <input type="email" name="email" id="email" placeholder="E-mail">
            </div>
            <div class="text-field">
                <label for="usuario">Registre sua senha:</label>
                <input type="password" name="password" id="password" placeholder="Senha">
            </div>
            <div class="text-field">
                <label for="usuario">Confirme sua senha:</label>
                <input type="password" name="passwordConfirm" id="confirmPwd" placeholder="Repita sua senha">
            </div>
            <div class="text-field">
                <label for="usuario">Registre sua foto(opicional):</label>
                <input type="file" name="foto" placeholder="Foto">
            </div>
            <button class="btnLogin" name="btnRegister" type="submit">Registrar</button>
            <div class="message">
            </form>
                <p>Enviaremos a você um e-mail de verificação com código. </p>
                <p>Acesse e insira-o na próxima página.</p>
                <a href="index.php">Voltar ao Login</a>
            </div>
        
<?php
    include_once("config/conexao.php");

    if(isset($_POST["btnRegister"])){
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $passwordConfirm = $_POST["passwordConfirm"];

        if($password == $passwordConfirm){
            $password = password_hash($password, PASSWORD_DEFAULT);

            if(isset($_FILES['foto'])){

                if(!empty($_FILES['foto']['name'])){
                    $allowedFormats = array("png", "jpeg", "jpg", "gif");
                    $extention = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                    if(in_array(strtolower($extention), $allowedFormats)){
                        $tmpFolder = $_FILES['foto']['tmp_name'];
                        $destiny = "dist/img/user/";
                        $userPhoto = uniqid() . ".$extention";
                        if(move_uploaded_file($tmpFolder, $destiny . $userPhoto)){

                        }else{
                            echo"Falha no upload de arquivo!";
                            exit();
                        }
                    }else{
                        echo"Formato nao permitido!";
                        exit();
                    }
                }else{
                    $userPhoto = "default-photo.png";
                }  
            }

            try{
                $register = "INSERT INTO tb_user (nome_user, email_user, senha_user, foto_user) VALUES (:name, :email, :password, :userPhoto)";
        
                $resultado = $conexao->prepare($register);
                $resultado->bindParam(':name', $name, PDO::PARAM_STR);
                $resultado->bindParam(':email', $email, PDO::PARAM_STR);
                $resultado->bindParam(':password', $password, PDO::PARAM_STR);
                $resultado->bindParam(':userPhoto', $userPhoto, PDO::PARAM_STR);
                $resultado->execute();
        
                if($resultado->rowCount() > 0){
                    echo "<div> Usuario cadastrado com sucesso!</div>";
                    header("Refresh: 3, login.php");
                }else{
                    echo "<div> Não foi possivel efetuar o cadastro</div>";
                    header("Refresh: 3, register.php");
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
        </section>
    </main>
    <script src="dist/js/jquery-3.7.1.min.js"></script>
    <script src="dist/js/jquery.validate.js"></script>
    <script src="dist/js/additional-methods.js"></script>
    <script src="dist/js/localization/messages_pt_BR.min.js"></script>
    <script src="dist/js/localization/messages_pt_BR.js"></script>
<script>
        jQuery(document).ready(function($){
            $("#formRegister").validate({
                rules:{
                    name:{
                        required: true,
                        maxlength: 100
                    },
                    email:{
                        required: true,
                        email: true,
                        maxlength: 150
                    },
                    password:{
                        required:true,
                        rangelength: [6, 150]
                    },
                    confirmPwd:{
                        required: true,
                        equalTo: '#password'
                    }
                }
            })
        })
    </script>
    
</body>
</html>