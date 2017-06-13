<?php
$minrole = 4;
require "../settings/header.php";
require "productsListData.php"
?>
<div class="row">
    <h3>Tous les articles</h3>
    <a href="productsListData.php?action=addProduct">Ajouter un nouveau produit</a>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Référence</th>
                <th>Catégorie</th>
                <th>Dernière modification</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $key => $product) : ?>
                <tr>
                    <td><a href="productRead.php?id=<?= $product['id'] ?>"><?= $product['id'] ?></a></td>
                    <td><?= $product['name'] ?></td>
                    <td><?= $product['reference'] ?></td>
                    <td><?= $product['categorieName'] ?></td>
                    <td><?= $product['dateModification'] ?></td>
                </tr>
            <?php endforeach; ?>

        </tbody>

    </table>
</div>
<?php
require "../".FolderSettings."/footer.php";