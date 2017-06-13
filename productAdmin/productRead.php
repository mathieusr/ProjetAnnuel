<?php
$minrole = 4;
require "../settings/header.php";
require "productReadData.php";

?>
<div class="row">
    <h3>Détails produit</h3>
    <form class="ajaxForm" action="productReadData.php" id="productForm" data-url="productReadData.php" data-function="saveOk" data-action="saveProduct" data-targetpage="productsList.php">
        <div class="form-group">
            <label for="">Id</label>
            <input class="form-control" type="text" name="idproduct" value="<?= $product['id']; ?>" readonly>
        </div>
        <div class="form-group">
            <label>Référence</label>
            <input class="form-control" type="text" name="reference" value="<?= $product['reference'] ?>" placeholder="Référence">
        </div>
        <div class="form-group">
            <label>Name</label>
            <input class="form-control" type="text" name="name" value="<?= $product['name'] ?>" placeholder="Name">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" name="description"><?= htmlspecialchars($product['description']) ?></textarea>
        </div>
        <div class="form-group">
            <label>Stock</label>
            <input type="text" name="stock" placeholder="Stock" value="<?= $product['stock'] ?>" class="form-control" <?php if(!empty($sizes)){echo "disabled"; } ?>>
        </div>
        <div class="form-group">
            <label for="price">Prix</label>
            <input type="text" name="price" placeholder="Prix" value="<?= $product['price'] ?>" class="form-control" <?php if(!empty($sizes)){echo "disabled"; } ?>>
        </div>
        <div class="form-group">
            <label for="category">Categorie</label>
            <select name="category"  class="form-control">
                <?php foreach ($categories as $category) : ?>
                    <?php if($category['id'] ==  $product['idCategory']):?>
                        <option selected value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php else: ?>
                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>

            </select>
        </div>
        <div>
            <h4>Tailles</h4>
            <button type="button" class="btn btn-default ajax" aria-label="Left Align" data-url="productReadData.php" data-action="addSize" data-function="updateSize" data-toggle="modal" data-target="#myModal" data-titreheader="Ajouter une taille">
                <span class="glyphicon glyphicon-plus ajax" aria-hidden="true" ></span>
            </button>
            <div id="allSize">
                <table class="table" id="sizeTable">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($sizes as $size) : ?>
                            <?php if($size['isActive'] == 0):?>
                                <tr class="danger" id="s<?= $size['id'] ?>">
                            <?php else: ?>
                                <tr id="s<?= $size['id'] ?>">
                            <?php endif; ?>
                                <td><?= $size['id'] ?></td>
                                <td><?= $size['name'] ?></td>
                                <td><?= $size['price'] ?></td>
                                <td><?= $size['stock'] ?></td>
                                <td width="10px">
                                    <button type="button" class="btn btn-default ajax" data-url="productReadData.php" data-action="readSize" data-function="updateSize" data-toggle="modal" data-target="#myModal" data-titreheader="Modifier une taille" data-sizeid="<?= $size['id'] ?>">
                                        <span class="glyphicon glyphicon-pencil ajax" ></span>
                                    </button>
                                </td>
                                <td width="10px">
                                    <button style="width: 100%;" type="button" class="btn btn-default ajax updateStatus" data-url="productReadData.php" data-action="updateSizeStatus" data-function="updateSizeStatus" data-sizeid="<?= $size['id'] ?>">
                                        <?= ($size['isActive'] == 0) ? 'Activer' : 'Désactiver' ; ?>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div style="margin-bottom: 20px;">
            <h4>Image(s) de présentation</h4>
            <button type="button" class="btn btn-default ajax" aria-label="Left Align" data-url="productReadData.php" data-action="showImage" data-function="showProductsImage" data-toggle="modal" data-target=".bs-example-modal-lg" data-titreheader="Ajouter une ou des images de présentation">
                <span class="glyphicon glyphicon-plus ajax" aria-hidden="true" ></span>
            </button>
            <div id="pictureDiv" class="flex">
                <?php foreach ($images as $key => $image) : ?>
                    <div style="background-image: url('/img/products/<?= $image['dateCreation2'] ?>/<?= $image['dateCreation'] ?>-<?= sprintf("%04d", $image['id']) ?>.png');
                                background-size: contain;
                                background-repeat:no-repeat;
                                background-position:center;
                                width:  301px;
                                height: 301px;">
                        <div data-imageid='<?= $image['id'] ?>' class="deleteCross ajax" data-url="productReadData.php" data-function="deleteImage" data-action="deleteProductPicture"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <input type="submit" value="Enregistrer" class="btn btn-success">
    </form>
</div>

<?php
require "../".FolderSettings."/footer.php";
