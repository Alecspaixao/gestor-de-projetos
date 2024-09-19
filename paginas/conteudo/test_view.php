<?php 

    include_once('../config/conexao.php');
    $select = "SELECT * FROM tb_project ORDER BY id_project DESC LIMIT 6";
    try{
        $resultado = $conexao->prepare($select);
        $i = 1;
        $resultado->execute();

        if($resultado->rowCount() > 0){
            while($show = $resultado->fetch(PDO::FETCH_OBJ)){
    ?>
<div style=" margin-left: 50%; max-width: 400px; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; gap: 10px;">
    <div style="background-image: url('../../dist/img/banner/<?php echo $show->banner_projeto; ?>'); background-size: cover; background-position: center; height: 150px; border-radius: 8px;"></div>
    <div style="flex: 1;">
        <h2 style="margin: 0; font-size: 18px; color: #333;"><?php echo $show->nome_projeto; ?></h2>
        <p style="margin: 10px 0; font-size: 14px; color: #555;"><?php echo $show->categoria_projeto; ?></p>
        <p style="font-size: 12px; color: #999;">Última atualização: <?php echo $show->UltUpdate_projeto; ?></p>
    </div>
    <a href="?section=update_projeto&idUpdate=<?php echo $show->id_project; ?>" style="text-decoration: none; color: #0073e6; font-weight: bold; font-size: 14px;">Atualizar</a>
</div>


    <?php
            }
        }
            
    }catch(PDOException $err){
        echo "ERRO DE PDO:" . $err;
    }
?>