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
              <li class="breadcrumb-item active">General Form</li>
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
                <h3 class="card-title">Casdastro de Projeto</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                <form role="form" method="post" enctype="multipart/form-data">
                  <div class="card-body">

                  <!-- Nome do Projeto -->
                    <div class="form-group">
                    <input type="text" class="form-control" value=<?php echo "$id_user" ?> name="id_user" hidden required>

                      <label for="projectName">Nome do Projeto</label>
                      <input type="text" class="form-control" id="projectName" name="projectName" placeholder="Digite o nome do projeto" required>
                    </div>

                  <!-- Descrição do Projeto -->
                  <div class="form-group">
                      <label for="projectDescription">Descrição</label>
                      <textarea class="form-control" id="projectDescription" name="desc" rows="3" placeholder="Digite a descrição do projeto" required></textarea>
                  </div>

                  <!-- Categoria -->
                  <div class="form-group">
                      <label for="projectCategory">Categoria</label>
                      <select class="form-control" id="projectCategory" name="category" required>
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
                  <button type="submit" class="btn btn-primary" name="btnCreate">Cadastrar Projeto</button>
                  </div>

                  <!-- Checkbox para Confirmar -->
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="terms" required>
                    <label class="form-check-label" for="terms">Eu li e aceito os termos e condições</label>
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
                                required: true,
                                maxlength: 45
                            },
                            desc:{
                                required: true,
                                maxlength: 1000
                            }
                        }

                    })
                })
    </script>
<?php
    
if(isset($_POST['btnCreate'])){
    $projectName = $_POST['projectName'];
    $projectDesc= $_POST['desc'];
    $category = $_POST['category'];
    $id_user = $_POST['id_user'];

    if(isset($_FILES['banner'])){
        

        if (!empty($_FILES['banner']['name'])) {
            $allowedFormats = array("png", "jpg", "jpeg", "JPG");
            $extention = pathinfo($_FILES['banner']['name'  ], PATHINFO_EXTENSION);

            if (in_array(strtolower($extention), $allowedFormats)) {
                $destiny = "../dist/img/banner/";
                $tmpFolder = $_FILES['banner']['tmp_name'];
                $projectBanner = uniqid() . ".$extention";

                if (move_uploaded_file($tmpFolder, $destiny . $projectBanner)) {
                } else {
                    echo '<div class="container">
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-exclamation-triangle"></i> Erro!</h5>
                                Não foi possível fazer o upload do arquivo.
                            </div>
                        </div>';
                    exit();
                }
            } else {
                echo '<div class="container">
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Formato Inválido!</h5>
                            Formato de arquivo não permitido.
                        </div>
                    </div>';
                exit();
            }
        } else {
            $projectBanner = 'default-banner.jpg';
        }
    }else{
        echo "foto nao enviada!!!!!";
    }
        try{
            $insertProject = "INSERT INTO tb_project (nome_projeto, descricao_projeto, categoria_projeto, banner_projeto, id_user) VALUES (:projectName, :projectDesc, :projectCategory, :projectBanner, :id_user)";

            $resultado = $conexao->prepare($insertProject);
            $resultado->bindParam(':projectName', $projectName, PDO::PARAM_STR);
            $resultado->bindParam(':projectDesc', $projectDesc, PDO::PARAM_STR);
            $resultado->bindParam(':projectCategory', $category, PDO::PARAM_STR);
            $resultado->bindParam(':projectBanner', $projectBanner, PDO::PARAM_STR);
            $resultado->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            $resultado->execute();

            if($resultado->rowCount() > 0){
                header('Location: home.php');
            }else{
                echo "ERRO AO CRIAR PROJETO";
            }
        }catch(PDOException $err){
            echo "ERRO DE PDO: ". $err;
        }
        
}

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