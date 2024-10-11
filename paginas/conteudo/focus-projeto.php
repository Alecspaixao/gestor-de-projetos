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
    </section>

    <section id="content-goals">
            <div class="goals" >
                <h2>Objetivos/Metas:</h2>
                <form action="" method="post">
                    <input type="text" name="tarefa" placeholder="Adicionar objetivo/meta">
                    <button type="submit" name="btnAdd">Adcionar</button>
                </form>
                <form method="post">
                    <?php
                        try{
                            $select = "SELECT * FROM tb_todo WHERE id_projeto=:id_projeto";
                            $resultado = $conexao->prepare($select);
                            $resultado->bindParam(':id_projeto', $id_projeto, PDO::PARAM_INT);
                            $resultado->execute();
                            $show = $resultado->fetch(PDO::FETCH_OBJ);

                            if($resultado->rowCount() > 0){
                                while($show = $resultado->fetch(PDO::FETCH_OBJ)){
                                   ?>
                                        <input value="<?php echo $show->id_todo; ?>" name="tarefas[]" type="checkbox" style="margin: 18px;" <?php if($show->isDone_todo == 1){echo "checked";} ?>><?php echo $show->tarefa_todo;?></input>
                                        <a <?php echo 'href="?action=del_obj&id=' . $show->id_todo . '"'?> onclick="confirm('Deseja apagar essa meta/objetivo?')"><?php echo "<button class='btn btn-danger'>Excluir</button>" ?></a><br>
                                        <?php echo $show->id_todo;?><br>
                                        <?php
                                        $allTodos = [];
                                        $allTodos = array_push($allTodos, $show->id_todo);
                                    echo $allTodos
                                        ?>
                                    <?php
                                }
                            }else{
                                echo "<p>Nenhum objetivo cadastrado.</p>";
                            }
                        }catch(PDOException $err){
                            echo "ERRO DE PDO: ". $err;
                        }
                        if(isset($_POST['btnUpdateTodo']) && $_POST['tarefas']){
                            if(empty($_POST['tarefas'])){
                                foreach ($_POST['tarefas'] as $tarefa){
                                    try{
                                        $update = "UPDATE tb_todo SET isDone_todo = 0 WHERE id_todo = :id_todo";
                                        $resultado = $conexao->prepare($update);
                                        $resultado->bindParam(':id_todo', $tarefa, PDO::PARAM_INT);
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
                            }
                            $tarefas = $_POST['tarefas'];
                            foreach ($tarefas as $tarefa){
                                try{
                                    $update = "UPDATE tb_todo SET isDone_todo = 1 WHERE id_todo = :id_todo";
                                    $resultado = $conexao->prepare($update);
                                    $resultado->bindParam(':id_todo', $tarefa, PDO::PARAM_INT);
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
                    }
                    ?>
                    <button name="btnUpdateTodo" >Atualizar lista</button>
                </form>
            </div>
     </div>
    </section>
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

    if($resultado->rowCount() > 0){
        while($show = $resultado->fetch(PDO::FETCH_OBJ)){
                $allTodos = array_push($allTodos, $show->id_todo);
                echo $allTodos;
        }
    }