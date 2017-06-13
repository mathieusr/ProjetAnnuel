<?php $minrole= 4; require "../conf/header.php"; require "articlesWriteData.php";?>

<div class="row">
    <h3 style="padding-left: 15px;">Article n°<?= $_GET['articleId'] ?></h3>
    <div style="background-color: #ddd;display: flex;align-items: center;padding: 10px 15px 10px 15px;">
        <p class="lead col-sm-1" style="margin: 0;">Title</p>
        <input type="text" name="title" id="test" class="form-control saveInput col-sm-11" base="news" columnname="title" value="<?= $article['title'] ?>">
    </div>
    <div style="background-color: #fff;display: flex;align-items: center;padding: 5px 10px 10px 10px;">
        <p class="lead col-sm-1" style="margin:0;">Image principale<button type="button" class="btn btn-primary btn-sm articleImg" data-toggle="modal" data-target="#myModal" action="principalImg" titreHeader="Sélection de l'image principale">
                Choisir
            </button></p>
        <div id="principalImg" class="col-sm-11">
            <div style="box-shadow: 0 2px 2px 0 rgba(0,0,0,0.16), 0 0 0 1px rgba(0,0,0,0.08);width:250px;height:150px;background-size:contain;background-image: url('../img/articles/<?php echo $article['dateCreation2']."/".$article['dateCreation']."-".sprintf('%04d',$article['presentationImg']).".png" ?>');background-repeat: no-repeat;margin: 10px;">
            </div>
        </div>
    </div>
    <div style="background-color: #ddd;display: flex;align-items: center;padding: 10px 15px 10px 15px;">
        <p class="lead col-sm-1" style="margin:0;">Mon texte</p>
        <div class="col-sm-11">
            <input type="button" value="G" style="font-weight:bold;" onclick="addstyle('bold')">
            <input type="button" value="I" style="font-style:italic;" onclick="addstyle('italic')">
            <input type="button" value="S" style="text-decoration:underline;" onclick="addstyle('underline')">
            <input type="button" value="T" title="Supprimer la mise en forme" style="text-decoration:line-through;" onclick="addstyle('removeFormat')">
            <div class="form-control" id="editor" contenteditable style="height: 400px;overflow: hidden;overflow-y: auto;" base="news" columnname="text" ><?= $article['text'] ?></div>
        </div>
    </div>
    <div style="background-color: #fff;display: flex;align-items: center;padding: 10px 15px 10px 15px;" id="myPicture">
    </div>
    <div style="padding:10px 15px 10px 15px;background-color: #dddddd;">
        <a href="articles.php" class="btn btn-primary btn-block">Terminer</a>
    </div>
</div>

<?php
require "../conf/footer.php";