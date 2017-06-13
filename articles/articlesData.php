<?php
if(!empty($_GET['action'])){
    if($_GET['action']== 'addarticle'){
      $exec = $pdo->query('INSERT INTO NEWS(DateCreation) VALUES(GETDATE())');
      header('Location: articles.php');
    }
}
$exec = $pdo->query("SELECT id,title,text,CONVERT(date,dateModification,203) AS dtModification,isPublish FROM NEWS");
$allarticles = $exec->fetchAll(PDO::FETCH_ASSOC);