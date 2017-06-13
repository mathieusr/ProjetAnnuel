
<?php $minrole = 4;require "../settings/header.php"; require "uploadImgData.php";?>
    <div class="row">
        <h3>Télécharger des fichiers</h3>
        <form method="post" enctype="multipart/form-data" id="uploadForm">
            <div class="form-group">
                <label>Catégorie</label>
                <select name="category" class="form-control">
                    <option>articles</option>
                    <option>products</option>
                </select>
            </div>
            <div class="form-group">
                <label>Mes photos</label>
                <input type="file" name="files[]" id="file" class="form-control" multiple>
            </div>
            <input style="margin-top:10px;" type="submit" class="btn btn-primary btn-block" value="Valider">
        </form>
    </div>
<?php require "../".FolderSettings."/footer.php"; ?>