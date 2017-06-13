<?php
if(!empty($_POST['action'])){
    require "../settings/FolderName.php";
    require "../".FolderDb."/db.php";
    if($_POST['action'] == "addPrincipalImg"){
        $exec = $pdo->prepare("UPDATE NEWS SET presentationImg=:idimg WHERE id=:id");
        $exec->bindParam(':idimg',$_POST['idimg']);
        $exec->bindParam(':id',$_POST['articleId']);
        $exec->execute();

        $exec = $pdo->prepare("SELECT folder,CONVERT(varchar,dateCreation,112) AS dateCreation,CONVERT(date,dateCreation,120) AS dateCreation2,id FROM IMAGE WHERE Id=:id");
        $exec->bindParam(':id',$_POST['idimg']);
        $exec->execute();
        $images = $exec->fetch(PDO::FETCH_ASSOC);

        echo "<div class='imagePresentation' style='background-image: url(\"../img/articles/".$images['dateCreation2']."/".$images['dateCreation']."-".sprintf('%04d',$images['id']).".png\");'>";

        echo "</div>";
        exit();
    }elseif($_POST['action'] == "loadImg"){
            echo "<div class='row' >
                    <div class='col-sm-12'>
                        <form method='POST' class='col-md-12 form-inline ajax' data-titreselection='".$_POST['titreselection']."' data-function='changeDateImg' data-url='articlesWriteData.php' data-action='".$_POST['action']."' data-want='".$_POST['want']."'>
                            <div class='form-group'>
                                <label>Date photo</label>
                                <input type='date' name='photodate' class='form-control' value='"; if(isset($_POST['photoDate'])){echo $_POST['photoDate'];}else{$test = new DateTime(); echo $test->format('Y-m-d');}echo  "'>
                            </div>
                            <input type='submit' class='btn btn-default' value='Choisir'>
                        </form>
                    </div>
                </div>
                <hr>
                <div class='row'>
                    <div class='col-sm-12' style='display: flex;flex-wrap: wrap;justify-content: space-around'>";

            if(!empty($_POST['photodate'])){
                $test = new DateTime($_POST['photodate']);
                $datetocompare = $test->format('Y-m-d H:i:s.u');
            }else{
                $test = new DateTime();
                $datetocompare = $test->format('Y-m-d H:i:s.u');
            }
            $exec = $pdo->prepare("SELECT folder,CONVERT(varchar,dateCreation,112) AS dateCreation,CONVERT(date,dateCreation,120) AS dateCreation2,id FROM IMAGE WHERE DATEDIFF(day,:date,dateCreation) = 0 AND folder='articles' ORDER BY dateCreation ASC");
            $exec->bindParam(':date',$datetocompare);
            $exec->execute();
            $images = $exec->fetchAll(PDO::FETCH_ASSOC);
            if(!empty($images)){
                foreach($images as $image){
                    echo "
                    <div class='imagePresentation' style='background-size:contain;background-image: url(\"/img/articles/".$image['dateCreation2']."/".$image['dateCreation']."-".sprintf("%04d",$image['id']).".png \");display: flex;align-items: flex-end;' class='col-sm-4 img-rounded'>
                    <button data-dismiss='modal' class='addImage' type='button' style='background-color: rgba(0, 0, 0, 0.4);color: #fff;height: 25px;width: 100%;border-style: none;' title='".$_POST['titreselection']."'   data-idImg='".$image['id']."' data-action='".$_POST['want']."' data-url='articlesWriteData.php' data-function=''>".$_POST['titreselection']."</button>
                    </div>";
                }
            }else{
                echo "<i>Aucune image à cette date</i>";
            }

            echo "</div></div>";
            exit();
    }

}
if(empty($_GET['articleId'])){
   /* header('Location: articles.php');
    exit();*/
}

$exec = $pdo->prepare("SELECT NEWS.id,title,presentationImg,isPublish,CONVERT(varchar,IMAGE.dateCreation,112) AS dateCreation,CONVERT(date,IMAGE.dateCreation,120) AS dateCreation2 FROM NEWS LEFT JOIN IMAGE ON NEWS.presentationImg = IMAGE.id WHERE NEWS.Id=:id");
$exec->bindParam(':id',$_GET['articleId']);
$exec->execute();
$article = $exec->fetch(PDO::FETCH_ASSOC);