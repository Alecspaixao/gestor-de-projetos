<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="dist/css/styleLogin/styleIndex.css">
</head>
<body>
    <main id="mainLogin">
        <section class="centerLogin">
            <h1>Faça login para continuar</h1>
        <form method="post">
            <div class="text-field">
                <label for="email">Usuário ou E-mail</label>
                <input type="text" name="email" placeholder="Insira o usuário ou e-mail">
            </div>

            <div class="text-field">        
                <label for="senha">Senha</label>
                <input type="password" name="senha" placeholder="Insira sua senha">
            </div>
            
            
            <button class="btnLogin" name="btnLogin" type="submit">Fazer Login</button>
            <div class="rodape">
                    <p>Não tem conta? <a href="register.php">Crie uma!</a></p>
                    <p><a href="esquecer-senha.html">Esqueceu a senha?</a></p>
            </div>
        </form>
<?php 
    session_start();
    if(isset($_SESSION['LoginUser']) && $_SESSION['senhaLogin']){
      header("Location: paginas/home.php");
    }
    include_once('config/conexao.php');
    if(isset($_POST['btnLogin'])){
        $optionLogin = filter_input(INPUT_POST,'email', FILTER_SANITIZE_EMAIL);
        $senhaLogin = filter_input(INPUT_POST,'senha', FILTER_DEFAULT);

        $select = "SELECT * FROM tb_user WHERE email_user = :optionLogin OR nome_user = :optionLogin";
        try{
            $resultado = $conexao->prepare($select);
            $resultado->bindParam(':optionLogin',$optionLogin, PDO::PARAM_STR);
            $resultado->execute();

            if($resultado->rowCount() > 0){
                $user = $resultado->fetch(PDO::FETCH_ASSOC);
                if (password_verify($senhaLogin, $user['senha_user'])){
                    $_SESSION['emailUser'] = $optionLogin;
                    $_SESSION['senhaLogin'] = $user['id_user'];
                    echo "<div>Logado com sucesso!</div>";
                    header("Refresh: 1, paginas/home.php");
                }else{
                    echo "<div>Não foi possivel fazer login!!</div>"; 
                }
            }else{
                echo "<div style='align-items: center;'>Email ou Senha incorretos</div>";
                header("Refresh: 3, index.php");
            }
        }catch(PDOException $err){
            echo 'ERRO DE PDO: '. $err->getMessage(); 
        }
    }

?>
        </section>
    </main>
</body>
</html>