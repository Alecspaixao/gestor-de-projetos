<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <action class="content-header flex">
      <div class="container-fluid">
        <div class="row mb-2">  
        </div>
      </div><!-- /.container-fluid -->
    </action> 
<div style="display: flex; gap: 10px; flex-wrap: wrap; padding: 1px;">
<?php 

    include_once('../config/conexao.php');
    if(isset($_GET['category'])){
      if($_GET['category'] == 'faculdade'){
        $select = "SELECT * FROM tb_project WHERE id_user = :id_user AND categoria_projeto = 'Faculdade' ORDER BY id_project DESC";
      }
      elseif($_GET['category'] == 'projeto_pessoal'){
        $select = "SELECT * FROM tb_project WHERE id_user = :id_user AND categoria_projeto = 'Projeto Pessoal'  ORDER BY id_project DESC";
      }
      elseif($_GET['category'] == 'trabalho'){
        $select = "SELECT * FROM tb_project WHERE id_user = :id_user AND categoria_projeto  = 'Trabalho'  ORDER BY id_project DESC";
      }
    }else{
      $select = "SELECT * FROM tb_project WHERE id_user = :id_user ORDER BY id_project DESC";
    }


    try{
        $resultado = $conexao->prepare($select);
        $resultado->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $resultado->execute();

        if($resultado->rowCount() > 0){
            while($show = $resultado->fetch(PDO::FETCH_OBJ)){
    ?>
    <a href="?action=focus_projeto&id=<?php echo $show->id_project; ?>"> 
<div style="min-width: 297px; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); display: flex; flex-direction: column; gap: 10px;">
    <div style="background-image: url('../dist/img/banner/<?php echo $show->banner_projeto; ?>'); background-size: cover; background-position: center; height: 150px; border-radius: 8px;"></div>
    <div style="flex: 1;">
        <h2 style="margin: 0; font-size: 20px; color: #333;"><?php echo $show->nome_projeto; ?></h2>
        <p style="margin: 10px 0; font-size: 14px; color: #555;"><?php echo $show->categoria_projeto; ?></p>
        <p style="font-size: 12px; color: #999;">Última atualização: <?php echo $show->UltUpdate_projeto; ?></p>
    </div>
    <a href="?action=update_projeto&id=<?php echo $show->id_project; ?>" style="text-decoration: none; color: #0073e6; font-weight: bold; font-size: 14px;" class="btn btn-warning">ALterar</a>
    <a href="?action=del_projeto&id=<?php echo $show->id_project; ?>" onclick="confirm('Tem certeza? Esta ação não pode ser desfeita!')" style="text-decoration: none; color: #0073e6; font-weight: bold; font-size: 14px;" class="btn btn-danger">Excluir</a>
</div>
</a>
    <?php
            }
        }else{echo "<div class='alert alert-warning mx-auto text-center w-100 '><h3>Nenhum resultado encontrado.</h3></div>";}
            
    }catch(PDOException $err){
        echo "ERRO DE PDO:" . $err;
    }
?>
 </div>
 </div>
            <!-- /.card -->

          

          

          <!--/.col (left) -->
          <!-- right column -->
          
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </action>
    <!-- /.content -->
  </div>
</body>
</html>