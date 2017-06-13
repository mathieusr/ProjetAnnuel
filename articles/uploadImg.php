
<?php $minrole = 4;require "../conf/header.php"; require "uploadImgData.php";?>
    <div class="row">
        <h3>Télécharger des fichiers</h3>
        <form method="post" enctype="multipart/form-data">
            <div>
                <input type="file" name="articleImg" class="form-control">
            </div>
            <button style="margin-top:10px;" type="submit" class="btn btn-primary btn-block">Valider</button>
        </form>
    </div>
<?php require "../conf/footer.php"; ?>