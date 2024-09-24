<?php 

    include_once("../config/conexao.php");
    $id_project = $_GET['idUpdate'];
    $select = "SELECT * FROM tb_project WHERE id_project=:id_project";
        $resultado = $conexao->prepare($select);
        $resultado->bindParam(':id_project', $id_project, PDO::PARAM_INT);
        $resultado->execute();
        if($resultado->rowCount() > 0){
            $fetch = $resultado->fetch(PDO::FETCH_OBJ);
            $old_name = $fetch->nome_projeto;
            $old_desc = $fetch->descricao_projeto;
            $old_category = $fetch->categoria_projeto;
            $old_banner = $fetch->banner_projeto;
        }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de conta</title>
    <link rel="stylesheet" href="../../dist/css/styleLogin/styleRegister.css">
</head>
<body>
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>General Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Alteração do Projeto <b><?php echo $old_name ?></b></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                <form role="form" method="post" enctype="multipart/form-data">
                  <div class="card-body">

                  <!-- Nome do Projeto -->
                    <div class="form-group">
                    <input type="text" class="form-control" value=<?php echo "$id_user" ?> name="id_user" hidden required>

                      <label for="projectName">Nome do Projeto</label>
                      <input type="text" class="form-control" id="projectName" value=<?php echo $old_name ?> name="projectName" placeholder="Digite o nome do projeto">
                    </div>

                  <!-- Descrição do Projeto -->
                  <div class="form-group">
                      <label for="projectDescription">Descrição</label>
                      <textarea class="form-control" id="projectDescription" name="desc" rows="3" placeholder="Digite a descrição do projeto"></textarea>
                  </div>

                  <!-- Categoria -->
                  <div class="form-group">
                      <label for="projectCategory">Categoria</label>
                      <select class="form-control" id="projectCategory" name="category">
                          <option value="" disabled selected>Escolha a categoria</option>
                          <option value="Trabalho">Trabalho</option>
                          <option value="Faculdade">Faculdade</option>
                          <option value="Projeto Pessoal">Projeto Pessoal</option>
                          <!-- Adicione mais opções conforme necessário -->
                      </select>
                  </div>

                  <!-- Arquivo -->
                  <div class="form-group">
                      <label for="projectFile">Arquivo (opcional)</label>
                      <div class="input-group">
                          <div class="custom-file">
                              <input type="file" class="custom-file-input" name="banner" id="projectFile">
                              <label class="custom-file-label" for="projectFile">Escolher arquivo</label>
                          </div>
                          <div class="input-group-append">
                              <span class="input-group-text">Enviar</span>
                          </div>
                      </div>
                  </div>

                  <!-- Botão de Enviar -->
                  <button type="submit" class="btn btn-primary" name="btnUpdate">Atualizar Projeto</button>
                  </div>
              </form>
              <script src="dist/js/jquery-3.7.1.min.js"></script>
              <script src="dist/js/jquery.validate.js"></script>
              <script src="dist/js/additional-methods.js"></script>
              <script src="dist/js/localization/messages_pt_BR.min.js"></script>
              <script src="dist/js/localization/messages_pt_BR.js"></script>
              <script>
                $(document).ready(function(){
                    $("#formPro").validade({
                        rules:{
                            name:{
                                maxlength: 45
                            },
                            desc:{
                                maxlength: 1000
                            }
                        }

                    })
                })
    </script>
<?php

if(isset($_GET['idUpdate'])){
    $id_project = $_GET['idUpdate'];


    if(isset($_POST["btnUpdate"])){
        $new_name = $_POST["projectName"];
        $new_desc = $_POST["desc"];
        $new_category = $_POST["category"];
    
            if(isset($_FILES['banner'])){

              if(!empty($_FILES['banner']['name'])){
                  $allowedFormats = array("png", "jpeg", "jpg");
                  $extention = pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION);

                  if(in_array(strtolower($extention), $allowedFormats)){
                      $tmpFolder = $_FILES['banner']['tmp_name'];
                      $destiny = "../dist/img/banner/";
                      $newBanner= uniqid() . ".$extention";

                      if(file_exists($destiny . $old_banner)){
                          unlink($destiny . $old_banner);
                      }
                      if(move_uploaded_file($tmpFolder, $destiny . $newBanner)){

                      }else{
                          echo"Falha no upload de arquivo!";
                          exit();
                      }
                  }else{
                      echo"Formato nao permitido!";
                      exit();
                  }
              }else{$newBanner= $old_banner;}
                
            }
            if(empty($_POST['projectName'])){
              $new_name = $old_name;
            }
            if(empty($_POST['desc'])){
              $new_desc = $old_desc;
            }
            if(empty($_POST['category'])){
              $new_category = $old_category;
            }

            try{
                $update = "UPDATE tb_project SET nome_projeto=:new_name, descricao_projeto=:new_desc, categoria_projeto=:new_category, banner_projeto=:newBanner WHERE id_project = :id_project";
        
                $resultado = $conexao->prepare($update);
                $resultado->bindParam(':id_project', $id_project, PDO::PARAM_INT);
                $resultado->bindParam(':new_name', $new_name, PDO::PARAM_STR);
                $resultado->bindParam(':new_desc', $new_desc, PDO::PARAM_STR);
                $resultado->bindParam(':new_category', $new_category, PDO::PARAM_STR);
                $resultado->bindParam(':newBanner', $newBanner, PDO::PARAM_STR);
                $resultado->execute();
        
                if($resultado->rowCount() > 0){
                    echo "<div>Projeto atualizado com sucesso!</div>";
                    header("Refresh: 2, home.php");
                }else{
                    echo "<div>Não foi possivel atualizar</div>";
                    header("Refresh: 2, home.php");
                }
                if ($new_name !== $new_name || $new_desc !== $old_desc) {
                    header("Location: home.php"); // Redireciona para sair se email ou senha foram alterados
                    exit(); // Garante que o redirecionamento ocorra
                } else {
                    header("Refresh: 3, home.php"); // Redireciona de volta ao perfil após 3 segundos
                    exit(); // Garante que o redirecionamento ocorra
                }
            }catch(PDOException $err){
                echo "ERRO DE PDO: ". $err;
            }
    }
}else{header("Location: ../home.php");}
?>
            </div>
            <!-- /.card -->

          

          

          <!--/.col (left) -->
          <!-- right column -->
          
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</body>
</html>