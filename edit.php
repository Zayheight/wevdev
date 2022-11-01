<?php include "db.php"?>

<?php
    if($_POST['edit']=="+"){
        $stmt = $pdo->prepare("SELECT item_quantity FROM `orderitem` WHERE item_id = (?) and order_id=(?)");
        $stmt->bindParam(1,$_POST['item_id']);
        $stmt->bindParam(2,$_POST['order_id']);
        $stmt->execute();
        $item_quantity= $stmt->fetch()[0]+1;
        $stmt = $pdo->prepare("UPDATE orderitem SET item_quantity=? WHERE item_id=?  and order_id=(?)");
        $stmt->bindParam(1, $item_quantity);
        $stmt->bindParam(2, $_POST['item_id']);
        $stmt->bindParam(3,$_POST['order_id']);
        $stmt->execute();
    }
    if($_POST['edit']=="-"){
        $stmt = $pdo->prepare("SELECT item_quantity FROM `orderitem` WHERE item_id = (?)  and order_id=(?)");
        $stmt->bindParam(1,$_POST['item_id']);
        $stmt->bindParam(2,$_POST['order_id']);
        $stmt->execute();
        $item_quantity= $stmt->fetch()[0]-1;
        if($item_quantity==0){
            $stmt = $pdo->prepare("DELETE FROM orderitem WHERE item_id=?  and order_id=(?)");
            $stmt->bindParam(1, $_POST['item_id']);
            $stmt->bindParam(2,$_POST['order_id']);
            $stmt->execute();
        }else{
            $stmt = $pdo->prepare("UPDATE orderitem SET item_quantity=? WHERE item_id=?  and order_id=(?)");
            $stmt->bindParam(1, $item_quantity);
            $stmt->bindParam(2, $_POST['item_id']);
            $stmt->bindParam(3,$_POST['order_id']);
            $stmt->execute();
        }
        
    }
    header('location:cart.php');
?>