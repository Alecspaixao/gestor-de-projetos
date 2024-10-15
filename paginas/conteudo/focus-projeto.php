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
    <!-- include libraries(jQuery, bootstrap) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
</head>
<body>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
      <div class="container-fluid">
        <div class="row mb-2">  
        </div>
      </div><!-- /.container-fluid -->
      <?php echo "<section id='banner' style='background-image: url(\"../dist/img/banner/". $banner . "\"); background-color: '>";?>
        <h1><?php echo $name; ?></h1>
        <p><?php echo $category; ?></p>
      </section>

    <script>
        $(document).ready(function() {
        $('#summernote').summernote();
        });
    </script>
    
<div class="container" >
    <section id="content-desc">
            <div class="about" >
                <h2>Descrição/Sobre:</h2>
                <p><?php echo $desc; ?></p>
                <div class="text-editor">
                    <textarea name="notes-project" id="summernote"></textarea>
                </div>
            </div>
    </section>

    <section id="content-goals">
        <div class="goals" >
            <h2>Objetivos/Metas:</h2>
            <form action="" method="post">
                <input type="text" name="tarefa" placeholder="Adicionar objetivo/meta">
                <button class="btn btn-primary" type="submit" name="btnAdd">Adcionar</button>
            </form>
            <div class="goals-list">
                <form method="post">
                    <?php
                        try{
                            $select = "SELECT * FROM tb_todo WHERE id_projeto=:id_projeto";
                            $resultado = $conexao->prepare($select);
                            $resultado->bindParam(':id_projeto', $id_projeto, PDO::PARAM_INT);
                            $resultado->execute();
                            
                            $selectids = "SELECT id_todo FROM tb_todo WHERE id_projeto=:id_projeto";
                            $resultadoids = $conexao->prepare($selectids);
                            $resultadoids->bindParam(':id_projeto', $id_projeto, PDO::PARAM_INT);
                            $resultadoids->execute();
                            $ids = $resultadoids->fetchAll(PDO::FETCH_COLUMN);
                            
                            
                            if($resultado->rowCount() > 0){
                                while($show = $resultado->fetch(PDO::FETCH_OBJ)){
                                    ?>
                                        <input value="<?php echo $show->id_todo; ?>" name="tarefas[]" type="checkbox" <?php if($show->isDone_todo == 1){echo "checked";} ?>>
                                        <label for="goal-task"><?php echo $show->tarefa_todo;?></label>
                                        <a <?php echo 'href="?action=del_obj&id=' . $show->id_todo . '"'?> onclick="confirm('Deseja apagar essa meta/objetivo?')">Excluir</a><br>
                                        <?php
                                }
                            }else{
                                echo "<p>Nenhum objetivo cadastrado.</p>";
                            }
                        }catch(PDOException $err){
                            echo "ERRO DE PDO: ". $err;
                        }
                    ?>
                    <button class="btn btn-success" type="submit" name="btnUpdateTodo" >Salvar</button>
                </form>
                <?php
                    if(isset($_POST['btnUpdateTodo'])){
                                if(isset($_POST['tarefas']) && !empty($_POST['tarefas'])){
                                    $tarefas = $_POST['tarefas'];
                                    print_r($tarefas);
                                    $notSelectedTasks = array_diff($ids, $tarefas);
                                        foreach ($notSelectedTasks as $notSelectedTaskId){
                                            try{
                                                $update = "UPDATE tb_todo SET isDone_todo = 0 WHERE id_todo = :id_todo";
                                                $resultado = $conexao->prepare($update);
                                                $resultado->bindParam(':id_todo', $notSelectedTaskId, PDO::PARAM_INT);
                                                $resultado->execute();
                                                
                                                if($resultado->rowCount() > 0){
                                                    header("Location: home.php?action=focus_projeto&id=".$id_projeto);
                                                }else{
                                                    echo "ERRO AO ATUALIZAR LISTA";
                                                }
                                            }catch(PDOException $err){
                                                echo "ERRO DE PDO: ". $err;
                                            }
                                        }
                                        foreach ($tarefas as $tarefa){
                                            try{
                                                $update = "UPDATE tb_todo SET isDone_todo = 1 WHERE id_todo = :id_todo";
                                                $resultado = $conexao->prepare($update);
                                                $resultado->bindParam(':id_todo', $tarefa, PDO::PARAM_INT);
                                                $resultado->execute();
                                                
                                                if($resultado->rowCount() > 0){
                                                    header("Location: home.php?action=focus_projeto&id=".$id_projeto);
                                                }
                                            }catch(PDOException $err){
                                                echo "ERRO DE PDO: ". $err;
                                        }
                                    }
                                }else{
                                    foreach ($ids as $id){
                                        try{
                                            $update = "UPDATE tb_todo SET isDone_todo = 0 WHERE id_todo = :id_todo";
                                            $resultado = $conexao->prepare($update);
                                            $resultado->bindParam(':id_todo', $id, PDO::PARAM_INT);
                                            $resultado->execute();
                                            
                                            if($resultado->rowCount() > 0){
                                                header("Location: home.php?action=focus_projeto&id=".$id_projeto);
                                            }
                                        }catch(PDOException $err){
                                            echo "ERRO DE PDO: ". $err;
                                    }
                                }
                                }
                            }
                ?>
            </div>
        </div>
    </section>
</div>
    </div><!-- /.container -->
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
