<?php
$productid = $_GET['id'] ?? $_POST['id'] ?? null;
$action = $_GET['action'] ?? $_POST['action'] ?? null;
if(!empty($action)){
    require "../settings/FolderName.php";
    require "../".FolderDb."/db.php";
    if($action == "addSize" || $action== "readSize"){
        // Cette action permet d'ajouter un une taille
        if($action == "addSize"){
            $exec = $pdo->prepare("INSERT INTO SIZE(idProduit) VALUES(:productid)");
            $exec->bindParam(':productid',$productid,PDO::PARAM_INT);
            $exec->execute();
            $sizeId = $pdo->lastInsertId();
            $method = 'add';
        // Cette action permet de lire une taille
        }elseif($action == "readSize"){
            $sizeId = $_POST['sizeid'] ?? null;
            if(!empty($sizeId)){
                $exec = $pdo->prepare("SELECT id,name,price,stock FROM SIZE WHERE id=:id");
                $exec->bindParam(':id',$sizeId);
                $exec->execute();
                $sizeDetails = $exec->fetch(PDO::FETCH_ASSOC);
                $method = 'update';
            }
        }
        ?>
        <!-- Formulaire de gestion des tailles -->
        <form class="sizeReadCreate" data-url="productReadData.php" data-action="validateSize" data-sizeid="<?= $sizeId ?>" data-method="<?= $method ?>">
            <div class="form-group">
                <label for="sizeName">Taille</label>
                <input type="text" name="sizeName" placeholder="Size" class="form-control" value="<?= $sizeDetails['name'] ?? null ?>">
            </div>
            <div class="form-group">
                <label for="price">Prix</label>
                <input type="text" name="price" placeholder="Price" class="form-control" value="<?= $sizeDetails['price'] ?? null ?>">
            </div>
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="text" name="stock" placeholder="Stock" class="form-control" value="<?= $sizeDetails['stock'] ?? null ?>">
            </div>
            <input type="submit" value="Enregistrer" class="btn btn-success">
            <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Fermer</button>
        </form>
        <?php

    //Cette action permet de sauvegarder les modifications effectuées sur une taille
    }elseif($action == 'validateSize'){
        $size = $_POST['sizeName'] ?? null;
        // On convertie les prix en format acceptable pour base de données
        $price = floatval(str_replace(",",".",$_POST['price']))?? null;
        if(!empty($price)){
            $price = number_format($price,2,".",' ');
        }
        $stock = $_POST['stock'] ?? null;
        $idSize = $_POST['sizeid'] ?? null;
        if(!empty($idSize)){
            $exec = $pdo->prepare("SELECT isActive FROM SIZE WHERE id=:id");
            $exec->bindParam(':id',$idSize);
            $exec->execute();
            $isActive = $exec->fetch(PDO::FETCH_COLUMN);

            $exec = $pdo->prepare("UPDATE SIZE SET name=:name,price=:price,stock=:stock WHERE id=:id");
            $exec->bindParam(':name',$size,PDO::PARAM_STR);
            $exec->bindParam(':price',$price);
            $exec->bindParam(':stock',$stock,PDO::PARAM_INT);
            $exec->bindParam(':id',$idSize,PDO::PARAM_INT);
            $exec->execute();
            // Si on crée une taille, on crée la ligne avec toute les données
            if($_POST['method'] == 'add'){
                ?>
                <?php if($isActive == 0) : ?>
                    <tr class="danger" id='s<?= $idSize ?>'>
                <?php elseif($isActive == 1): ?>
                    <tr id='s<?= $idSize ?>'>
                <?php endif; ?>
                    <td><?= $idSize ?></td>
                    <td><?= $size ?></td>
                    <td><?= $price ?></td>
                    <td><?= $stock ?></td>
                    <td width='10px'>
                        <button type='button' class='btn btn-default ajax' data-url='productReadData.php' data-action='readSize' data-function='updateSize' data-toggle='modal' data-target='#myModal' data-titreheader='Modifier une taille' data-sizeid='<?= $idSize ?>'>
                                    <span class='glyphicon glyphicon-pencil ajax'></span>
                        </button>
                    </td>
                    <td width='10px'>
                        <button style='width: 100%;' type='button' class='btn btn-default ajax updateStatus' data-url='productReadData.php' data-action='updateSizeStatus' data-function='updateSizeStatus' data-sizeid='<?= $idSize ?>'><?= ($isActive == 0) ? 'Activer' : 'Désactiver' ?>
                        </button>
                    </td>
                </tr>
                <?php
            //Si on modifier une taille, on transmet à javascript le tableau de données, via JSON
            }elseif($_POST['method'] == 'update'){
                $newValue = ['values' => ["id" => $idSize , "size" => $size , "price" => $price , "stock" => $stock], "status" => ["isActive" => $isActive], "method" => "update"];
                echo json_encode($newValue);

            }


        }

    // Permet d'activer ou de désactiver une taille
    }elseif($action == "updateSizeStatus"){
        $idSize = $_POST['sizeid'] ?? null;
        if(!empty($idSize)){
            $exec = $pdo->prepare("SELECT isActive FROM SIZE WHERE id=:id");
            $exec->bindParam(':id',$idSize);
            $exec->execute();
            $isActive = $exec->fetch(PDO::FETCH_COLUMN);
            $oppisActive = ($isActive == 1)? 0 : 1;
            $exec = $pdo->prepare("UPDATE SIZE SET isActive=:status WHERE id=:id");
            $exec->bindParam(':id',$idSize);
            $exec->bindParam(':status',$oppisActive);
            $exec->execute();
            echo json_encode(['values' => ["id" => $idSize] , "status" => ["isActive" => $oppisActive]]);
        }else{
            echo "error";
        }
    //Action qui permet d'afficher les images par date.
    }elseif($action == "showImage") {
        $productId = $_POST['id'] ?? $_POST['idproduct'] ?? null;
        ?>
        <div class='row'>
            <div class='col-sm-12'>
                <form method='POST' class='col-md-12 form-inline ajax' data-titreheader="<?= $_POST['titreheader'] ?>"
                      data-function='showProductsImage' data-url='productReadData.php'
                      data-action="<?= $_POST['action'] ?>">
                    <div class='form-group'>
                        <label>Date photo</label>
                        <input type='date' name='photoDate' class='form-control'
                               value="<?php if (isset($_POST['photoDate'])) {
                                   echo $_POST['photoDate'];
                               } else {
                                   $test = new DateTime();
                                   echo $test->format('Y-m-d');
                               } ?>">
                    </div>
                    <input type='submit' class='btn btn-default' value='Choisir'>
                </form>
            </div>
        </div>
        <hr>
        <?php
        if (!empty($_POST['photoDate'])) {
            $test = new DateTime($_POST['photoDate']);
            $datetocompare = $test->format('Y-m-d H:i:s.u');
        } else {
            $test = new DateTime();
            $datetocompare = $test->format('Y-m-d H:i:s.u');
        }
        $exec = $pdo->prepare("SELECT 
                                IMAGE.id
                                ,folder
                                ,CONVERT(VARCHAR,IMAGE.dateCreation,112) AS dateCreation
                                ,CONVERT(DATE,IMAGE.dateCreation,120) AS dateCreation2
                                ,A.Id
                                ,A.idProduct
                                ,A.idImage
                                FROM IMAGE
                                LEFT JOIN (SELECT id,idImage,idProduct FROM ImageAndProduct WHERE idProduct=:product) AS A ON A.idImage = IMAGE.id
                                WHERE DATEDIFF(day,:date,IMAGE.dateCreation) = 0 
                                AND folder='products' 
                                AND A.idImage IS NULL
                                ORDER BY IMAGE.dateCreation ASC");
        $exec->bindValue(':date', $datetocompare);
        $exec->bindValue(':product',$productId);
        $exec->execute();
        $images = $exec->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="row">
            <div class="col-sm-12">
                <form class="photoChooseForm" data-url="productReadData.php" data-action="addImage" data-function="finishImageUpload">
                    <div style='display: flex;flex-wrap: wrap;justify-content: space-around'>
                        <?php foreach ($images as $key => $image) : ?>
                            <div class="form-group">
                                <div style="background-image: url('/img/products/<?= $image['dateCreation2'] ?>/<?= $image['dateCreation'] ?>-<?= sprintf("%04d", $image['id']) ?>.png');background-size: cover;width: 200px;height: 113px;">
                                </div>
                                <div style="display: flex;align-items: center;justify-content: center;background-color: #ecf0f1;">
                                    <div style="width: 24px;height: 24px;cursor: pointer;" aria-checked="false"
                                         role="checkbox" tabindex="0" class="checkbox" data-value="<?= $image['id'] ?>">
                                        <img src="../img/icons/check_box.png">
                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                    <input type="submit" value="Ajouter" class="btn btn-success">
                    <button type="button" id="closeModal" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </form>

            </div>
        </div>
        <?php

    // Cette action permet d'enregister dans la base de données les images sélectionées
    }elseif($action == 'addImage'){
        $productId = $_POST['id'] ?? $_POST['idproduct'] ?? null;
        // On décode le tableau reçu depuis javascript
        $valueToInsert = json_decode($_POST['checkbox'],TRUE);
        $error = FALSE;
        if(!empty($productId) && !empty($valueToInsert)){
            // On sélection toutes les images associés aux produits
            $exec = $pdo->prepare('SELECT idImage FROM ImageAndProduct WHERE idProduct=:product');
            $exec->bindValue(':product',$productId);
            $exec->execute();
            $presentImage = $exec->fetchAll(PDO::FETCH_COLUMN);

            foreach ($valueToInsert['values'] as $key => $value){
                // Si l'image est déja associée au produit, on ne l'ajoute pas
                if(!in_array($value,$presentImage)){
                    $exec = $pdo->prepare('INSERT INTO ImageAndProduct(idProduct,idImage) VALUES (:product,:image)');
                    $exec->bindValue(':product',$productId);
                    $exec->bindValue(':image', $value);
                    try {
                        $exec->execute();
                    } catch (PDOException $e) {
                        $error = TRUE;
                        continue;
                    }

                    $exec = $pdo->prepare('SELECT 
                            IMAGE.id
                            ,folder
                            ,CONVERT(VARCHAR,IMAGE.dateCreation,112) AS dateCreation
                            ,CONVERT(DATE,IMAGE.dateCreation,120) AS dateCreation2
                            FROM IMAGE
                            WHERE id=:image');
                    $exec->bindValue(':image', $value,PDO::PARAM_INT);
                    try {
                        $exec->execute();
                    } catch (PDOException $e) {
                       $error = TRUE;
                    }

                    $image = $exec->fetch(PDO::FETCH_ASSOC);
                    echo "<div style=\"background-image: url('/img/products/".$image['dateCreation2']."/".$image['dateCreation']."-".sprintf('%04d', $image['id']).".png');
                                background-size: contain;
                                background-repeat:no-repeat;
                                background-position:center;
                                width:  301px;
                                height: 301px;\">
                                <div data-imageid='".$image['id']."' class='deleteCross ajax' data-url='productReadData.php' data-function='deleteImage' data-action='deleteProductPicture'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></div>
                    </div>";
                }else{
                    $error = TRUE;
                }

            }
        }else{
           $error = TRUE;
        }
        if($error == TRUE){
            echo "error";
        }

    //Cette action sauvegarde les données du produits
    }elseif($action == "saveProduct"){
        $productId = $_POST['id'] ?? $_POST['idproduct'] ?? null;
        $reference = $_POST['reference'] ?? null;
        $productName = $_POST['name'] ?? null;
        $productDescription = htmlspecialchars($_POST['description']) ?? null;
        $productStock = $_POST['stock'] ?? null;
        $productPrice = floatval(str_replace(",", ".", $_POST['price']))?? null;
        if (!empty($price)) {
            $productPrice = number_format($price, 2, ".", ' ');
        }
        $productCategory = $_POST['category'] ?? null;
        if (!empty($productId)) {
            $exec = $pdo->prepare("UPDATE PRODUCTS SET reference=:reference,name=:name,description=:description,stock=:stock,price=:price,categoryId=:category WHERE id=:id");
            $exec->bindValue(':reference', $reference, PDO::PARAM_STR);
            $exec->bindValue(':name', $productName, PDO::PARAM_STR);
            $exec->bindValue(':description', $productDescription, PDO::PARAM_STR);
            $exec->bindValue(':stock', $productStock, PDO::PARAM_INT);
            $exec->bindValue(':price', $productPrice, PDO::PARAM_BOOL);
            $exec->bindValue(':category', $productCategory, PDO::PARAM_INT);
            $exec->bindValue(':id', $productId, PDO::PARAM_INT);
            try {
                $exec->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
                echo "error";
            }
        }else{
            echo "error";
        }

    // Cette action supprimer une image d'un produit
    }elseif($action == 'deleteProductPicture'){
        $productId = $_POST['id'] ?? $_POST['idproduct'] ?? null;
        $imageId = $_POST['imageid'] ?? null;
        if(!empty($productid) && !empty($imageId)) {
            $exec = $pdo->prepare('DELETE FROM ImageAndProduct WHERE idProduct=:product AND idImage=:image');
            $exec->bindValue(':product', $productid);
            $exec->bindValue(':image', $imageId);
            try {
                $exec->execute();
            } catch (PDOException $e) {
                echo "error";
            }
        }else{
            echo "error";
        }
    }
    exit();
}

if(!empty($productid)){
    $exec = $pdo->prepare("SELECT PRODUCTS.id,reference,PRODUCTS.name,PRODUCTS.description,stock,price,PRODUCTSCATEGORY.id AS idCategory                                   ,PRODUCTSCATEGORY.name AS CategoryName 
                                  FROM PRODUCTS 
                                  JOIN PRODUCTSCATEGORY ON PRODUCTS.categoryId = PRODUCTSCATEGORY.id
                                  WHERE PRODUCTS.id=:id");
    $exec->bindParam(':id',$productid,PDO::PARAM_INT);
    $exec->execute();
    $product = $exec->fetch(PDO::FETCH_ASSOC);

    $exec = $pdo->query("SELECT name,id FROM PRODUCTSCATEGORY");
    $categories = $exec->fetchAll(PDO::FETCH_ASSOC);

    $exec = $pdo->prepare("SELECT id,name,price,stock,isActive FROM SIZE WHERE idProduit=:id");
    $exec->bindParam(':id',$productid,PDO::PARAM_INT);
    $exec->execute();
    $sizes = $exec->fetchAll(PDO::FETCH_ASSOC);

    $exec = $pdo->prepare('SELECT 
                            IMAGE.id
                            ,folder
                            ,CONVERT(VARCHAR,IMAGE.dateCreation,112) AS dateCreation
                            ,CONVERT(DATE,IMAGE.dateCreation,120) AS dateCreation2
                            FROM ImageAndProduct
                            JOIN IMAGE ON ImageAndProduct.idImage = IMAGE.id
                            WHERE idProduct=:product');
    $exec->bindValue(':product',$productid);
    $exec->execute();
    $images = $exec->fetchAll(PDO::FETCH_ASSOC);
}else{
    header('location : productsList.php');
}