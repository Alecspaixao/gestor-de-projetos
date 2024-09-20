
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar perfil</title>
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
                <h3 class="card-title">Atualizar Perfil</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                <form role="form" method="post" enctype="multipart/form-data">
                  <div class="card-body">

                  <!-- Nome do Usuario -->
                    <div class="form-group">
                      <label for="projectName">Nome</label>
                      <input type="text" class="form-control" value=<?php echo $nome_user; ?> id="name" name="name" placeholder="Digite o nome" required>
                    </div>

                  <!-- Informações Pessoais -->
                  <div class="form-group">
                      <label for="projectDescription">Email</label>
                      <input class="form-control" value=<?php echo $email_user; ?> id="email" name="email" rows="3" placeholder="Digite seu email" required></input>
                  </div>

                  <div class="form-group">
                      <label for="projectDescription">Senha</label>
                      <input class="form-control" type="password" id="projectDescription" name="password" rows="3" placeholder="Digite sua senha" required></input>
                  </div>
                  <div class="form-group">
                      <label for="projectDescription">Confirme sua senha</label>
                      <input class="form-control" type="password" id="projectDescription" name="cpassword" rows="3" placeholder="Repita sua senha" required></input>
                  </div>
                  <!-- Arquivo -->
                  <div class="form-group">
                      <label for="projectFile">Foto de Perfil</label>
                      <div class="input-group">
                          <div class="custom-file">
                              <input type="file" class="custom-file-input" name="foto" id="projectFile">
                              <label class="custom-file-label" for="projectFile">Escolher arquivo</label>
                          </div>
                          </div>
                      </div>
                  <!-- Botão de Enviar -->
                  <button type="submit" class="btn btn-primary" name="btnUpdate">Atualizar Perfil</button>
                  </div>
              </form>
              <script src="dist/js/jquery-3.7.1.min.js"></script>
    <script src="dist/js/jquery.validate.js"></script>
    <script src="dist/js/additional-methods.js"></script>
    <script src="dist/js/localization/messages_pt_BR.min.js"></script>
    <script src="dist/js/localization/messages_pt_BR.js"></script>
<script>
        jQuery(document).ready(function($){
            $("#formLogin").validate({
                rules:{
                    name: {
                      required: true,
                      maxlength: 100,
                        
                    },
                    email:{
                        required: true,
                        maxlength: 150,
                        email: true,
                    },
                    password:{
                        required: true,
                        rangelength: [6, 40],
                    },
                    cpassword:{
                        required: true,
                        equalTo: '#password'
                    }
                }
            })
        })
    </script>
<?php
    include_once("../config/conexao.php");

    if(isset($_POST["btnUpdate"])){
      
      if(!empty($_POST['nome'])){
        $new_name = $_POST["name"];
      }else{
        echo "<b>Nome: </b>Nenhum valor inserido, nenhuma mudança aplicada.";
        $new_name = $nome_user;
      }
      if(!empty($_POST['email'])){
        $new_email = $_POST["email"];
      }else{
        echo "<b>Nome: </b>Nenhum valor inserido, nenhuma mudança aplicada.";
        $new_email = $email_user;
      }
      if(!empty($_POST['password'])){
        $new_password = $_POST["password"];
      }else{
        $new_password = $senha_user;
        echo "<b>Senha: </b>Nenhum valor inserido, nenhuma mudança aplicada.";
      }
        $cpassword = $_POST["cpassword"];

        $select = "SELECT email_user, senha_user FROM tb_user WHERE id_user=:id_user";
        $resultado = $conexao->prepare($select);
        $resultado->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $resultado->execute();
        if($resultado->rowCount() > 0){
            $fetch = $resultado->fetch(PDO::FETCH_OBJ);
            $old_email = $fetch->email_user;
            $old_password = $fetch->senha_user;
        }
        if($new_password == $cpassword){
            $new_password = password_hash($new_password, PASSWORD_DEFAULT);

                if(!empty($_FILES['foto']['name'])){
                    $allowedFormats = array("png", "jpeg", "jpg", "gif");
                    $extention = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

                    if(in_array(strtolower($extention), $allowedFormats)){
                        $tmpFolder = $_FILES['foto']['tmp_name'];
                        $destiny = "../dist/img/user/";
                        $newUserPhoto = uniqid() . ".$extention";

                        if(file_exists($destiny . $foto_user)){
                            unlink($destiny . $foto_user);
                        }
                        if(move_uploaded_file($tmpFolder, $destiny . $newUserPhoto)){

                        }else{
                            echo"Falha no upload de arquivo!";
                            exit();
                        }
                    }else{
                        echo"Formato nao permitido!";
                        exit();
                    }
                }else{
                    $newUserPhoto = $foto_user;}
                
                if(!empty($_POST['email'])){
                  $new_email = $email_user;
                  echo "<b>Email: </b>Nenhum valor inserido, nenhuma mudança aplicada.";
                }
                
            try{
                $register = "UPDATE tb_user SET nome_user=:new_name, email_user=:new_email, senha_user=:new_password, foto_user=:newUserPhoto WHERE id_user=:user_id";

                $resultado = $conexao->prepare($register);
                $resultado->bindParam(':user_id', $id_user, PDO::PARAM_INT);
                $resultado->bindParam(':new_name', $new_name, PDO::PARAM_STR);
                $resultado->bindParam(':new_email', $new_email, PDO::PARAM_STR);
                $resultado->bindParam(':new_password', $new_password, PDO::PARAM_STR);
                $resultado->bindParam(':newUserPhoto', $newUserPhoto, PDO::PARAM_STR);
                $resultado->execute();

                if($resultado->rowCount() > 0){
                    echo "<div>Usuario atualizado com sucesso!</div>";
                    header("Refresh: 3, ../login.php");
                }else{
                    echo "<div>Não foi possivel efetuar o cadastro</div>";
                    header("Refresh: 3, home.php");
                }
                if ($new_email !== $old_email || $new_password !== $old_password) {
                    header("Location: ../login.php"); // Redireciona para sair se email ou senha foram alterados
                    exit(); // Garante que o redirecionamento ocorra
                } else {
                    header("Refresh: 3, home.php?atualizar_perfil"); // Redireciona de volta ao perfil após 3 segundos
                    exit(); // Garante que o redirecionamento ocorra
                }
            }catch(PDOException $err){
                echo "ERRO DE PDO: ". $err;
            }

        }else{
            echo "<div>Senhas nao batem!</div>";
            exit();
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
</body>
</html>