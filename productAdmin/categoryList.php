<?php
$minrole = 4;
require "../settings/header.php";
require "categoryListData.php"
?>
<h3>Toutes les catégories</h3>
<button type="button" class="btn btn-defaut btn-sm ajax" data-toggle="modal" data-target="#myModal"  data-action=addCategory data-titreheader="Ajouter une catégorie" data-url="categoryRead.php" data-function="categoryList" data-method="add">
    Ajouter
</button>
<div class="container">
    <div class="divTable">
        <div>
            <div class="divTr">
                <div class="col-sm-2">Name</div>
                <div class="col-sm-2">Tva</div>
                <div class="col-sm-2">Status</div>
                <div class="col-sm-2">Dernière modification</div>
                <div class="col-sm-4">Actions</div>
            </div>
        </div>
        <div class="divTbody">
            <?php
            $right = [];
            for ($key = 0; $key < count($test); $key++){
                if($key > 0){
                    ?>
                    <?php
                    if($test[$key-1]['id'] == $test[$key]['idParent']){
                        ?>
                        <div class="divTr">
                            <div class="col-sm-2"><?= $test[$key-1]['name'] ?>
                                <a href="Javascript:afficherCacher('child<?= $test[$key-1]['id']?>','glyphiconmod<?= $test[$key-1]['id'] ?>')">
                                    <span class="glyphicon glyphicon-triangle-bottom" id="glyphiconmod<?= $test[$key-1]['id'] ?>" aria-hidden="true"></span>
                                </a>
                            </div>
                            <div class="col-sm-2"><?= $test[$key-1]['tva'] ?></div>
                            <div class="col-sm-2"><?= ($test[$key-1]['isActive'] == 1) ? 'Actif' : 'Désactivé' ?></div>
                            <div class="col-sm-2"><?= $test[$key-1]['dateModification'] ?></div>
                            <div class="col-sm-4"></div>
                        </div>
                        <div class="childCat" id='child<?= $test[$key-1]['id']?>'>

                        <?php
                        $right[] = $test[$key-1]['bRight'];
                    }else{
                        ?>
                            <div class="divTr">
                                <div class="col-sm-2"><?= $test[$key-1]['name'] ?></div>
                                <div class="col-sm-2"><?= $test[$key-1]['tva'] ?></div>
                                <div class="col-sm-2"><?= ($test[$key-1]['isActive'] == 1) ? 'Actif' : 'Non-actif' ?></div>
                                <div class="col-sm-2"><?= $test[$key-1]['dateModification'] ?></div>
                                <div class="col-sm-4"></div>
                            </div>
                        <?php

                    }
                    if(count($right) > 0){
                        while ($right[count($right)-1] < $test[$key]['bRight']) {
                            array_pop($right);
                        }
                    }
                }
            }
            ?>
        </table>
    </div>
</div>
<div>

</div>
<?php
require "../".FolderSettings."/footer.php";