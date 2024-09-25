<?php
  include_once('../includes/header.php');
  if(isset($_GET['action'])){
    $action = $_GET['action'];
    
    if($action == 'novo_projeto'){
      include_once('conteudo/cadastroProjetos.php');
    }
    elseif($action == 'update_projeto'){
      include_once('conteudo/update_projeto.php');
    }
    elseif($action == 'del_projeto'){
      include_once('conteudo/del-projeto.php');
    }
    elseif($action == 'update_perfil'){
      include_once('conteudo/update_perfil.php');
    }
    else{
      include_once('conteudo/test_view.php');

    }
  }else{
    include_once('conteudo/test_view.php');

  }
  
  include_once('../includes/footer.php');