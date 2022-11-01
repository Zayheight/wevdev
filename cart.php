<?php include "db.php" ?>
<?php
    session_start();

    if(!isset($_SESSION['user_login'])){
        $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ';
        header('location: signIn.php');
    } 
?>
<!DOCTYPE html>
<html lang="en">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    * {
        font-family: 'Prompt', sans-serif; 
    } 
    body {
        background-color: #E0E0E0;
    }
    @media (max-width: 820px) { /* mobile */
        .header {
            background-color: #28A4FF;
            margin: 0px;
        }
    }
    @media (max-width: 1049.99px) { /* tablet */
        .header {
            background-color: #28A4FF;
            margin: 0px;
        }
    }
    @media(min-width: 1050px) { /* laptop */
        .header { 
            margin: -10px;
            padding: 20px 50px 20px 0px;
            font-size: 20px;
            color: #FFFFFF;
            text-align: right;
            background-color: #2C73C9;
        }  
        .button-logout a:link,a:visited {
            background-color: #FF5C5C;
            padding: 5px 10px;
            display: inline-block;
            text-decoration: none;
            border-radius: 3px;
            color: #FFFFFF;
            margin-top: 10px;

        }
        .button-logout a:hover {
            background-color: #CD5C5C;
        }
        .button-cart a.cart:link,a.cart:visited {
            background-color: #32CD32;
            padding: 5px 115px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            border-radius: 3px;
            color: #FFFFFF;
            margin-top: 5px;
        }
        img {
            max-width: 200px;
        }
        .items {
            display: flex;
            justify-content: center;
        }
        .items .box-container .box{
            text-align: center;
            border-radius: 5px;
            box-shadow: 0px 5px 10px #BEBEBE;
            border: 2px solid #000000;
            position: relative;
            padding: 20px 25px 20px 20px;
            max-width: 250px;
            margin: 20px;
            background-color: #FFFFFF;
        }
        .box-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }
        .items .box-container .box .add-to-cart {
            border: none;
            border-radius: 3px;
            background-color: #28A4FF; 
            margin-top: 10px;
            padding: 10px;
        }
        .items .box-container .box .add-to-cart:hover {
            background-color: #87CEEB; 
        }
        .items .box-container .box input[type="number"]{
            width: 100%;
            border: 2px solid #000000;
            border-radius: 5px;
            color: #000000;
            padding: 5px 5px 5px 10px;
            margin: 5px 0px;
        }
    } 
</style>
<body>
    <?php
    if (isset($_SESSION['user_login'])) {
        $member_id = $_SESSION['user_login'];
        $stmt = $pdo->prepare("SELECT * FROM member WHERE member_id = $member_id");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        

    }
    ?>
    <div class="header">
        <a class="" style="text-decoration: none; " href="./home.php">Home</a>

            <label>account : </label><a href="./profile.php"> <?php echo $row['member_name'];?></a>
            <span class="button-logout">
                <a href="signIn.php">Logout</a>
            </span>
            <form action="cart.php" method="post" class="box">
                <input type="hidden" name="member_id" value=<?php echo  $_SESSION['user_login'];?>>
                <input type="submit" name="adds" value="Cart" class="cart">
            </form>
        </div>
    <?php
    if (!empty($_POST['add'])) {
        if ($_POST['add'] === "Add To Cart") {
            if (empty($_COOKIE["order"])) {
                $a = date("Y-m-d H:i:s");
                $stmt = $pdo->prepare("INSERT INTO `order` (order_date,member_id,order_id) VALUES (?,?,null)");
                $stmt->bindParam(1, $a);
                $stmt->bindParam(2, $_POST["member_id"]);
                $stmt->execute();
                $order_id = $pdo->lastInsertId();
                setcookie("order", $order_id, time() + 3600 * 24);
                $stmt = $pdo->prepare("INSERT INTO `orderitem` (item_id,order_id,item_quantity) VALUES (?,?,?)");
                $stmt->bindParam(1, $_POST["item_id"]);
                $stmt->bindParam(2, $order_id);
                $stmt->bindParam(3, $_POST["item_quantity"]);
                $stmt->execute();
                $total_price = 0;
                $stmt = $pdo->prepare("SELECT item.item_id,item.item_name,item.item_price,orderitem.item_quantity
                               FROM `orderitem` INNER JOIN `item` WHERE orderitem.item_id = item.item_id and orderitem.order_id=$order_id");
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $total_price += ($row["item_quantity"] * $row["item_price"]);
    ?>
                    <div style="padding: 15px; text-align: center">
                        <form method="post" action="edit.php">
                            <img src='image/<?= $row["item_id"] ?>.jpg' width='100'><br>
                            <?= $row["item_name"] ?><?= $row["item_quantity"] ?> ชิ้น<br><?= $row["item_price"] ?> บาท
                            <input type="hidden" name="item_id" value=<?php echo $row['item_id']; ?>>
                            <input type="hidden" name="order_id" value=<?php echo $order_id; ?>>
                            <input type="submit" name="edit" value="+">
                            <input type="submit" name="edit" value="-">
                        </form>
                    </div>
                <?php
                }

                if (array_key_exists('submit', $_POST)) {
                    submit();
                }
                function submit()
                {
                    setcookie("order", "", time() + 3600 * 24);
                    header('location:home.php');
                }

                ?>
                <a>1</a>
                <form method="post">
                    <input type="submit" name="submit" value="submit" />
                </form>
                <?php
            }
            if (isset($_COOKIE["order"])) {
                function submit()
                {
                    setcookie("order", "", time() + 3600 * 24);
                    header('location:home.php');
                }
                if (array_key_exists('submit', $_POST)) {
                    submit();
                }

                $id = $_COOKIE['order'];
                $check = 0;
                $stmt = $pdo->prepare("SELECT * FROM `orderitem` WHERE order_id=(?)");
                $stmt->bindParam(1, $id);
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    if ($row["item_id"] === $_POST["item_id"]) $check++;
                }
                if ($check == 0) {
                    $stmt = $pdo->prepare("SELECT order_id FROM `order` WHERE member_id = (?) and order_id=(?)");
                    $stmt->bindParam(1, $_POST["member_id"]);
                    $stmt->bindParam(2, $id);
                    $stmt->execute();
                    $order_id = $stmt->fetch()[0];
                    $stmt = $pdo->prepare("INSERT INTO `orderitem` (item_id,order_id,item_quantity) VALUES (?,?,?)");
                    $stmt->bindParam(1, $_POST["item_id"]);
                    $stmt->bindParam(2, $order_id);
                    $stmt->bindParam(3, $_POST["item_quantity"]);
                    $stmt->execute();
                }

                $total_price = 0;
                $stmt = $pdo->prepare("SELECT item.item_id,item.item_name,item.item_price,orderitem.item_quantity
                               FROM `orderitem` INNER JOIN `item` WHERE orderitem.item_id = item.item_id and orderitem.order_id=$id");
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $total_price += ($row["item_quantity"] * $row["item_price"]);
                ?>
                    <div style="padding: 15px; text-align: center">
                        <form method="post" action="edit.php">
                            <img src='image/<?= $row["item_id"] ?>.jpg' width='100'><br>
                            <?= $row["item_name"] ?><?= $row["item_quantity"] ?> ชิ้น<br><?= $row["item_price"] ?> บาท
                            <input type="hidden" name="item_id" value=<?php echo $row['item_id']; ?>>
                            <input type="hidden" name="order_id" value=<?php echo $_COOKIE['order']; ?>>
                            <input type="submit" name="edit" value="+">
                            <input type="submit" name="edit" value="-">
                        </form>
                    </div>
                <?php
                }
                ?>
                <a>2</a>
                <form method="post">
                    <input type="submit" name="submit" value="submit" />
                </form>
            <?php
            }
        }
    } else {
        if (!isset($_COOKIE["order"])) {
            ?>
            <h>เลือกสินค้าก่อน</h>
            <?php
        } else {
            function submit()
            {
                setcookie("order", "", time() + 3600 * 24);
                header('location:home.php');
            }
            if (array_key_exists('submit', $_POST)) {
                submit();
            }

            $total_price = 0;
            $id = $_COOKIE['order'];
            $stmt = $pdo->prepare("SELECT item.item_id,item.item_name,item.item_price,orderitem.item_quantity
                                    FROM `orderitem` INNER JOIN `item` WHERE orderitem.item_id = item.item_id and orderitem.order_id=$id");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $total_price += ($row["item_quantity"] * $row["item_price"]);
            ?>
                <div style="padding: 15px; text-align: center">
                    <form method="post" action="edit.php">
                        <img src='image/<?= $row["item_id"] ?>.jpg' width='100'><br>
                        <?= $row["item_name"] ?><?= $row["item_quantity"] ?> ชิ้น<br><?= $row["item_price"] ?> บาท
                        <input type="hidden" name="item_id" value=<?php echo $row['item_id']; ?>>
                        <input type="hidden" name="order_id" value=<?php echo $_COOKIE['order']; ?>>
                        <input type="submit" name="edit" value="+">
                        <input type="submit" name="edit" value="-">
                    </form>
                </div>
            <?php
            }
            ?>
            <a><? $total_price ?></a>
            <form method="post">
                <input type="submit" name="submit" value="submit" />

            </form>
    <?php
        }
    }

    ?>


</body>

</html>