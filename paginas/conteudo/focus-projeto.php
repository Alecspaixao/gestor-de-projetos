<?php 
    include_once("../config/conexao.php");
    if(!isset($_GET['id'])){
        header("Location:../home.php");
        exit;
    }
    $id_projeto = $_GET['id'];
    try{
        $select = "SELECT * FROM tb_project WHERE id_project=:id_projeto";
        $resultado = $conexao->prepare($select);
        $resultado->bindParam(':id_projeto', $id_projeto, PDO::PARAM_INT);
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
    <link rel="stylesheet" href="../dist/css/focus_projeto/style.css">
</head>
<body>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
      <div class="container-fluid">
        <div class="row mb-2">  
        </div>
      </div><!-- /.container-fluid -->
      <?php echo "<section id='banner' style='background-image: url(\"../dist/img/banner/". $banner . "\");'>"; ?>
        <h1><?php echo $name; ?></h1>
        <p><?php echo $category; ?></p>
    </section>
    <section id="content">
        <div class="container" >
            <div class="about" >
                <h2>Descrição/Sobre:</h2>
                <p><?php echo $desc; ?></p>

            </div>
            <div class="goals" >
                <h2>Objetivos/Metas:</h2>
                <form action="" method="post">
                    <input type="text" name="tarefa" placeholder="Adicionar objetivo/meta">
                    <button type="submit" name="btnAdd">Adcionar</button>
                </form>
                    <?php
                        try{
                            $select = "SELECT * FROM tb_todo WHERE id_projeto=:id_projeto";
                            $resultado = $conexao->prepare($select);
                            $resultado->bindParam(':id_projeto', $id_projeto, PDO::PARAM_INT);
                            $resultado->execute();

                            if($resultado->rowCount() > 0){
                                while($show = $resultado->fetch(PDO::FETCH_OBJ)){
                                   ?>
                                        <input type="checkbox" style="margin: 18px;" <?php if($show->isDone_todo == 1){echo "checked";} ?>><?php echo $show->tarefa_todo;?></input>
                                        <a <?php echo 'href="?action=del_obj&id=' . $show->id_todo . '"'?> onclick="confirm('Deseja apagar essa meta/objetivo?')"><?php echo "<button class='btn btn-danger'>Excluir</button>" ?></a><br>
                                        <?php echo $show->id_todo;?><br>
                                    <?php
                                }
                            }else{
                                echo "<p>Nenhum objetivo cadastrado.</p>";
                            }
                        }catch(PDOException $err){
                            echo "ERRO DE PDO: ". $err;
                        }
                    ?>
            </div>
     </div>
    </section>
</body>
</div>
 

</html>
<?php
    if(isset($_POST['btnAdd'])){
        $tarefa = $_POST['tarefa'];

        try{
            $insert = "INSERT INTO tb_todo (tarefa_todo, isDone_todo,  id_projeto) VALUES (:tarefa_todo, 0, :id_projeto)";

            $resultado = $conexao->prepare($insert);
            $resultado->bindParam(':tarefa_todo', $tarefa, PDO::PARAM_STR);
            $resultado->bindParam(':id_projeto', $id_projeto, PDO::PARAM_INT);
            $resultado->execute();
            header("Location: home.php?action=focus_projeto&id=".$id_projeto);
        }catch(PDOException $err){
            echo "ERRO DE PDO: ". $err;
        }
    }