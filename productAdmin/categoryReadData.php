<?php
$categoryId = $_GET['categoryId'] ?? $categoryId ?? null;
$action = $_GET['action'] ?? $_POST['action'] ?? null;
if(!empty($action)){
    require "../settings/FolderName.php";
    require "../".FolderDb."/db.php";
    require "functions.php";
    $id = $_POST['categoryid'] ?? null;
    if($action == 'addCategory'){
        $method = 'add';
    }elseif($action == 'saveForm') {
        $error = FALSE;
        $path = json_decode($_POST['path'], TRUE) ?? null;
        $name = $_POST['name'] ?? null;
        $tva = $_POST['TVA'] ?? 20;
        if (!empty($path) && !empty($name)) {
            $lastPath = end($path['values']);
            $exec = $pdo->prepare('SELECT idParent,bLeft,bRight FROM PRODUCTSCATEGORY WHERE id=:id');
            $exec->bindValue(':id', $lastPath, PDO::PARAM_INT);
            try {
                $exec->execute();
            } catch (PDOException $e) {
                $error = TRUE;
                echo $e->getMessage();
            }
            $lastPathDetails = $exec->fetch(PDO::FETCH_ASSOC);
            if (!empty($lastPathDetails)) {
                if ($lastPathDetails['idParent'] != NULL) {
                    $exec = $pdo->prepare('SELECT id FROM PRODUCTSCATEGORY WHERE bLeft <= :left AND bRight >= :right ORDER BY bLeft DESC');
                    $exec->bindValue(':left', $lastPathDetails['bLeft'], PDO::PARAM_INT);
                    $exec->bindValue(':right', $lastPathDetails['bRight'], PDO::PARAM_INT);
                    try {
                        $exec->execute();
                    } catch (PDOException $e) {
                        $error = TRUE;
                        echo $e->getMessage();
                    }
                    $allParents = $exec->fetchAll(PDO::FETCH_COLUMN);
                    foreach ($path['values'] as $value) {
                        if (!in_array($value, $allParents)) {
                            $error = TRUE;
                            break;
                        }
                    }
                }
                if ($error != TRUE) {
                    $param = [$lastPath, $lastPathDetails['bRight'], $lastPathDetails['bRight'] + 1, $name, $tva];
                    addOneCat('PRODUCTSCATEGORY', $param, $lastPathDetails, $pdo);
                }
            }

        } else {
            echo "error";
        }
        if ($_POST['method'] == 'add') {

        } elseif ($_POST['method'] == 'update') {

        }

        if ($error == TRUE) {
            echo "error";
        }

    }elseif($action == 'getAllpath') {
        $selectedId = $_POST['idSelect'] ?? null;
        if (!empty($selectedId)) {
            $allParents = getAllCatParent($selectedId, $pdo);
            foreach ($allParents as $parent) {
                if ($parent == end($allParents) && $parent['idParent'] != null) {
                    echo "<p class='form-control-static'><a href='#' style='color:#e74c3c;' id='p".$parent['id']."' aria-checked='true' role='checkbox' tabindex='-1' class='checkbox' data-parent='".$parent['idParent']."' data-value='" . $parent['id'] . "'>" . $parent['name'] . "</a></p>";
                } else {
                    echo "<p aria-checked='true' role='checkbox' tabindex='-1' class='form-control-static checkbox' data-value='" . $parent['id'] . "'>" . $parent['name'] . "</p>";
                    if($parent['idParent'] != null || isset($allParents[1])){
                        echo "<p class='form-control-static' style='margin: 0px 5px'> > </p>";
                    }
                }

            }
        } else {
            echo 'error';
        }
    }elseif($action == "desactivate"){
        var_dump($_POST);
        if(!empty($id)){
            $exec = $pdo->prepare("UPDATE PRODUCTSCATEGORY SET isActive=0 WHERE id=:id");
            $exec->bindParam(':id',$id,PDO::PARAM_INT);
            $exec->execute();
        }
    }elseif($action == "activate"){
        var_dump($_POST);
        if(!empty($id)){
            $exec = $pdo->prepare("UPDATE PRODUCTSCATEGORY SET isActive=1 WHERE id=:id");
            $exec->bindParam(':id',$id,PDO::PARAM_INT);
            $exec->execute();
        }
    }elseif($action == 'delete'){
        var_dump($_POST);
        if(!empty($id)){
            $exec = $pdo->prepare("DELETE FROM PRODUCTSCATEGORY WHERE id=:id");
            $exec->bindParam(':id',$id,PDO::PARAM_INT);
            $exec->execute();
        }
    }elseif($action == 'refreshSelect'){
        $selectedId = $_POST['idSelect'] ?? null;
        if(!empty($selectedId)){
            $catToDisplay = selectNextChild($selectedId,$pdo);
            if(!empty($catToDisplay)){
                echo "
                <div class='form-group'>
                    <p class='form-control-static'> > </p></div>
                <div class='form-group'>
                    <select id='selectCat' class='form-control'>
                        <option value='null'></option>";
                    foreach ($catToDisplay as $key => $cat){
                        echo "<option value=".$cat['id'].">".$cat['name']."</option>";
                    }
                    echo "
                    </select>
                    <button class='addCat' data-url='categoryReadData.php' data-action='refreshSelect' data-function='refreshSelect'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></button>
                </div>";
            }
        }
    }
}
if(!empty($categoryId)){
    require_once "../settings/FolderName.php";
    require_once "../".FolderDb."/db.php";
    require_once "functions.php";
    $exec = $pdo->prepare("SELECT id,name,tva,isActive FROM PRODUCTSCATEGORY WHERE id=:id ORDER BY dateModification");
    $exec->bindParam(':id',$categoryId);
    $exec->execute();
    $product = $exec->fetch(PDO::FETCH_ASSOC);

    $allParents = getAllCatParent($product['id'],$pdo);
    $firstcat = selectNextChild($product['id'],$pdo);
}else{
    $exec = $pdo->prepare("SELECT id,name,bLeft,bRight FROM PRODUCTSCATEGORY WHERE idParent=1");
    $exec->execute();
    $firstcat = $exec->fetchAll(PDO::FETCH_ASSOC);
}