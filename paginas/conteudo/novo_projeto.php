
<?php
    include_once('../config/conexao.php');
    $timezone = new DateTime('now', new DateTimeZone('America/Fortaleza'));
    echo $timezone->format('Y-m-d H:i:s');
?>
    <div style="display: flex; margin-left: auto;">
<form method="post" style="margin-left: auto;" enctype="multipart/form-data">
    <label for=":projectName">Nome do projeto:</label><br>
    <input type="text" name=":projectName"><br>

    <label for="desc">Descrição do projeto:</label><br>
    <input type="text" name="desc"><br>

    <label for="banner">Banner do projeto:</label><br>
    <input type="file" name="banner">
    <input type="text" hidden name="id_user" value=<?php echo "$id_user"?>>
    <button type="submit" name="btnCreate">Criar</button>
</form>
</div>
<?php
    
if(isset($_POST['btnCreate'])){
    $projectName = $_POST[':projectName'];
    $projectDesc= $_POST['desc'];
    $id_user = $_POST['id_user'];

    if(isset($_FILES['banner'])){
        

        if (!empty($_FILES['banner']['name'])) {
            $allowedFormats = array("png", "jpg", "jpeg", "gif");
            $extention = pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION);

            if (in_array(strtolower($extention),$allowedFormats)) {
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
            $projectBanner = 'banner-padrao.png';
        }
    }else{
        echo "foto nao enviada!!!!!";
    }
        


        $insertProject = "INSERT INTO tb_project (nome_projeto, descricao_projeto, banner_projeto, id_user) VALUES (:projectName, :projectDesc, :projectBanner, :id_user)";

        $resultado = $conexao->prepare(($insertProject));
        $resultado->bindParam(':projectName', $projectName, PDO::PARAM_STR);
        $resultado->bindParam(':projectDesc', $projectDesc, PDO::PARAM_STR);
        $resultado->bindParam(':projectBanner', $projectBanner, PDO::PARAM_STR);
        $resultado->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $resultado->execute();

        if($resultado->rowCount() > 0){
            echo "dados inseridos com sucesso";
        }else{
            echo "dados nao inseridos";
        }
}

?>



