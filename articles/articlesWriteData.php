<?php
if(!empty($_POST['action'])){
    if($_POST['action'] == "addPrincipalImg"){
        require "../conf/confFolderName.php";
        require "../".FolderConfConn."/confConn.php";
        $exec = $pdo->prepare("UPDATE NEWS SET presentationImg=:idimg WHERE id=:id");
        $exec->bindParam(':idimg',$_POST['idImg']);
        $exec->bindParam(':id',$_POST['idArticle']);
        $exec->execute();

        $exec = $pdo->prepare("SELECT folder,CONVERT(varchar,dateCreation,112) AS dateCreation,CONVERT(date,dateCreation,120) AS dateCreation2,id FROM IMAGE WHERE Id=:id");
        $exec->bindParam(':id',$_POST['idImg']);
        $exec->execute();
        $images = $exec->fetch(PDO::FETCH_ASSOC);

        echo "<div style='box-shadow: 0 2px 2px 0 rgba(0,0,0,0.16), 0 0 0 1px rgba(0,0,0,0.08);width:250px;height:150px;background-size:contain;background-image: url(\"../img/articles/".$images['dateCreation2']."/".$images['dateCreation']."-".sprintf('%04d',$images['id']).".png\");display: flex;align-items: flex-end;background-repeat: no-repeat;margin: 10px;'>";

        echo "</div>";
        exit();
    }elseif($_POST['action'] == "loadImgForPr"){
            echo "<p class='lead col-sm-1' style='flex:1;margin:0;'>Mes photos</p>
                    <div class='col-sm-11'>
                        <form method='POST' class='col-md-12 form-inline' action=''>
                            <div class='form-group'>
                                <label>Date photo</label>
                                <input type='date' name='photodate' class='form-control' value= "; if(isset($_POST['photodate'])){echo $_POST['photodate'];}else{echo '';} echo ">
            </div>
            <button class='btn btn-default'>Choisir</button>
            </form>";
            $exec = $pdo->prepare("SELECT folder,CONVERT(varchar,dateCreation,112) AS dateCreation,CONVERT(date,dateCreation,120) AS dateCreation2,id FROM IMAGE WHERE DATEDIFF(day,{$datetocompare},dateCreation) = 0");
            $exec->execute();
            $images = $exec->fetchAll(PDO::FETCH_ASSOC);
            foreach($images as $image){
                echo "<div style='box-shadow: 0 2px 2px 0 rgba(0,0,0,0.16), 0 0 0 1px rgba(0,0,0,0.08);width:250px;height:150px;background-size:contain;background-image: url(\"../img/articles/".$image['dateCreation2']."/".$image['dateCreation']."-".sprintf("%04d",$image['id']).".png \");display: flex;align-items: flex-end;background-repeat: no-repeat;padding: none;margin:0 5px;' class='col-sm-4 img-rounded'>
                    <button class='addImage' type='button' style='background-color: rgba(0, 0, 0, 0.4);color: #fff;height: 25px;width: 100%;border-style: none;' title='Définir cette image comme image de présentation' idImg=".$image['id'].">Ajouter comme image principale</button>
                </div></div>";
            }
    }

}
if(empty($_GET['articleId'])){
    header('Location: articles.php');
    exit();
}

$exec = $pdo->prepare("SELECT NEWS.id,title,text,presentationImg,isPublish,CONVERT(varchar,IMAGE.dateCreation,112) AS dateCreation,CONVERT(date,IMAGE.dateCreation,120) AS dateCreation2 FROM NEWS LEFT JOIN IMAGE ON NEWS.presentationImg = IMAGE.id WHERE NEWS.Id=:id");
$exec->bindParam(':id',$_GET['articleId']);
$exec->execute();
$article = $exec->fetch(PDO::FETCH_ASSOC);

if(!empty($_POST['photodate'])){
    $datetocompare = $_POST['photodate'];
}else{
    $datetocompare = 'GETDATE()';
}


$exec = $pdo->prepare("SELECT folder,CONVERT(varchar,dateCreation,112) AS dateCreation,CONVERT(date,dateCreation,120) AS dateCreation2,id FROM IMAGE WHERE DATEDIFF(day,{$datetocompare},dateCreation) = 0");
$exec->execute();
$images = $exec->fetchAll(PDO::FETCH_ASSOC);