<?php $minrole=4; require "../conf/header.php"; ?>
<?php require "adminModuleData.php"; ?>
<div class="row">
    <div class="row">
        <h3>Tous les Modules</h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Categorie</th>
                    <th>Url</th>
                    <th>Min Role</th>
                    <th width="100px"></th>
                    <th width="100px"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($links as $key => $link): ?>
                    <tr>

                        <td align="center"><?php echo $link['id'] ?></td>
                        <td><?= $link['name']?></td>
                        <td><?php
                            foreach($titles as $title){
                                if($title['id']== $link['category']) {
                                    echo $title['name'];
                                }
                            }
                            ?>
                        </td>
                        <td><?=$link['folder']?></td>
                        <td><?= $link['minrole']?></td>
                        <td align="center"><a href="adminModule.php?action=modifymod&id=<?= $link['id']?>"><button class="btn btn-info btn-block" title="Validate Modification" type="submit">Modifier</button></a></td>
                        <td align="center"><a href="adminModule.php?action=delete&id=<?= $link['id']?>"><button class="btn btn-danger btn-block" title="Delete Entry">Supprimer</button></a></td>

                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <h4>Ajouter un nouveau module<a href="Javascript:afficherCacher('newmodule','glyphiconmod')"><span class="glyphicon glyphicon-triangle-bottom" id="glyphiconmod" aria-hidden="true"></span></a></h4>
        <form method="POST" style="display:none;" id="newmodule" class="col-md-8">
            <div class="form-group">
                <label for="categoryname">Nom</label>
                <input type="text" class="form-control" name="name" id="modulename" placeholder="Nom">
            </div>
            <div class="form-group">
                <label for="categorurl">Nom du fichiers</label>
                <input type="text" class="form-control" name="folder" id="moduleurl" placeholder="Nom">
            </div>
            <div class="form-group">
                <label for="modulecategory">Categorie</label>
                <select class="form-control" name="category">
                    <?php
                    foreach($titles as $title){
                        echo "<option value='".$title['id']."'>".$title['name']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="moduletype">Type</label>
                <select class="form-control" name="type">
                    <?php
                    foreach($dataTypes as $dataType){
                        if($dataType['id']== 2){
                            echo "<option value='".$dataType['id']."' selected>".$dataType['name']."</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="categorurl">Min Role</label>
                <input type="text" class="form-control" name="minrole" placeholder="Min role">
            </div>
            <input style="display: none; "type="text" class="form-control" name="action" id="actionmodule" placeholder="Nom" value="add">
            <button type="submit" class="btn btn-primary btn-block">Valider</button>
        </form>
    </div>
    <?php if(isset($_GET['action']) && $_GET['action']=='modifymod'): ?>
        <div class="row">
            <h4>Modifier un module</h4>
            <form method="POST" id="modifymodule" class="col-md-8">
                <div class="form-group" class="col-md-8">
                    <label for="categoryname">Nom</label>
                    <input type="text" class="form-control" name="name" id="modulename" placeholder="Nom" value='<?=$modify['name']?>'>
                </div>
                <div class="form-group">
                    <label for="categorurl">Nom du fichier</label>
                    <input type="text" class="form-control" name="folder" id="moduleurl" placeholder="Nom" value='<?=$modify['folder']?>'>
                </div>
                <div class="form-group">
                    <label for="modulecategory">Categorie</label>
                    <select class="form-control" name="category">
                        <?php
                        foreach($titles as $title){
                            if($title['id']==$modify['category']){
                                echo "<option value='".$title['id']."' selected>".$title['name']."</option>";
                            }else{
                                echo "<option value='".$title['id']."'>".$title['name']."</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="categorurl">Min Role</label>
                    <input type="text" class="form-control" name="minrole" placeholder="Min role" value='<?=$modify['minrole']?>'>
                </div>
                <input style="display: none; "type="text" class="form-control" name="action" id="actionmodule" placeholder="Nom" value="modifymod">
                <button type="submit" class="btn btn-primary btn-block">Valider</button>
            </form>
        </div>
    <?php endif;?>
    <hr>
    <div class="row">
        <h3>Toutes les catégories</h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Url</th>
                    <th width="100px"></th>
                    <th width="100px"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($titles as $key => $title): ?>
                    <tr>

                        <td align="center"><?php echo $title['id'] ?></td>
                        <td><?= $title['name']?></td>
                        <td><?=$title['folder']?></td>
                        <td align="center"><a href="adminModule.php?action=modifycat&id=<?= $title['id']?>"><button class="btn btn-info btn-block" title="Validate Modification" type="submit">Modifier</button></a></td>
                        <td align="center"><a href="adminModule.php?action=delete&id=<?= $title['id']?>"><button class="btn btn-danger btn-block" title="Delete Entry">Supprimer</button></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <h4>Ajouter une nouvelle catégorie <a href="Javascript:afficherCacher('newcategory','glyphiconcategory')"><span class="glyphicon glyphicon-triangle-bottom" id="glyphiconcategory" aria-hidden="true"></span></a></h4>
        <form method="POST" style="display:none;" id="newcategory" class="col-md-8">
            <div class="form-group">
                <label for="categoryname">Nom</label>
                <input type="text" class="form-control" name="name" id="categoryname" placeholder="Nom">
            </div>
            <div class="form-group">
                <label for="categorurl">Nom du dossier</label>
                <input type="text" class="form-control" name="folder" id="categorurl" placeholder="Folder Name">
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control" name="type">
                    <?php
                    foreach($dataTypes as $dataType){

                        if($dataType['id']== 1){
                            echo "<option value='".$dataType['id']."' selected>".$dataType['name']."</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <input style="display: none; "type="text" class="form-control" name="action" id="actionmodule" placeholder="Nom" value="add">
            <button type="submit" class="btn btn-primary btn-block">Valider</button>
        </form>
    </div>
    <?php if(isset($_GET['action']) && $_GET['action']=='modifycat'): ?>
        <div class="row">
            <h4>Modifier une catégorie</h4>
            <form method="POST" id="modifymodule" class="col-md-8">
                <div class="form-group" class="col-md-8">
                    <label for="categoryname">Nom</label>
                    <input type="text" class="form-control" name="name" id="modulename" placeholder="Nom" value='<?=$modify['name']?>'>
                </div>
                <div class="form-group">
                    <label for="categorurl">Nom du dossier</label>
                    <input type="text" class="form-control" name="folder" id="moduleurl" placeholder="Nom" value='<?=$modify['folder']?>'>
                </div>
                <input style="display: none; "type="text" class="form-control" name="action" id="actionmodule" placeholder="Nom" value="modifycat">
                <button type="submit" class="btn btn-primary btn-block">Valider</button>
            </form>
        </div>
    <?php endif;?>
    <hr>

</div>
<?php require "../conf/footer.php";
