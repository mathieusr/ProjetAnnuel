<?php
require "../settings/header.php";
require "indexData.php";
?>
<?php
function display_tree($root,$pdo) {
    // retrieve the left and right value of the $root node
    $result = $pdo->prepare('SELECT bLeft,bRight FROM PRODUCTSCATEGORY WHERE name=:name');
    $result->bindValue(':name',$root);
    $result->execute();
    $row = $result->fetch(PDO::FETCH_ASSOC);
    // start with an empty $right stack
    $right = [];

    // now, retrieve all descendants of the $root node
    $result = $pdo->prepare('SELECT name,bLeft,bRight FROM PRODUCTSCATEGORY WHERE bLeft BETWEEN :left AND :right ORDER BY bLeft ASC');
    $result->bindValue(':left',$row['bLeft']);
    $result->bindValue(':right',$row['bRight']);
    $result->execute();
    $test = $result->fetchAll(PDO::FETCH_ASSOC);
    // display each row
    foreach ($test as $key => $row) {
        // only check stack if there is one
        if (count($right)>0) {
            // check if we should remove a node from the stack
            while ($right[count($right)-1]<$row['bRight']) {
                array_pop($right);
            }
        }

        // display indented node title
        echo "<div style='margin-left: ".(count($right) * 5)."px'>".$row['name']."</div>";

        // add this node to the stack
        $right[] = $row['bRight'];
    }

}
display_tree('Gamme',$pdo);

?>
<?php
require "../".FolderSettings."/footer.php";
