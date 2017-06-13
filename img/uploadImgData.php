<?php
if(!empty($_FILES)){
    $extensions = ['jpg','jpeg','png','gif'];
    $destination =
    $currentfile = $_FILES['articleImg'];
    if($currentfile['error'] == 0 ){
        $tmp = explode('/',$currentfile['type']);
        $currentextension = strtolower($tmp[1]);
        if(in_array($currentextension,$extensions)){
            if(!file_exists('../img/articles/'.date('Y-m-d'))){
                mkdir('../img/articles/'.date('Y-m-d'));
            }
            $exec = $pdo->query("INSERT INTO Image(folder) VALUES('articles')");
            $idImg = $pdo->lastInsertId();
            $nom = "../img/articles/".date('Y-m-d')."/".date('Ymd')."-".sprintf('%04d',$idImg).".png";
            $move = move_uploaded_file($currentfile['tmp_name'],$nom);
            if(!$move){
                $exec = $pdo->prepare("DELETE FROM Image WHERE id=:id");
                $exec->bindParam(':id',$idImg,PDO::PARAM_INT);
                $exec->execute();
            }else if($move){
                $_SESSION['status']['success'][] = "Votre fichier à bien été uploadé";
                header('Location: uploadImg.php');
            }
        }else{
            $_SESSION['status']['danger'][] = "Le format du fichier est incorrecte, sont accepté png,jpg,jpeg,gif";
            header('Location: uploadImg.php');
        }
    }else{
        $_SESSION['status']['danger'][] = "L'upload du fichier à échoué";
        header('Location: uploadImg.php');
    }
    var_dump($_FILES);
    unset($_FILES);
}

