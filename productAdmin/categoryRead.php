<?php
$minrole = 4;
require "categoryReadData.php";
?>
<div class="row">
    <div class='col-sm-12'>
        <form id="categoryReadForm" method="post" data-url="categoryReadData.php" data-method="<?= $add ?? 'add' ?>" data-function="updateCategory" data-action="saveForm" data-categoryid="<?= $categoryId ?>">
            <div class="form-group">
                <label>Nom</label>
                <input type="text" class="form-control" name="name" placeholder="Nom" value="<?= $product['name'] ?? null ?>">
            </div>
            <div class="form-group">
                <label>TVA</label>
                <input class="form-control" type="number" name="TVA" value="<?= $product['tva'] ?? null ?>" placeholder="TVA">
            </div>
            <div class="form-group">
                <label>Catégorie</label>
                <div class="form-inline">
                    <div class="form-group">
                        <div id="catDirectory">
                            <?php if(!empty($allParents)) : ?>
                                <?php foreach($allParents as $parent) :?>
                                    <?php if ($parent == end($allParents) && $parent['idParent'] != null) : ?>
                                        <p class='form-control-static'><a href='#' style='color:#e74c3c;' id='p<?= $parent['id'] ?>' aria-checked='true' role='checkbox' tabindex='-1' class='checkbox' data-parent='<?= $parent['idParent'] ?>' data-value='<?= $parent['id'] ?>'><?= $parent['name'] ?></a></p>
                                    <?php else : ?>
                                        <p aria-checked='true' role='checkbox' tabindex='-1' class='form-control-static checkbox' data-value='<?= $parent['id'] ?>'><?= $parent['name'] ?></p>
                                        <?php if($parent['idParent'] != null || isset($allParents[1])): ?>
                                            <p class='form-control-static' style='margin: 0px 5px'> > </p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p aria-checked="true" role="checkbox" tabindex="-1" class="form-control-static checkbox" data-value="1">Gamme</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div id="addNewPath" class="form-group">
                        <?php if(!empty($firstcat)): ?>
                            <div class="form-group">
                                <p class="form-control-static"> > </p>
                            </div>
                            <div class="form-group">
                                <select id="selectCat" class="form-control">
                                    <option value="null"></option>
                                    <?php foreach ($firstcat as $key => $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button class="addCat"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>


            </div>
            <input type="submit" class="btn btn-primary" value="Sauvegarder" id="buttonValidate">
            <?php if(!empty($product)) : ?>
                <?php if($product['isActive'] == 1): ?>
                    <input type="button" class="btn btn-info ajax" value="Désactiver" id="buttonValidate" class="ajax" data-url="categoryReadData.php" data-action="desactivate" data-categoryid="<?= $categoryId ?? null ?>">
                <?php else :?>
                    <input type="button" class="btn btn-info ajax" value="Activer" id="buttonValidate" class="ajax" data-url="categoryReadData.php" data-action="activate" data-categoryid="<?= $categoryId ?? null ?>">
                <?php endif; ?>
                <input type="button" class="btn btn-danger ajax" value="Supprimer" id="buttonValidate" class="ajax" data-url="categoryReadData.php" data-action="delete" data-categoryid="<?= $categoryId ?? null ?>">
            <?php endif; ?>
            <input type="button" class="btn btn-default dismissButton" data-dismiss="modal" value="Annuler">
        </form>
    </div>
</div>



