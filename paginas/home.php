<?php
  include_once('../includes/header.php');
  if(isset($_GET['section'])){
    $section = $_GET['section'];
    
    if($section == 'novo_projeto'){
      include_once('conteudo/cadastroProjetos.php');
    }
    elseif($section == 'update_projeto'){
      include_once('conteudo/update_projeto.php');
    }
    elseif($section == 'del_projeto'){
      include_once('conteudo/del-projeto.php');
    }
    elseif($section == 'update_perfil'){
      include_once('conteudo/update_perfil.php');
    }
    else{
      include_once('conteudo/test_view.php');

    }
  }else{
    include_once('conteudo/test_view.php');

  }
  
  include_once('../includes/footer.php');