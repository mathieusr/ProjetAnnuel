<?php
require "../confConn/confConn.php";
session_start();
if(!empty($_GET['token']) && !empty($_GET['id'])){
    $token = $_GET['token'];
    $userId =(int) $_GET['id'];
}
$exec = $pdo->prepare("SELECT id,validationtoken FROM USERS WHERE id=:id");
$exec->bindParam('id',$userId);
$exec->execute();
$info = $exec->fetch(PDO ::FETCH_ASSOC);
if(!empty($info) && $info['validationtoken'] == $token){
        $exec = $pdo->prepare("UPDATE USERS SET validationtoken=NULL,isactive=1,datemodification=GETDATE() WHERE id=:id");
    $exec->bindParam('id',$info['id'],PDO::PARAM_INT);
    $exec->execute();
    $_SESSION['status']['success'][]="Votre compte est maintenant validé et vous pouvez profiter de tous nos contenus et services";
    header('Location: ../index.php');

}else{
    $_SESSION['status']['danger'][] = "L'addresse de confirmation de compte n'est pas valide";
    header('Location: ../index.php');
}