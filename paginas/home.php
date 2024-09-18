<?php
  include_once('../includes/header.php');
  if(isset($_GET['section'])){
    if($_GET['section' == 'perfil']){
      include_once('../paginas/conteudo/perfil.php');
    }
    elseif($_GET['section' == 'update_perfil.php']){
      include_once('../paginas/conteudo/update_perfil.php');
    }
    elseif($_GET['section' == 'novo_projeto']){
      include_once('../paginas/conteudo/novo_projeto.php');
    }
    elseif($_GET['section' == 'update_projeto']){
      include_once('../paginas/conteudo/update_projeto.php');
    }

  }
  include_once('conteudo/cadastroProjetos.php')
  include_once('../includes/footer.php');

