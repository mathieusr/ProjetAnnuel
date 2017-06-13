<?php
function addOneCat($table,$param,$lastPathDetails,$pdo){
    $error = FALSE;
    $exec = $pdo->prepare('UPDATE '.$table.' SET bRight=bRight + 2 WHERE bRight>= :right');
    $exec->bindValue(':right',$lastPathDetails['bRight']);
    try {
        $exec->execute();
    } catch (PDOException $e) {
        $error = TRUE;
        echo $e->getMessage();
    }

    $exec = $pdo->prepare('UPDATE '.$table.' SET bLeft=bLeft + 2 WHERE bLeft>= :right');
    $exec->bindValue(':right',$lastPathDetails['bRight']);
    try {
        $exec->execute();
    } catch (PDOException $e) {
        $error = TRUE;
        echo $e->getMessage();
    }
    $exec = $pdo->prepare('INSERT INTO '.$table.'(idParent,bLeft,bRight,isActive,name,tva) VALUES(?,?,?,0,?,?)');
    try {
        $exec->execute($param);
    } catch (PDOException $e) {
        $error = TRUE; echo $e->getMessage();
    }
    return $error;
}

function deleteOneCat($idCat,$pdo){
    $exec = $pdo->prepare('SELECT parentId,');
}

function getAllCatParent($idCat,$pdo){
    $error = FALSE;

    $exec = $pdo->prepare('SELECT bLeft,bRight,name FROM PRODUCTSCATEGORY WHERE id=:id');
    $exec->bindValue(':id',$idCat);
    try {
        $exec->execute();
        $pathDetails = $exec->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = TRUE;
    }

    if($error != TRUE){
        $exec = $pdo->prepare('SELECT name,id,idParent FROM PRODUCTSCATEGORY WHERE bLeft <= :left AND bRight >= :right ORDER BY bLeft ASC');
        $exec->bindValue(':right',$pathDetails['bRight']);
        $exec->bindValue(':left',$pathDetails['bLeft']);
        try {
            $exec->execute();
            $allParents = $exec->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
            $error = TRUE;
        }
    }
    if($error == TRUE){
        return 'error';
    }else{
        return $allParents;
    }
}

function selectNextChild($idCat,$pdo){
    $exec = $pdo->prepare("SELECT id,name,bLeft,bRight FROM PRODUCTSCATEGORY WHERE idParent=:parent");
    $exec->bindValue(':parent',$idCat);
    $exec->execute();
    return $exec->fetchAll(PDO::FETCH_ASSOC);
}