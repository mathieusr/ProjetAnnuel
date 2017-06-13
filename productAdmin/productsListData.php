<?php
$action = $_GET['action'] ?? $_POST['action'] ?? null;
if(!empty($action)){
    require "../settings/FolderName.php";
    require "../".FolderDb."/db.php";
    if($action== 'addProduct'){
    $exec = $pdo->query("INSERT INTO PRODUCTS(name) VALUES (null)");
    $productId = $pdo->lastInsertId();
    header('Location : productRead.php?id='.$productId.'');
    }
}

$exec = $pdo->query("SELECT PRODUCTS.id,reference,PRODUCTS.name,CONVERT(date,PRODUCTS.dateModification,203) AS dateModification,PRODUCTS.isActive,PRODUCTSCATEGORY.name AS categorieName FROM PRODUCTS LEFT JOIN PRODUCTSCATEGORY ON PRODUCTSCATEGORY.id = PRODUCTS.categoryId ORDER BY PRODUCTS.dateModification");
$products = $exec->fetchAll(PDO::FETCH_ASSOC);
