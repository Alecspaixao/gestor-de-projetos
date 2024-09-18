
<?php
    include_once('../config/conexao.php');
    $timezone = new DateTime('now', new DateTimeZone('America/Fortaleza'));
    
    echo $timezone->format('Y-m-d H:i:s');

    $selectUltUp = "SELECT UltUpdate_projeto FROM tb_project WHERE id_user = :id_user";
    $resultado = $conexao->prepare($selectUltUp);
    $resultado->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $resultado->execute();

    if($resultado->rowCount() > 0){
        $show = $resultado->fetch(PDO::FETCH_OBJ);
        $ultUpdate = $show->UltUpdate_projeto;
        echo $ultUpdate;
        echo date('d/m/Y');
        }
    ?>
    <div style="display: flex; margin-left: auto;">
<form method="post" style="margin-left: auto;" enctype="multipart/form-data" id="formPro">
    <label for=":projectName">Nome do projeto:</label><br>
    <input type="text" name="projectName" id="name"><br>

    <label for="desc">Descrição do projeto:</label><br>
    <input type="text" name="desc" id="desc"><br>

    <label for="banner">Banner do projeto:</label><br>
    <input type="file" name="banner">
    <input type="text" hidden name="id_user" value=<?php echo $id_user?>>
    <button type="submit" name="btnCreate">Criar</button>
</form>
</div>
<?php 

    $select = "SELECT * FROM tb_project WHERE id_user = :id_user ORDER BY id_project DESC LIMIT 6";
    ;
    try{
        $resultado = $conexao->prepare($select);
        $resultado->bindParam(':id_user' ,$id_user, PDO::PARAM_INT);
        $resultado->execute();

        if($resultado->rowCount() > 0){
            while($show = $resultado->fetch(PDO::FETCH_OBJ)){
    ?>
            <div style="background-color: gray; margin-left: 50%;">
                <h1><?php echo $show->nome_projeto ?></h1>
                <p><?php echo $show->descricao_projeto ?></p>
                <p><?php echo $show->UltUpdate_projeto?></p>
                <?php
                if($show->banner_projeto != 'default-banner.jp'){
                    echo '<img src="../dist/img/banner/' . $show->banner_projeto . '">';}
                else{
                    echo '<img src="../dist/img/banner/default-banner/default-banner.jpg"';}?>
                <a <?php echo 'href="home.php?section=update_projeto&idUpdate=' . $show->id_project . '"'?>>Atualizar</a>
                <a <?php echo 'href="home.php?section=del_projeto&idDel=' . $show->id_project . '"'?> onclick="return confirm('AVISO! Esta ação nao pode ser desfeita!')">Excluir</a>




            </div>
    <?php
            }
        }
            
    }catch(PDOException $err){
        echo "ERRO DE PDO:" . $err;
    }
?>
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
    $id_user = $_POST['id_user'];

    if(isset($_FILES['banner'])){
        

        if (!empty($_FILES['banner']['name'])) {
            $allowedFormats = array("png", "jpg", "jpeg");
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
            $projectBanner = 'default-banner.jpg';
        }
    }else{
        echo "foto nao enviada!!!!!";
    }
        try{
            $insertProject = "INSERT INTO tb_project (nome_projeto, descricao_projeto, banner_projeto, id_user) VALUES (:projectName, :projectDesc, :projectBanner, :id_user)";

            $resultado = $conexao->prepare($insertProject);
            $resultado->bindParam(':projectName', $projectName, PDO::PARAM_STR);
            $resultado->bindParam(':projectDesc', $projectDesc, PDO::PARAM_STR);
            $resultado->bindParam(':projectBanner', $projectBanner, PDO::PARAM_STR);
            $resultado->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            $resultado->execute();

            if($resultado->rowCount() > 0){
                header('Location: home.php?section=novo_projeto');
            }else{
                echo "dados nao inseridos";
            }
        }catch(PDOException $err){
            echo "ERRO DE PDO: ". $err;
        }
        
}

?>



