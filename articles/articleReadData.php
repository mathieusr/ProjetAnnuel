<?php
if(empty($_GET['articleId'])){
    header('Location : ../index.php');
    exit();
}

$exec = $pdo->prepare("SELECT text,NEWS.id,title,presentationImg,isPublish,CONVERT(varchar,IMAGE.dateCreation,112) AS dateCreation,CONVERT(date,IMAGE.dateCreation,120) AS dateCreation2,NEWS.dateModification AS dateCreation3 FROM NEWS LEFT JOIN IMAGE ON NEWS.presentationImg = IMAGE.id WHERE NEWS.Id=:id");
$exec->bindParam(':id',$_GET['articleId']);
$exec->execute();
$article = $exec->fetch(PDO::FETCH_ASSOC);
setlocale (LC_TIME, 'fr_FR.utf8','fra');