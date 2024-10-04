<?php 
  ob_start();
  session_start();
  if(!isset($_SESSION['LoginUser']) && (!isset($_SESSION['senhaLogin']))){
    header("Location: ../login.php");
    exit;
  }
  if(isset($_REQUEST['sair'])){
    session_destroy();
    header("Location: ../login.php");
  }
  if(isset($_GET['category'])){
    $category = $_GET['category'];
  }

?>

<?php 

include_once("../config/conexao.php");

$usuarioLogado = $_SESSION['LoginUser'];

$select = "SELECT * FROM tb_user WHERE email_user = :usuarioLogado OR nome_user = :usuarioLogado";

$resultado = $conexao->prepare($select);

$resultado->bindParam(':usuarioLogado', $usuarioLogado, PDO::PARAM_STR);

$resultado->execute();

if($resultado->rowCount() > 0){
  $show = $resultado->fetch(PDO::FETCH_OBJ);

  $id_user = $show->id_user;
  $nome_user = $show->nome_user;
  $email_user = $show->email_user;
  $foto_user = $show->foto_user;
}

?>
<!DOCTYPE html>
<html lang="pt_br">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Gestor de projetos</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <?php if(isset($_GET['action']) || isset($_GET['category'])){
          echo '<a href="home.php" class="nav-link">Home</a>';
        }else{
         echo '<a href="?action=novo_projeto" class="nav-link">Criar Projeto</a>';

        } ?>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../paginas/calendar.html" class="nav-link">Calendário</a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" title="Perfil e Saída">
          <i class="far fa-user"></i>

        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a <?php echo 'href="?action=update_perfil&idUpdate=' . $id_user . '"'?> class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> ALterar Perfil
            <!-- Espaço para o item aqui -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="?sair" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> Logout

          </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <!--<img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8"> -->
      <span class="brand-text font-weight-light">Gestor de Projetos</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php
            if($foto_user == 'default-photo.png'){
              echo '<img src="../dist/img/user/default-user/default-photo.png" class="img-circle elevation-2 ">';
            }else{
              echo '<img src="../dist/img/user/'.$foto_user.'" class="img-circle elevation-2 ">';
            }
          ?>
        </div>
        <div class="info">
          <a <?php echo 'href="?action=update_perfil&idUpdate=' . $id_user . '"'?> class="d-block"><?php echo $show->nome_user?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
               <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Categorias
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item active">
                <a href="?category=faculdade" class="nav-link <?php if(isset($_GET['category'])){ if($category == 'faculdade'){ echo "active"; } } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Faculdade</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="?category=trabalho" class="nav-link <?php if(isset($_GET['category'])){ if($category == 'trabalho'){ echo "active"; } } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Trabalho</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?category=projeto_pessoal" class="nav-link <?php if(isset($_GET['category'])){ if($category == 'projeto_pessoal'){ echo "active"; } } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Projeto Pessoal</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="pages/widgets.html" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Arquivadas
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="pages/widgets.html" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Lixeira
              </p>
            </a>
          </li>
              
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>