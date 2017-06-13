<?php $minrole= 4; 
	require "../settings/header.php";
	require "articlesData.php";?>
	
    <div class="row">
        <h3>Tous les articles</h3>
        <a href="articles.php?action=addarticle">Ajouter un nouvelle article</a>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="40">Id</th>
                        <th>Titre</th>
                        <!--<th>Contenu</th>-->
                        <th width="160">Dernière Modification</th>
                        <th width="80">Status</th>
                        <th width="80">Modifier</th>
                        <th width="80"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($allarticles as $key => $articles): ?>
                        <tr>
                            <td><?php echo $articles['id'] ?></td>
                            <td><?php echo $articles['title'] ?></td>
                            <!--<td><?php /*echo htmlspecialchars(substr($articles['text'],0,50)) */?></td>-->
                            <td><?php echo $articles['dtModification'] ?></td>
                            <td><?php echo $articles['isPublish']==1?'Publié':'Brouillon'; ?></td>
                            <td><a href="articlesWrite.php?articleId=<?php echo $articles['id']?>">Editer</a></td>
                            <?php if($articles['isPublish']==1): ?>
                                <td><a href="articles.php?articleId=<?php echo $articles['id']?>&action=remove">Retirer</a></td>
                            <?php else: ?>
                                <td><a href="articles.php?articleId=<?php echo $articles['id']?>&action=publish">Publier</a></td>
                            <?php endif; ?>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
require "../".FolderSettings."/footer.php";
