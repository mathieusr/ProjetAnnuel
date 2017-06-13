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
    <h3>Réinitialisation mot de passe</h3>
    <form method="POST" class="col-md-12" action="/admin/requirePasswordGenerate.php">
        <div class="form-group">
            <label for="categoryname">Entrez votre email</label>
            <input type="text" class="form-control" name="email" id="usersmail" placeholder="Email" value='<?= isset($values['email'])?$values['email']:''?>'>
        </div>
        <button style="margin-top:10px;" type="submit" class="btn btn-primary btn-block">Valider</button>
    </form>

</div>
<?php require "../".FolderSettings."/footer.php"?>