<?php $minrole=0;require "settings/header.php"; require "indexData.php"?>
<div class="row">
    <div class="col-md-12" style="display: flex;justify-content: space-around;flex-wrap: wrap-reverse;">
        <?php foreach ($articles as $key => $article): ?>
            <div style="width: 300px;">
                <a href="articles/articleRead.php?articleId=<?php echo $article['id'] ?>"><img style="width: 300px;" src="img/articles/<?php echo $article['dateCreation2']."/".$article['dateCreation']."-".sprintf('%04d',$article['idImage'])?>.png"></a>
                <h3 style="margin-top: 10px;">
                    <a href="articles/articleRead.php?articleId=<?php echo $article['id'] ?>" style="color:#2980b9;"><?php echo $article['title'] ?></a>
                </h3>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div>
    <p>Test</p>
</div>
<?php require FolderSettings."/footer.php"; ?>


