<?php
$minrole = 0;
require "../settings/header.php";
if(!empty($_SESSION['userInformation'])){header('Location: ../index.php');}
if(!empty($_SESSION['form_post'])){
    foreach ($_SESSION['form_post'] as $key => $value) {
        $values[$key] = $value;
    }
    unset($_SESSION['form_post']);
}

?>
<div class="row">

    <h3>Inscription</h3>
    <form method="POST" id="modifyusers" action="registerVerify.php" class="col-md-12">
        <div class="form-group">
            <label for="categoryname">Email</label>
            <input type="text" class="form-control" name="email" id="usersmail" placeholder="Email" value='<?= isset($values['email'])?$values['email']:''?>'>
        </div>
        <div class="form-group">
            <label for="categorurl">Prenom</label>
            <input type="text" class="form-control" name="firstname" placeholder="Prenom" value='<?= isset($values['firstname'])?$values['firstname']:''?>'>
        </div>
        <div class="form-group">
            <label for="categorurl">Nom</label>
            <input type="text" class="form-control" name="lastname" placeholder="Nom" value='<?= isset($values['lastname'])?$values['lastname']:''?>'>
        </div>
        <div class="form-group">
            <label for="categorurl">Mot de Passe</label>
            <input type="password" class="form-control" name="pwd" placeholder="Mot de passe">
        </div>
        <div class="form-group">
            <label for="categorurl">Confirmer votre mot de passe</label>
            <input type="password" class="form-control" name="pwd2" placeholder="Confirmer votre mot de passe">
        </div>
        <div class="form-group">
            <label for="categorurl">Date d'anniversaire</label>
            <input type="date" class="form-control" name="birthday" placeholder="Date d'anniversaire" value='<?= isset($values['birthday'])?$values['birthday']:''?>'>
        </div>
        <div class="form-group">
            <label for="categorurl">Adresse</label>
            <input type="text" class="form-control" name="adress" placeholder="Adresse" value='<?= isset($values['adress'])?$values['adress']:''?>'>
        </div>
        <div class="form-group">
            <label for="categorurl">Code Postal</label>
            <input type="text" class="form-control" name="postcode" placeholder="Code Postal" value='<?= isset($values['postcode'])?$values['postcode']:''?>'>
        </div>
        <div class="form-group">
            <label for="categorurl">Ville</label>
            <input type="text" class="form-control" name="city" placeholder="Ville" value='<?= isset($values['city'])?$values['city']:''?>'>
        </div>
        <div class="form-group">
            <label for="categorurl">Numéro de téléphone</label>
            <input type="tel" class="form-control" name="phonenumber"  placeholder="Numéro de téléphone" value='<?= isset($values['phonenumber'])?$values['phonenumber']:''?>'>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="<?= isset($values['cgu'])?$values['cgu']:''?>" name="cgu">
                J'accepte les CGU
            </label>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Valider</button>
    </form>
</div>

<?php require "../".FolderSettings."/footer.php"; ?>
