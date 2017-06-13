<?php
if(!empty($_GET['action'])){
    /* Action à réaliser pour supprimer un utilisateur */
    if($_GET['action']=='deleteuser' && !empty($_GET['id'])) {
        $exec = $pdo->prepare("DELETE FROM USERS WHERE Id=:id");
        $exec->execute([':id' => $_GET['id']]);
        header('Location: adminUsers.php');
    }
    /* Action à réaliser pour désactiver un utilisateur */
    if($_GET['action']=='disableuser' && !empty($_GET['id'])) {
        $exec = $pdo->prepare("UPDATE USERS SET statusId=0 WHERE Id=:id");
        $exec->execute([':id' => $_GET['id']]);
        header('Location: adminUsers.php');
    }
    /* Action à réaliser pour activer un utilisateur */
    if($_GET['action']=='enableuser' && !empty($_GET['id'])) {
        $exec = $pdo->prepare("UPDATE USERS SET statusId=1 WHERE Id=:id");
        $exec->execute([':id' => $_GET['id']]);
        header('Location: adminUsers.php');
    }
    /* Action à réaliser pour modifer un utilisateur */
    if($_GET['action']=='modifyuser' && !empty($_GET['id'])) {
        $exec = $pdo->prepare("SELECT birthday,email,firstName,lastName,adress,postCode,city,phoneNumber,weight,height,shirtNumber,identitypicture,roleId FROM USERS WHERE Id=:id");
        $exec->execute([':id' => $_GET['id']]);
        $modify = $exec->fetch(PDO::FETCH_ASSOC);
    }
}

if(!empty($_POST)){
    /* Action à réaliser pour modifer un utilisateur */
    /* A chaque if on vérifie si la donnée est présente. Si oui, on l'intègre à la requete sinon non */
    if($_POST['action']=="modifyusers" && !empty($_GET['id'])){
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        $requete="UPDATE USERS SET isActive=1";
        if(isset($_POST['email'])){
            $values['email']=$_POST['email'];
            $requete.=",email=:email";
        }
        if(isset($_POST['firstname'])){
            $values['firstname']=$_POST['firstname'];
            $requete.=",firstName=:firstname";
        }
        if(isset($_POST['lastname'])){
            $values['lastname']=$_POST['lastname'];
            $requete.=",lastName=:lastname";
        }
        if(isset($_POST['birthday'])){
            $requete.=",birthday=CONVERT(datetime,'".$_POST['birthday']."',120)";
        }
        if(isset($_POST['adress'])){
            $values['adress']=$_POST['adress'];
            $requete.=",adress=:adress";
        }
        if(isset($_POST['postcode'])){
            $values['postcode']=$_POST['postcode'];
            $requete.=",postCode=:postcode";
        }
        if(isset($_POST['city'])){
            $values['city']=$_POST['city'];
            $requete.=",city=:city";
        }
        if(isset($_POST['phonenumber'])){
            $values['phonenumber']=$_POST['phonenumber'];
            $requete.=",phoneNumber=:phonenumber";
        }
        if(isset($_POST['role'])){
            $values['role']=(int)$_POST['role'];
            $requete.=",roleId=:role";
        }
        if(isset($_POST['weight'])){
            $values['weight']=(int)$_POST['weight'];
            $requete.=",weight=:weight";
        }
        if(isset($_POST['height'])){
            $values['height']=(int)$_POST['height'];
            $requete.=",height=:height";
        }
        if(isset($_POST['shirtnumber'])){
            $values['shirtnumber']=(int)$_POST['shirtnumber'];
            $requete.=",shirtNumber=:shirtnumber";
        }
        if(isset($_POST['identitypicture'])){
            $values['identitypicture']=$_POST['identitypicture'];
            $requete.=",identityPicture=:identitypicture";
        }
        $requete.=" WHERE Id=:id";
        $values['id'] = $_GET['id'];
        print_r($values);
        $exec=$pdo->prepare($requete);
        $exec->execute($values);


        $exec = $pdo->prepare("SELECT firstName+' '+lastName AS fullName,id,email,password,roleid FROM USERS WHERE id =:id AND isactive=1");
        $exec->bindValue(':id',$_SESSION['userInformation']['id'],PDO::PARAM_STR);
        $exec->execute();
        $userdetails = $exec->fetch(PDO::FETCH_ASSOC);
        $_SESSION['userInformation'] = $userdetails;
        header('Location: adminUsers.php');
    }
}

/* On récupère tous les utilisateurs actif */
$exec = $pdo->query("SELECT
                          id
                          ,email
                          ,firstName
                          ,lastName
                          ,statusId
                          ,roleId
                          FROM USERS");
$users = $exec->fetchAll(PDO::FETCH_ASSOC);

/* On récupère tous les différents role */
$exec = $pdo->query("SELECT id,name FROM ROLE");
$roles=$exec->fetchAll(PDO::FETCH_ASSOC);
