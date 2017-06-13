<?php
    $minrole=4;
    require "../conf/header.php";
    require "adminUsersData.php";
?>
<div class="row">
    <div class="row">
        <h3>Tous les utilisateurs</h3>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th width="100px"></th>
                    <th width="100px"></th>
                    <th width="100px"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td align="center"><?php echo $user['id'] ?></td>
                        <td><?= $user['firstName']." ".$user['lastName']?></td>
                        <td><?php if($user['statusId']==1){echo 'Actif';}else{echo 'Inactif';}?></td>
                        <td><?php
                            foreach($roles as $role){
                                if($role['id']== $user['roleId']) {
                                    echo $role['name'];
                                }
                            }
                            ?>
                        </td>
                        <td align="center"><a href="adminUsers.php?action=modifyuser&id=<?= $user['id'] ?>#usersmail"><button class="btn btn-info btn-block" title="Validate Modification">Modifier</button></a></td>
                        <td align="center"><a href="adminUsers.php?action=deleteuser&id=<?= $user['id'] ?>"><button class="btn btn-danger btn-block" title="Delete Entry">Supprimer</button></a></td>
                        <td align="center"><a href="adminUsers.php?action=<?php if($user['statusId']==1){echo 'disable';}else{echo 'enable';} ?>user&id=<?= $user['id'] ?>"><button class="btn btn-warning btn-block" title="Delete Entry"><?php if($user['statusId']==1){echo 'Désactiver';}else{echo 'Activer';} ?></button></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if(isset($_GET['action']) && $_GET['action']=='modifyuser'): ?>
        <div class="row">
            <h4>Modifier un utilisateur<a href="Javascript:afficherCacher('modifyusers','glyphiconuser')"><span class="glyphicon glyphicon-triangle-bottom" id="glyphiconuser" aria-hidden="true"></span></a></h4>
            <form method="POST" id="modifyusers" class="col-md-8" style="display: block;">
                <div class="form-group">
                    <label for="categoryname">Email</label>
                    <input type="text" class="form-control" name="email" id="usersmail" placeholder="Email" value='<?=$modify['email']?>'>
                </div>
                <div class="form-group">
                    <label for="categorurl">Prenom</label>
                    <input type="text" class="form-control" name="firstname" id="moduleurl" placeholder="Prenom" value='<?=$modify['firstName']?>'>
                </div>
                <div class="form-group">
                    <label for="categorurl">Nom</label>
                    <input type="text" class="form-control" name="lastname" id="moduleurl" placeholder="Nom" value='<?=$modify['lastName']?>'>
                </div>
                <div class="form-group">
                    <label for="categorurl">Date d'anniversaire</label>
                    <input type="date" class="form-control" name="birthday" id="moduleurl" placeholder="Date d'anniversaire" value='<?= $modify['birthday'] ?>'>
                </div>
                <div class="form-group">
                    <label for="categorurl">Adresse</label>
                    <input type="text" class="form-control" name="adress" id="moduleurl" placeholder="Adresse" value='<?=$modify['adress']?>'>
                </div>
                <div class="form-group">
                    <label for="categorurl">Code Postal</label>
                    <input type="text" class="form-control" name="postcode" id="moduleurl" placeholder="Code Postal" value='<?=$modify['postCode']?>'>
                </div>
                <div class="form-group">
                    <label for="categorurl">Ville</label>
                    <input type="text" class="form-control" name="city" id="moduleurl" placeholder="Ville" value='<?=$modify['city']?>'>
                </div>
                <div class="form-group">
                    <label for="categorurl">Numéro de téléphone</label>
                    <input type="tel" class="form-control" name="phonenumber" id="moduleurl" placeholder="Numéro de téléphone" value='<?=$modify['phoneNumber']?>'>
                </div>
                <div class="form-group">
                    <label for="modulecategory">Role</label>
                    <select class="form-control" name="role">
                        <?php
                        foreach($roles as $role){
                            if($role['id']==$modify['roleId']){
                                echo "<option value='".$role['id']."' selected>".$role['name']."</option>";
                            }else{
                                echo "<option value='".$role['id']."'>".$role['name']."</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="categorurl">Poids</label>
                    <input type="text" class="form-control" name="weight" placeholder="Poids" value='<?=$modify['weight']?>'>
                </div>
                <div class="form-group">
                    <label for="categorurl">Taille</label>
                    <input type="text" class="form-control" name="height" placeholder="Taille" value='<?=$modify['height']?>'>
                </div>
                <div class="form-group">
                    <label for="categorurl">Numéro de maillot</label>
                    <input type="text" class="form-control" name="shirtnumber" placeholder="Numéro de maillot" value='<?=$modify['shirtNumber']?>'>
                </div>
                <div class="form-group">
                    <label for="categorurl">Photo de présentation</label>
                    <input type="file" class="form-control" name="identitypicture" placeholder="Nom">
                </div>
                <input type="hidden" class="form-control" name="action" value="modifyusers">
                <button type="submit" class="btn btn-primary btn-block">Valider</button>
            </form>
        </div>
    <?php endif;?>
</div>
<?php require "../conf/footer.php"; ?>
