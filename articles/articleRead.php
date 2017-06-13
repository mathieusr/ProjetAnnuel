<?php
$minrole= 0;
require "../settings/header.php";
require "articleReadData.php";
?>
<div class="row">
    <div class="col-md-10 col-md-offset-1 articleDisplay">
        <h2><?php echo $article['title']; ?></h2>
        <p>Publié le <?php echo strftime("%A %d %B à %Hh%M",strtotime($article['dateCreation3'])); ?></p>
        <div style="margin-bottom: 25px;">
            <img width="100%" src='/img/articles/<?php echo $article['dateCreation2']."/".$article['dateCreation']."-".sprintf('%04d',$article['presentationImg']); ?>.png'>
        </div>
        <div style="padding: 12px" class="articleText">
            <?php echo $article['text'] ?>
        </div>
    </div>

</div>
<?php
require "../".FolderSettings."/footer.php";
?>
