<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de conta</title>
    <link rel="stylesheet" href="dist/css/styleLogin/styleRegister.css">
</head>
<body>
    <main id="mainLogin">
        <section class="centerLogin">
            <form method="post">
            <h1>Resgistre-se para continuar</h1>

            <div class="text-field">
                <label for="usuario">Registre seu nome:</label>
                <input type="text" name="name" placeholder="Nome">
            </div>
            <div class="text-field">
                <label for="usuario">Registre seu e-mail:</label>
                <input type="email" name="email" placeholder="E-mail">
            </div>
            <div class="text-field">
                <label for="usuario">Registre sua senha:</label>
                <input type="password" name="password" placeholder="Senha">
            </div>
            <div class="text-field">
                <label for="usuario">Confirme sua senha:</label>
                <input type="password" name="passwordConfirm" placeholder="Repita sua senha">
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

            try{
                $register = "INSERT INTO tb_user (nome_user, email_user, senha_user) VALUES (:name, :email, :password)";
        
                $resultado = $conexao->prepare($register);
                $resultado->bindParam(':name', $name, PDO::PARAM_STR);
                $resultado->bindParam(':email', $email, PDO::PARAM_STR);
                $resultado->bindParam(':password', $password, PDO::PARAM_STR);
                $resultado->execute();
        
                if($resultado->rowCount() > 0){
                    echo "<div> Usuario cadastrado com sucesso!</div>";
                    header("Refresh: 3, index.php");
                }else{
                    echo "<div> Não foi possivel efetuar o cadastro</div>";
                    header("Refresh: 3, register.php");
                }
            }catch(PDOException $err){
                echo "ERRO DE PDO: ". $err;
            }
            
        }else{
            echo "<div>Senhas nao batem!</div>";
        } 
    }
?>
        </section>
    </main>
</body>
</html>