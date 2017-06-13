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
    <h3>Connexion</h3>
    <form method="POST" class="col-md-12" action="/<?php echo FolderAdmin ?>/loginVerify.php">
        <div class="form-group">
            <label for="categoryname">Email</label>
            <input type="text" class="form-control" name="email" id="usersmail" placeholder="Email" value='<?= isset($values['email'])?$values['email']:''?>'>
        </div>
        <div class="form-group">
            <label for="categorurl">Mot de Passe</label>
            <input type="password" class="form-control" name="pwd" placeholder="Mot de passe">
        </div>
        <a href="/admin/requirePassword.php">Mot de passe oublié</a>
        <button style="margin-top:10px;" type="submit" class="btn btn-primary btn-block">Valider</button>
    </form>

</div>
<?php require "../".FolderSettings."/footer.php"?>
