<?php
require "../confConn/confConn.php";
require "../conf/lib.php";
require "../conf/functions.php";
session_start();

if(!empty($_POST['email'])){
    $exec = $pdo->prepare("SELECT id,email FROM USERS WHERE email=:email AND isactive=1");
    $exec->bindValue(':email',$_POST['email'],PDO::PARAM_STR);
    $exec->execute();
    $userdetails = $exec->fetch(PDO::FETCH_ASSOC);
    if(!empty($userdetails)){
        $key = randowkey(120);
        $exec = $pdo->prepare("UPDATE USERS SET passwordtoken=:token,passworddate=NOW() WHERE id=:id");
        $exec->bindParam(':token',$key);
        $exec->bindParam(':id',$userdetails['id']);
        $exec->execute();
        sendmail($userdetails['email'],'Réinitialisation de votre mot de passe',"Pour réinitialiser votre mot de passe, merci de suivre le lien suivant:<br><a href='{$_SERVER['HTTP_HOST']}/projetAnnuel/admin/requirePasswordVerify.php?id={$userdetails['id']}&token={$key}'>Réinitialiser mon mot de passe</a>");
        $_SESSION['status']['success'][] = "Un mail de réinitialisation vous a été envoyé, il est valide 30 minutes";
        header('Location: ../index.php');
    }else{
        $_SESSION['status']['danger'][] = $messageerrors[14];
        $_SESSION['form_post'] = $_POST;
        header('Location: requirePassword.php');
    }
}else{
    $_SESSION['status']['danger'][] = $messageerrors[3];
    $_SESSION['form_post'] = $_POST;
    header('Location: requirePassword.php');
}