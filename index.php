<?php 
    ob_start();
    session_start();
    if(isset($_SESSION['emailUser']) && $_SESSION['senhaLogin']){
      header("Location: paginas/home.php");
    }
    include_once('config/conexao.php');
    if(isset($_POST['btnLogin'])){
        $emailLogin = filter_input(INPUT_POST,'email', FILTER_DEFAULT);
        $senhaLogin = filter_input(INPUT_POST,'senha', FILTER_DEFAULT);

        $select = "SELECT * FROM tb_user WHERE email_user = :emailLogin AND senha_user = :senhaLogin";
        try{
            $resultado = $conexao->prepare($select);
            $resultado->bindParam(':emailLogin',$emailLogin, PDO::PARAM_STR);
            $resultado->bindParam(':senhaLogin',$senhaLogin, PDO::PARAM_STR);
            $resultado->execute();

            if($resultado->rowCount() > 0){
                echo "<div>Logado com sucesso</div>";

               $_SESSION['emailUser'] = $emailLogin;
               $_SESSION['senhaLogin'] = $senhaLogin;
               header("Refresh: 1, paginas/home.php");
            
            }else{
                echo "Nao logado";
            }
        }catch(PDOException $err){
            echo 'ERRO DE PDO: '. $err->getMessage(); 
        }
    }

?>
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
                <label for="usuario">Usuário ou E-mail</label>
                <input type="text" name="email" placeholder="Insira o usuário ou e-mail">
            </div>

            <div class="text-field">        
                <label for="senha">Senha</label>
                <input type="password" name="senha" placeholder="Insira sua senha">
            </div>
            
            
            <button class="btnLogin" name="btnLogin" type="submit">Fazer Login</button>
            <div class="rodape">
                    <p>Não tem conta? <a href="register.html">Crie uma!</a></p>
                    <p><a href="esquecer-senha.html">Esqueceu a senha?</a></p>
            </div>
        </form>
        </section>
    </main>
</body>
</html>