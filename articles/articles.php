<?php $minrole= 4; require "../conf/header.php"; require "articlesData.php";?>
    <div class="row">
        <h3>Tous les articles</h3>
        <a href="articles.php?action=addarticle">Ajouter un nouvelle article</a>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="40">Id</th>
                        <th>Titre</th>
                        <th>Contenu</th>
                        <th width="160">Dernière Modification</th>
                        <th width="80">Status</th>
                        <td width="80">Modifier</td>
                        <td width="80"></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($allarticles as $key => $articles): ?>
                        <tr>
                            <td><?= $articles['id'] ?></td>
                            <td><?= $articles['title'] ?></td>
                            <td><?= substr($articles['text'],0,50)."..." ?></td>
                            <td><?= $articles['dtModification'] ?></td>
                            <td><?php echo $articles['isPublish']==1?'Publié':'Brouillon'; ?></td>
                            <td><a href="articlesWrite.php?articleId=<?= $articles['id']?>">Editer</a></td>
                            <?php if($articles['isPublish']==1): ?>
                                <td><a href="articles.php?articleId=<?= $articles['id']?>&action=unpost">Retirer</a></td>
                            <?php else: ?>
                                <td><a href="articles.php?articleId=<?= $articles['id']?>&action=post">Publier</a></td>
                            <?php endif; ?>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
require "../".FolderConf."/footer.php";
