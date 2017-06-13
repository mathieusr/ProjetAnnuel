<?php
$minrole = 0;
require "../conf/header.php";
require "../confConn/confConn.php";
require "../conf/lib.php";
require "../conf/functions.php";

if(!empty($_GET['token']) && !empty($_GET['id'])){
    $token = $_GET['token'];
    $userId =(int) $_GET['id'];

    $exec = $pdo->prepare("SELECT id,passwordtoken FROM USERS WHERE id=:id AND DATE_PART('day', current_timestamp - passworddate) * 24 + DATE_PART('hour', current_timestamp - passworddate) * 60 + DATE_PART('minute', current_timestamp - passworddate) < 30 ");
    $exec->bindParam('id',$userId);
    $exec->execute();
    $info = $exec->fetch(PDO ::FETCH_ASSOC);
    if(!empty($info) && $info['passwordtoken'] == $token){
        if(!empty($_POST['pwd']) && !empty($_POST['pwd2']) && $_POST['pwd'] == $_POST['pwd2'] && strlen($_POST['pwd']) >= 6 && strlen($_POST['pwd']) <= 16 ){
            $password = password_hash($_POST['pwd'],PASSWORD_BCRYPT);
            var_dump($password);
            $exec = $pdo->prepare("UPDATE USERS SET passwordtoken=NULL,datemodification=NOW(),password=:pwd,passworddate=NOW() WHERE id=:id");
            $exec->bindParam('id',$info['id']);
            $exec->bindParam('pwd',$password);
            $exec->execute();
            $_SESSION['status']['success'][]="Votre mot de passe a bien été modifié";

            $exec = $pdo->prepare("SELECT firstname||' '||lastname AS fullname,id,email,password,roleid FROM USERS WHERE id=:id AND isactive=1");
            $exec->bindValue(':id',$info['id'],PDO::PARAM_STR);
            $exec->execute();
            $userdetails = $exec->fetch(PDO::FETCH_ASSOC);

            $_SESSION['userInformation'] = $userdetails;
            header('Location: ../index.php');
            exit();
        }else{
            $_SESSION['status']['danger'][] = "Les mots de passe doivent correspondre et faire en 6 et 16 caractères";
        }
//
    }else{
        $_SESSION['status']['danger'][] = "La clé de réinitialisation n'est plus valide";
        header('Location: ../index.php');
        exit();
    }



}else{
    header('Location: ../index.php');
    exit();
}


?>
<div class="row">
    <h3>Connexion</h3>
    <form method="POST" class="col-md-12">
        <div class="form-group">
            <label for="categoryname">Mot de passe</label>
            <input type="password" class="form-control" name="pwd" id="usersmail" placeholder="Mot de passe">
        </div>
        <div class="form-group">
            <label for="categorurl">Confirmation mot de passe</label>
            <input type="password" class="form-control" name="pwd2" placeholder="Confirmation mot de passe">
        </div>
        <button style="margin-top:10px;" type="submit" class="btn btn-primary btn-block">Valider</button>
    </form>

</div>
<?php require "../conf/footer.php"?>
