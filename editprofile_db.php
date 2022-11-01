<?php include "db.php"?>

<?php 
    session_start();
    if(isset($_SESSION['user_login'])){
        $mem_id = $_SESSION['user_login'];
    }
    

    if(isset($_POST["confrim"])){ 
        $stmt = $pdo->prepare("UPDATE `member` SET member_name=? ,member_tel=?,member_email=? WHERE member_id=$mem_id");
        $stmt->bindParam(1,$_POST['mem_name']);
        $stmt->bindParam(2,$_POST['mem_tel']);
        $stmt->bindParam(3,$_POST['mem_email']);


        if($stmt->execute()){
            echo "Complete editing ".$_POST["mem_id"];
            header("location:profile.php");
        }


    }


?>