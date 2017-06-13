<?php

$exec = $pdo->prepare("SELECT
              T2.name
              ,T2.folder AS t2folder
              ,T1.id
              ,T1.name
              ,T1.folder
              FROM TITLEANDLINK AS T1
              LEFT JOIN TYPEOFDATA ON T1.type=TYPEOFDATA.id
              LEFT JOIN TITLEANDLINK AS T2 ON T1.category=T2.Id
              WHERE TYPEOFDATA.ID=2
              AND T1.minrole <= :minrole
              ORDER BY T2.name ASC
            ");
$exec->bindParam(':minrole',$userrole);
$exec->execute();
$test = $exec->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_GROUP|PDO::FETCH_GROUP);
$affiche="<div class='menucategory'><a href='/index.php'>Accueil</a></div>";
foreach ($test as $key => $value){
    $affiche.="<div class='menucategory'><p>".$key."</p>";
    foreach ($value as $item) {
        $affiche.="<div><a href='/".$item['t2folder']."/".$item['folder']."'>".$item['name']."</a></div>";
    }
    $affiche.="</div>";
}
