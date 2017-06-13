<?php
require "../settings/FolderName.php";
require "../".FolderDb."/db.php";
require "../".FolderSettings."/lib.php";
require "../".FolderSettings."/functions.php";
$error=false;

unset($_POST['login']);
session_start();
if( isset($_POST["email"]) &&
isset($_POST["firstname"]) &&
isset($_POST["lastname"]) &&
isset($_POST["pwd"]) &&
isset($_POST["pwd2"]) &&
isset($_POST["birthday"]) &&
isset($_POST["adress"]) &&
isset($_POST["postcode"]) &&
isset($_POST["city"])  &&
isset($_POST["phonenumber"])  &&
count($_POST) >= 10 &&  count($_POST) <=11
){
//trim
$_POST["firstname"] = trim($_POST["firstname"]);
$_POST["email"] = trim($_POST["email"]);
$_POST["lastname"] = trim($_POST["lastname"]);


    //Nom et prenom : entre 3 et 60
    $nbCharPseudo = strlen($_POST["firstname"]);
    if($nbCharPseudo < 3 || $nbCharPseudo > 60 ){
    $error = true;
    $listoferrors[]= 1;
    }
    $nbCharPseudo = strlen($_POST["lastname"]);
    if($nbCharPseudo < 3 || $nbCharPseudo > 60 ){
        $error = true;
        $listoferrors[]= 2;
    }

    //Email : soit valide
    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) || empty($_POST["email"]) ){
        $error = true;
        $listoferrors[]=3;
    }


    //pwd : entre 8 et 16 caractères
    $nbCharPwd = strlen($_POST["pwd"]);
    if($nbCharPwd < 6 || $nbCharPwd > 16 ){
        $error = true;
        $listoferrors[]=4;
    }

    //pwd2 : �gale avec pwd
    if($_POST["pwd"] != $_POST["pwd2"]){
    $error = true;
    $listoferrors[]=5;
    }



    $explodeArray = explode("-", $_POST["birthday"]);
    if( count($explodeArray)!=3 ||
    !is_numeric($explodeArray[0]) || !is_numeric($explodeArray[1]) || !is_numeric($explodeArray[2]) ||
    !checkdate($explodeArray[1], $explodeArray[2], $explodeArray[0])){

        $error = true;
        $listoferrors[]=6;
    }

    if(empty($_POST["adress"]) || strlen($_POST["adress"])>250){
        $error = true;
        $listoferrors[]=7;
    }

    if(empty($_POST["city"]) || strlen($_POST["adress"])>200){
        $error = true;
        $listoferrors[]=8;
    }

    if(empty($_POST["postcode"]) || !is_numeric($_POST["postcode"])){
        $error = true;
        $listoferrors[]=9;
    }
    if(empty($_POST["phonenumber"]) || !is_numeric($_POST["phonenumber"]) || strlen($_POST["phonenumber"])>10){
        $error = true;
        $listoferrors[]=10;
    }

    if(!isset($_POST["cgu"])){
        $error = true;
        $listoferrors[]=11;
    }


    if(!$error) {

        // Verification de l'email
        $exec = $pdo->prepare("SELECT Id FROM USERS WHERE email=:email");
        $exec->bindParam(':email', $_POST["email"], PDO::PARAM_STR);
        $exec->execute();
        $resultemail = $exec->fetch();
        if (!empty($resultemail)) {
            $error = true;
            $listoferrors[] = 12;
        }

    }
    if ($error) {
        $_SESSION['form_post'] = $_POST;
        foreach($listoferrors as $value){
            if(!empty($value)){
                $_SESSION['status']['danger'][] = $messageerrors[$value];
            }

        }

        header('Location: register.php');
        exit();
    } else {

        $key = randowkey(60);

        $content =
        $passwordhash = password_hash($_POST['pwd'], PASSWORD_BCRYPT);
        $exec = $pdo->prepare("INSERT INTO users(email,firstName,lastName,password,birthday,adress,postCode,city,phoneNumber,validationtoken,isactive)
                                    VALUES (:email,:firstname,:lastname,:password,:birthday,:adress,:postcode,:city,:phonenumber,:token,0)");
        $exec->bindParam(':email', $_POST["email"]);
        $exec->bindParam(':firstname', $_POST["firstname"]);
        $exec->bindParam(':lastname', $_POST["lastname"]);
        $exec->bindParam(':password', $passwordhash);
        $exec->bindParam(':birthday', $_POST['birthday']);
        $exec->bindParam(':adress', $_POST['adress']);
        $exec->bindParam(':postcode', $_POST['postcode']);
        $exec->bindParam(':city', $_POST['city']);
        $exec->bindParam(':phonenumber', $_POST['phonenumber']);
        $exec->bindParam(':token',$key);
        $exec->execute();
        $userId = $pdo->lastInsertId();
        sendmail($_POST['email'],'Validation de votre compte',"Votre inscription a bien été prise en compte. Pour valider votre compte merci de vous rendre sur le lien suivant:<br><a href='{$_SERVER['HTTP_HOST']}/".FolderAdmin."/requestValidation.php?id={$userId}&token={$key}'>Valider mon compte</a>");
        $_SESSION['status']['success'][]="Votre inscription à été prise en compte, pour activer votre compte, veuillez suivre les instructions que vous allez recevoir par mail";
        $_SESSION['status']['success'][]="{$_SERVER['HTTP_HOST']}/".FolderAdmin."/requestValidation.php?id={$userId}&token={$key}";
        header('Location: ../index.php');
        header('Location: ../index.php');
    }
}else{
    header('Location: register.php');
}
