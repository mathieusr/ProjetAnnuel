<!DOCTYPE html>
<?php
/*print_r($_SERVER);*/
/*phpinfo();
die();*/

?>
<html>
  <head>
      <?php session_start();require $_SERVER['DOCUMENT_ROOT']."/conf/confFolderName.php"?>
      <meta charset="utf-8">
      <title>Les loups de Paris</title>
      <link href= "/<?= FolderConfCss ?>/bootstrap.css" rel="stylesheet">
      <link rel="stylesheet" href="/<?= FolderConfCss ?>/confCss.css">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta charset="UTF-8">
      <link rel="icon" href="/<?= FolderImg ?>/logo.png" />
  </head>
  <body>
    <header>

    <?php
        if(!empty($_SESSION['userInformation']['roleid'])){$userrole = $_SESSION['userInformation']['roleid'];}else{$userrole = 0;}
        if($userrole < $minrole){
            header('Location: /index.php');
            exit();
        }
        require $_SERVER['DOCUMENT_ROOT']."/confConn/confConn.php";
        require $_SERVER['DOCUMENT_ROOT']."/conf/confMenu.php";
    ?>
    </header>
    <div class="contenu container">
        <?php if(!empty($_SESSION['status'])):?>
            <div class="row">
                <?php foreach ($_SESSION['status'] as $key => $status): ?>
                    <div class="alert alert-<?= $key ?> alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <ul>
                            <?php foreach ($status as $message): ?>
                                <li
                                ><?= $message; ?></li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                <?php endforeach;unset($_SESSION['status']);?>

            </div>
        <?php endif;?>