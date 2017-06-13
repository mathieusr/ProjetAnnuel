<?php
if(!empty($_GET['action'])){
    if($_GET['action']=='delete' && !empty($_GET['id'])) {
        echo "yes";
        $exec = $pdo->prepare("DELETE FROM TITLEANDLINK WHERE Id=:id");
        $exec->execute([':id' => $_GET['id']]);
        header('Location: adminModule.php');
    }
    if($_GET['action']=="modifymod" && !empty($_GET['id'])){
        $exec = $pdo->prepare("SELECT
              T1.id
              ,T1.category
              ,T1.name
              ,T1.folder
              ,T1.minrole
              FROM TITLEANDLINK AS T1
              WHERE Id=:id");
        $exec->execute([':id'=>$_GET['id']]);
        $modify = $exec->fetch(PDO::FETCH_ASSOC);
    }
    if($_GET['action']=="modifycat" && !empty($_GET['id'])){
        $exec = $pdo->prepare("SELECT
              T1.id
              ,T1.name
              ,T1.folder
              FROM TITLEANDLINK AS T1
              WHERE Id=:id");
        $exec->execute([':id'=>$_GET['id']]);
        $modify = $exec->fetch(PDO::FETCH_ASSOC);
    }
}
if(!empty($_POST)){
    if($_POST['action']=="add"){
        //    Insertion d'un nouveau module ou d'une nouvelle catégorie
        if(isset($_POST['category'])){
            $values['category']=$_POST['category'];
            $_POST['category']=null;
        }else{
            $values['category']=null;
        }
        if(isset($_POST['name'])){
            $values['name']=$_POST['name'];
            $_POST['name']=null;
        }else{
            $values['name']=null;
        }

        if(isset($_POST['folder'])){
            $values['folder']=$_POST['folder'];
            $_POST['folder']=null;
        }else{
            $values['folder']=null;
        }
        if(isset($_POST['type'])){
            $values['type']=$_POST['type'];
            $_POST['type']=null;
        }else{
            $values['type']=null;
        }
        if(isset($_POST['minrole'])){
            $values['minrole']=$_POST['minrole'];
            $_POST['minrole']=null;
        }else{
            $values['minrole']= null;
        }
        $exec=$pdo->prepare("INSERT INTO TITLEANDLINK(category,name,folder,type,MinRole) VALUES(:category,:name,:folder,:type,:minrole)");
        $exec->execute($values);
        unset($_POST);
        header('Location: adminModule.php');
    }
    if($_POST['action']=="modifymod" && !empty($_GET['id'])){
        $requete="UPDATE TITLEANDLINK SET type=2";
        if(isset($_POST['category'])){
            $values['category']=$_POST['category'];
            $requete.=",category=:category";
            $_POST['category']=null;
        }
        if(isset($_POST['name'])){
            $values['name']=$_POST['name'];
            $requete.=",name=:name";
            $_POST['name']=null;
        }
        if(isset($_POST['folder'])){
            $values['folder']=$_POST['folder'];
            $requete.=",folder=:folder";
            $_POST['folder']=null;
        }
        if(isset($_POST['minrole'])){
            $values['minrole']=$_POST['minrole'];
            $requete.=",minrole=:minrole";
            $_POST['minrole']=null;
        }
        $requete.=" WHERE Id=:id";
        $values['id'] = $_GET['id'];
        $exec=$pdo->prepare($requete);
        $exec->execute($values);
        header('Location: adminModule.php');
    }
    if($_POST['action']=="modifycat" && !empty($_GET['id'])){
        $requete="UPDATE TITLEANDLINK SET type=1";
        if(isset($_POST['name'])){
            $values['name']=$_POST['name'];
            $requete.=",name=:name";
            $_POST['name']=null;
        }
        if(isset($_POST['folder'])){
            $values['folder']=$_POST['folder'];
            $requete.=",folder=:folder";
            $_POST['folder']=null;
        }
        $requete.=" WHERE Id=:id";
        $values['id'] = $_GET['id'];
        $exec=$pdo->prepare($requete);
        $exec->execute($values);
        header('Location: adminModule.php');
    }
}
/* On sélectionne toutes les entrées qui ne sont pas des catégories */
  $exec = $pdo->query("SELECT
              T1.id
              ,T1.category
              ,T1.name
              ,T1.folder
              ,T1.minrole
              FROM TITLEANDLINK AS T1
              LEFT JOIN TYPEOFDATA ON T1.type=TYPEOFDATA.id
              WHERE TYPEOFDATA.ID=2
            ");
$links = $exec->fetchAll(PDO::FETCH_ASSOC);

/* On sélectionne toutes les catégories*/
$exec = $pdo->query("SELECT
              T1.id
              ,T1.name
              ,T1.folder
              FROM TITLEANDLINK AS T1
              LEFT JOIN TYPEOFDATA ON T1.type=TYPEOFDATA.id
              WHERE TYPEOFDATA.ID=1
            ");
$titles = $exec->fetchAll(PDO::FETCH_ASSOC);

/* On sélectionne toutes les types de données*/
$exec = $pdo->query("SELECT
              id
              ,name
              FROM TYPEOFDATA
            ");
$dataTypes = $exec->fetchAll(PDO::FETCH_ASSOC);
 ?>


