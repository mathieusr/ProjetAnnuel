<?php $minrole= 4; require "../settings/header.php"; require "articlesWriteData.php";?>

<div class="row WriteArticle">
    <h3 style="padding-left: 15px;">Article n°<?= $_GET['articleId'] ?></h3>
    <div class="articleBlock" >
        <p class="lead col-sm-1">Title</p>
        <input type="text" name="title" id="test" class="form-control saveInput col-sm-11" data-base="news" data-columnname="title" value="<?= $article['title'] ?>" data-id="<?php echo $_GET['articleId'] ?>">
    </div>
    <div class="articleBlock">
        <p class="lead col-sm-1">Image principale<button type="button" class="btn btn-primary btn-sm ajax" data-toggle="modal" data-target="#myModal"  data-action=loadImg data-want="addPrincipalImg" data-titreheader="Sélection de l'image principale" data-titreselection="Choisir cette image de présentation" data-url="articlesWriteData.php" data-function="pictureChoose">
                Choisir
            </button></p>
        <div id="principalImg" class="col-sm-11">
            <?php if(!empty($article['presentationImg'])) : ?>
                <div class="imagePresentation" style="background-image: url('../img/articles/<?php echo $article['dateCreation2']."/".$article['dateCreation']."-".sprintf('%04d',$article['presentationImg']).".png" ?>');"></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="articleBlock">
        <p class="lead col-sm-1">Mon texte</p>
            <div class="col-sm-11" style="margin-bottom: 10px;">
                <select class="btn btn-default btn-sm selectStyle" data-action="fontName">
                    <option>Arial</option>
                    <option>Sans Serif</option>
                    <option>Serif</option>
                    <option>Comic sans ms</option>
                    <option>Garamond</option>
                    <option>Tahoma</option>
                    <option>Trebuchet MS</option>
                    <option>Verdana</option>
                </select>
                <select class="btn btn-default btn-sm selectStyle" data-action="fontSize">
                    <option value="1">Petite</option>
                    <option value="3">Normale</option>
                    <option value="4">Grande</option>
                    <option value="6">Très Grande</option>
                </select>
                <buton class="btn btn-default btn-sm TextColorButtonPopup" title="Couleur du texte">A</buton>
                <div class="popup" id="TextColorPopup">
                    <p>Couleur du texte</p>
                    <div class="textColor">
                        <div class="butonStyle TextColorButtonPopup" style="background-color:#fff;" data-action="foreColor" data-argument="#ffffff"></div>
                        <div class="butonStyle TextColorButtonPopup" style="background-color:#000;" data-action="foreColor" data-argument="#000000"></div>
                        <div class="butonStyle TextColorButtonPopup" style="background-color:#ff0000;" data-action="foreColor" data-argument="#ff0000"></div>
                    </div>
                </div>
                <buton class="butonStyle btn btn-default btn-sm" onclick="return false;" style="font-weight:bold;" data-action="bold">G</buton>
                <buton class="butonStyle btn btn-default btn-sm" onclick="return false;" style="font-style:italic;" data-action="italic">I</buton>
                <buton class="butonStyle btn btn-default btn-sm" onclick="return false;" style="text-decoration:underline;" data-action="underline">S</buton>
                <buton class="butonStyle btn btn-default btn-sm" onclick="return false;" title="Aligner à gauche" data-action="justifyLeft">L</buton>
                <buton class="butonStyle btn btn-default btn-sm" onclick="return false;" title="Aligner au centre" data-action="justifyCenter">C</buton>
                <buton class="butonStyle btn btn-default btn-sm" onclick="return false;" title="Aligner à droite" data-action="justifyRight">R</buton>
                <buton class="butonStyle btn btn-default btn-sm" onclick="return false;" title="Augmenter le retrait" data-action="indent">RL</buton>
                <buton class="butonStyle btn btn-default btn-sm" onclick="return false;" title="Diminuer le retrait" data-action="outdent">RR</buton>
                <buton class="butonStyle btn btn-default btn-sm" onclick="return false;" title="Liste à puce non ordonée" data-action="insertUnorderedList">.</buton>
                <buton class="butonStyle btn btn-default btn-sm" onclick="return false;" title="Liste à puce non ordonée" data-action="insertOrderedList">1</buton>
                <buton class="butonStyle btn btn-default btn-sm" onclick="return false;" title="Supprimer la mise en forme" style="text-decoration:line-through;" data-action="removeFormat">T</buton>
                <button onclick="return false;" type="button" class="btn btn-default btn-sm ajax" data-toggle="modal" data-target="#myModal" data-action=loadImg data-want="textImage" data-titreheader="Ajout d'une image" data-titreselection="Sélection de l'image" data-url="articlesWriteData.php" data-url="articlesWriteData.php" data-function="pictureChoose">
                    Image
                </button>
                <iframe src="test.php?articleId=<?php echo $_GET['articleId'] ?>" style="height: 400px;width:100%;padding:0" name="editor" scrolling="auto" class="form-control" id="editor"></iframe>
            </div>

    </div>
    <div class="articleBlock">
        <a href="articles.php" class="btn btn-primary btn-block">Terminer</a>
    </div>
</div>

<?php
require "../".FolderSettings."/footer.php";
?>
<script>
    window.onload = iFrameSave;
</script>
