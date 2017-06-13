testfergers
<?php
if(!empty($_POST['action'])){
    require "../settings/FolderName.php";
    require "../".FolderDb."/db.php";
    if($_POST['action']== 'addCategory'){
        $exec = $pdo->query("INSERT INTO PRODUCTSCATEGORY(name,tva,isActive) VALUES (null,null,0)");
        $categoryId = $pdo->lastInsertId();
        require "categoryRead.php";
    }
}

$result = $pdo->prepare("SELECT bLeft,bRight FROM PRODUCTSCATEGORY WHERE name='Gamme'");
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);

$result = $pdo->prepare('SELECT idParent,bLeft,bRight,id,name,tva,CONVERT(date,dateModification,203) AS dateModification,isActive FROM PRODUCTSCATEGORY WHERE bLeft BETWEEN :left AND :right AND bLeft != :left1 AND bLeft != :right1 ORDER BY bLeft ASC');
$result->bindValue(':left',$row['bLeft']);
$result->bindValue(':right',$row['bRight']);
$result->bindValue(':left1',$row['bLeft']);
$result->bindValue(':right1',$row['bRight']);
$result->execute();
$test = $result->fetchAll(PDO::FETCH_ASSOC);
echo count($test);
/*$exec = $pdo->query("SELECT id,name,tva,CONVERT(date,dateModification,203) AS dateModification,isActive FROM PRODUCTSCATEGORY WHERE idParent IS NOT NULL ORDER BY dateModification");
$products = $exec->fetchAll(PDO::FETCH_ASSOC);*/
