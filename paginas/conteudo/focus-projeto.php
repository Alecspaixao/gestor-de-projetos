<?php 
    include_once("../../config/conexao.php");
    if(!isset($_GET['id'])){
        header("Location:../home.php");
        exit;
    }
    $id_project = $_GET['id'];
    try{
        $select = "SELECT * FROM tb_project WHERE id_project=:id_project";
        $resultado = $conexao->prepare($select);
        $resultado->bindParam(':id_project', $id_project, PDO::PARAM_INT);
        $resultado->execute();
        if($resultado->rowCount() > 0){
            $show = $resultado->fetch(PDO::FETCH_OBJ);
            $name = $show->nome_projeto;
            $desc = $show->descricao_projeto;
            $category = $show->categoria_projeto;
            $banner = $show->banner_projeto;
        }
    }catch(PDOException $err){
        echo "ERRO DE PDO: ". $err;
    }

   ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name; ?></title>
    <link rel="stylesheet" href="../../dist/css/focus_projeto/style.css">
</head>
<body>
    <section id="banner" >
        <h1><?php echo $name; ?></h1>
        <p><?php echo $category; ?></p>
    </section>
    <section id="content">
        <div class="container" >
            <div class="about" >
                <h2>Descrição/Sobre</h2>
                <p><?php echo $desc; ?></p>

            </div>
            <div class="goals" >
                <h2>Objetivos/Metas</h2>
                <ul>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                </ul>
            </div>
     </div>
    </section>
</body>
</html>