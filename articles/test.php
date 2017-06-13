<?php
require "../settings/FolderName.php";
require "../".FolderDb."/db.php";
$exec = $pdo->prepare("SELECT text FROM NEWS LEFT JOIN IMAGE ON NEWS.presentationImg = IMAGE.id WHERE NEWS.Id=:id");
$exec->bindParam(':id',$_GET['articleId']);
$exec->execute();
$articleText = $exec->fetch(PDO::FETCH_COLUMN);
?>
<html>
<head>
    <?php require $_SERVER['DOCUMENT_ROOT']."/settings/FolderName.php"?>
    <meta charset="utf-8">
    <title>Les loups de Paris</title>
    <link href= "/<?= FolderCss ?>/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="/<?= FolderCss ?>/general.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/<?= FolderImg ?>/logo.png" />
</head>
<body id="editor" contenteditable data-base="news" data-id="<?php echo $_GET['articleId'] ?>" data-columnname="text" style="padding: 6px;margin: 0;border-radius: 4px;border:0;">
<?php echo $articleText; ?>
</body>
</html>