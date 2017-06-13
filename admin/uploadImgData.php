<?php
/*var_dump($_POST);
var_dump($_FILES);*/
if(!empty($_FILES)){

    require "../settings/FolderName.php";
    require "../".FolderDb."/db.php";
    $extensions = ['jpg','jpeg','png','gif'];
    $destination =
    $currentfile = $_FILES['files'];
    $errors = 0;
    $category = $_POST['category'] ?? "articles";
    for($i = 0;$i < count($currentfile['name']);$i++){
        if($currentfile['error'][$i] == 0 ){
            $tmp = explode('/',$currentfile['type'][$i]);
            $currentextension = strtolower($tmp[1]);
            if(in_array($currentextension,$extensions)){
                if(!file_exists('../img/'.$category.'/'.date('Y-m-d'))){
                    if(!mkdir('../img/'.$category.'/'.date('Y-m-d'),0777,true)){
                        $status['files'][$currentfile['name'][$i]] = ["message" => "Erreur serveur, merci de nous contacter" , "status" => "error"];
                        $errors++;
                        continue;
                    }
                }
                $exec = $pdo->prepare("INSERT INTO Image(folder) VALUES(:articles)");
                $exec->bindValue(':articles',$category);
                $exec->execute();
                $idImg = $pdo->lastInsertId();
                $nom = "../img/".$category."/".date('Y-m-d')."/".date('Ymd')."-".sprintf('%04d',$idImg).".png";
                if(!move_uploaded_file($currentfile['tmp_name'][$i],$nom)){
                    $exec = $pdo->prepare("DELETE FROM Image WHERE id=:id");
                    $exec->bindParam(':id',$idImg,PDO::PARAM_INT);
                    $exec->execute();
                    $status['files'][$currentfile['name'][$i]] = ["message" => "L'upload du fichier à échoué" , "status" => "error"];
                    $errors++;
                    continue;
                }
            }else{
                $status['files'][$currentfile['name'][$i]] = ["message" => "Le format du fichier est incorrecte, sont accepté png,jpg,jpeg,gif" , "status" => "error"];
                $errors++;
                continue;
            }
        }else{
            $status['files'][$currentfile['name'][$i]] = ["message" => "L'upload du fichier à échoué" , "status" => "error"];
            $errors++;
            continue;
        }

    }
    $status['errors'] = $errors;
    echo json_encode($status);
}

