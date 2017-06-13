<?php
if(!empty($_GET['action'])){
    if($_GET['action']== 'addarticle'){
      $exec = $pdo->query('INSERT INTO NEWS(DateCreation) VALUES(GETDATE())');
      header('Location: articles.php');
    }elseif($_GET['action'] == 'publish'){
        if(!empty($_GET['articleId'])){
            $exec = $pdo->prepare('UPDATE NEWS SET isPublish=1,DateModification=GETDATE() WHERE id=:id');
            $exec->bindParam(':id', $_GET['articleId']);
            $exec->execute();
            header('Location: articles.php');
        }
    }elseif($_GET['action'] == 'remove'){
        if(!empty($_GET['articleId'])){
            $exec = $pdo->prepare('UPDATE NEWS SET isPublish=0,DateModification=GETDATE() WHERE id=:id');
            $exec->bindParam(':id', $_GET['articleId']);
            $exec->execute();
            header('Location: articles.php');
        }
    }
}
$exec = $pdo->query("SELECT id,title,text,CONVERT(date,dateModification,203) AS dtModification,isPublish FROM NEWS");
$allarticles = $exec->fetchAll(PDO::FETCH_ASSOC);