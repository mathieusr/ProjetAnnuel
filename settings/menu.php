<?php require "menuData.php"; ?>
<div class="bandeau1" id="bandeau1" style="display: flex;align-items: center;padding-right: 40px;">
    <div style="flex: 9.3">
        <div class="menuIcon" onclick="openmenu()">
            <span></span>
        </div>
    </div>
    <?php if(empty($_SESSION['userInformation'])): ?>
        <a style="flex: 0.7;text-align: center;color: #fff;border-right:2px solid #fff;" href="/admin/login.php">Connexion</a>
        <a style="flex: 0.7;text-align: center;color: #fff;" href="/admin/register.php">Inscription</a>
    <?php else: ?>
        <a style="flex: 1;text-align: center;color: #fff;border-right:2px solid #fff;"><?php echo $_SESSION['userInformation']['fullName'] ?></a>
        <a style="flex: 0.7;text-align: center;color: #fff;" href="/admin/logout.php">Déconnexion</a>
    <?php endif; ?>
</div>
<div class="bandeau2" id="bandeau2">
    <?= $affiche ?>
</div>
