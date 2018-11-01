<?php
require "Controllers/Database.php";
require "Controllers/CategoriaDao.php";

$target_dir = "Images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if (isset($_POST["addCat"]) && $_POST["nome"] != ""){ // Adicionou categoria

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Erro: Arquivo já existe";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "Erro: Somente  os formatos JPG, JPEG, PNG e GIF são suportados";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "Upload do arquivo ". basename( $_FILES["fileToUpload"]["name"]). " foi concluído com sucesso";
        } else {
            echo "Erro ao fazer upload";
        }
        $cat = new Categoria($_POST["nome"], basename( $_FILES["fileToUpload"]["name"]));
        $dao_c->insert($cat);
    }
}
header("Location: admin.php");

?>
