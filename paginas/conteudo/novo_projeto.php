<form method="post">
    <label for="nomeProjeto">Nome do projeto:</label><br>
    <input type="text" name="nomeProjeto"><br>

    <label for="desc">Descrição do projeto:</label><br>
    <input type="text" name="desc"><br>

    <label for="banner">Banner do projeto:</label><br>
    <input type="file" name="banner"><br>
    <button type="submit" name="btnCreate">Criar</button>
</form>

<?php
    include_once('../../config/conexao.php');
    
    if(isset($_POST['btnCreate'])){
        $nomeProjeto = $_POST['nomeProjeto'];
        $descProjeto= $_POST['desc'];
        $bannerProjeto = $_FILES['banner'];

        if (!empty($_FILES['foto']['name'])) {
            $formatosPermitidos = array("png", "jpg", "jpeg", "gif"); // Formatos permitidos
            $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION); // Obtém a extensão do arquivo
    
            // Verifica se a extensão do arquivo está nos formatos permitidos
            if (in_array(strtolower($extensao), $formatosPermitidos)) {
                $pasta = "img/"; // Define o diretório para upload
                $temporario = $_FILES['foto']['tmp_name']; // Caminho temporário do arquivo
                $bannerProjeto = uniqid() . ".$extensao"; // Gera um nome único para o arquivo
    
                // Move o arquivo para o diretório de imagens
                if (move_uploaded_file($temporario, "../../dist/img/" . $bannerProjeto)) {
                    // Sucesso no upload da imagem
                } else {
                    echo '<div class="container">
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-exclamation-triangle"></i> Erro!</h5>
                                Não foi possível fazer o upload do arquivo.
                            </div>
                        </div>';
                    exit(); // Termina a execução do script após o erro
                }
            } else {
                echo '<div class="container">
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Formato Inválido!</h5>
                            Formato de arquivo não permitido.
                        </div>
                    </div>';
                exit(); // Termina a execução do script após o erro
            }
        } else {
            // Define um avatar padrão caso não seja enviado nenhum arquivo de foto
            $bannerProjeto = 'avatar-padrao.png'; // Nome do arquivo de avatar padrão
        }
        


        $insertProject = "INSERT INTO tb_project (nome_projeto, descricao_projeto, banner_projeto) VALUES (:nomeProjeto, :descProjeto, :bannerProjeto)";

        $resultado = $conexao->prepare(($insertProject));
        $resultado->bindParam(':nomeProjeto', $nomeProjeto, PDO::PARAM_STR);
        $resultado->bindParam(':descProjeto', $descProjeto, PDO::PARAM_STR);
        $resultado->bindParam(':bannerProjeto', $bannerProjeto, PDO::PARAM_STR);
        $resultado->execute();

        if($resultado->rowCount() > 0){
            echo "dados inseridos com sucesso";
        }else{
            echo "dados nao inseridos";
        }

        
    }

?>
