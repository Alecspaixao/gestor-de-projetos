<?php 

    include_once('../../config/conexao.php');
    $select = "SELECT * FROM tb_project ORDER BY id_project DESC LIMIT 6";
    try{
        $resultado = $conexao->prepare($select);
        $i = 1;
        $resultado->execute();

        if($resultado->rowCount() > 0){
            while($show = $resultado->fetch(PDO::FETCH_OBJ)){
    ?>
            <div style="max-width: 100px; background-color: gray;">
                <h1><?php echo $show->nome_projeto ?></h1>
                <p><?php echo $show->descricao_projeto ?></p>
                <p><?php echo $show->UltUpdate_projeto?></p>
                <?php echo '<img src="../../dist/img/banner/' . $show->banner_projeto . '">';?>
                <a <?php echo 'href="update_projeto.php?idUpdate="' . $show->id_project . '"'?>>Atualizar</a>
            </div>
    <?php
            }
        }
            
    }catch(PDOException $err){
        echo "ERRO DE PDO:" . $err;
    }
?>