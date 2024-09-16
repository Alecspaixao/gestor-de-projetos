<?php
  include_once('../includes/header.php');
  if(isset($_GET['section'])){
    $section = $_GET['section'];
    if($section == 'perfil'){
      include_once('conteudo/perfil.php');
    }
    elseif($section == 'novo_projeto'){
      include_once('conteudo/novo_projeto.php');
    }
    elseif($section == 'atualizar_perfil'){
      include_once('conteudo/update_perfil.php');
    }
    else{
      include_once('conteudo/cadastroProjetos.php');
    }

  }

  include_once('../includes/footer.php');

