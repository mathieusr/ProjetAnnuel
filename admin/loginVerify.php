<?php
require "../conf/confFolderName.php";
require "../".FolderConfConn."/confConn.php";
require "../".FolderConf."/lib.php";
require "../".FolderConf."/functions.php";
$error=false;

session_start();
unset($_POST['login']);
if( isset($_POST["email"]) &&
isset($_POST["pwd"]) &&
count($_POST)== 2
){
//trim
    $_POST["email"] = trim($_POST["email"]);
    $exec = $pdo->prepare("SELECT firstName+' '+lastName AS fullName,id,email,password,roleid FROM USERS WHERE email=:email AND isactive=1");
    $exec->bindValue(':email',$_POST['email'],PDO::PARAM_STR);
    $exec->execute();
    $userdetails = $exec->fetch(PDO::FETCH_ASSOC);

    if(password_verify($_POST['pwd'],$userdetails['password'])){
        $_SESSION['userInformation'] = $userdetails;
        header('Location: ../index.php');
    }else{
        $_SESSION['form_post'] = $_POST;
        $_SESSION['status']['danger'][] = $messageerrors[13];
        header('Location: login.php');
        exit();
    }

}else{
    echo "Bien essayé !";
}