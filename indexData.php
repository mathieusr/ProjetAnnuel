<?php
require "settings/FolderName.php";
require FolderDb."/db.php";

$exec = $pdo->query("SELECT NEWS.id,IMAGE.Id AS idImage,title,presentationImg,isPublish,CONVERT(varchar,IMAGE.dateCreation,112) AS dateCreation,CONVERT(date,IMAGE.dateCreation,120) AS dateCreation2 FROM NEWS LEFT JOIN IMAGE ON NEWS.presentationImg = IMAGE.id WHERE isPublish=1 ORDER BY NEWS.dateModification DESC");
$articles = $exec->fetchAll(PDO::FETCH_ASSOC);