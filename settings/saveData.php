<?php
require "FolderName.php";
require "../".FolderDb."/db.php";
$basename = $_POST['basename'] ?? null;
$basename = strtoupper($basename);
$exec = $pdo->prepare("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE Table_Type='BASE TABLE' AND TABLE_NAME LIKE :table");
$exec->bindParam(":table",$basename);
$exec->execute();
$table = $exec->fetch(PDO::FETCH_COLUMN);
if(!empty($table)){
    $exec = $pdo->prepare("UPDATE ".$_POST['basename']." SET ".$_POST['columnname']."=:newvalue,dateModification=GETDATE() WHERE Id=:id");
    $exec->bindParam(":newvalue",$_POST['value']);
    $exec->bindParam(":id",$_POST['id']);
    try{
        $exec->execute();
        echo "success";
    }catch(Exception $e){
        echo "error";
    }

}else{
    echo "error";
}

