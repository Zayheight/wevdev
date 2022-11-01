<?php include "db.php" ?>
<?php
session_start();

if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ';
    header('location: signIn.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    * {
        font-family: 'Prompt', sans-serif;
    }

    body {
        background-color: #E0E0E0;
    }

    .profile-component {
        background-color: white;
        padding: 60px;
    }

    .nav-item .nav-link {
        color: #2C73C9;
    }

    .row {
        margin: 39px;
    }

    .col-md-6 p {
        color: #2C73C9;
    }

    .button .edit {
        border: none;
        border-radius: 30px;
        padding: 5px 10px;
        color: #6c757d;
        background-color: #E0E0E0;
    }

    @media (max-width: 820px) {

        /* mobile */
        .header {
            background-color: #28A4FF;
            margin: 0px;
        }
    }

    @media (max-width: 1049.99px) {

        /* tablet */
        .header {
            background-color: #28A4FF;
            margin: 0px;
        }
    }

    @media(min-width: 1050px) {

        /* laptop */
        .header {
            margin: -10px;
            padding: 20px 50px 20px 0px;
            font-size: 20px;
            color: #FFFFFF;
            text-align: right;
            background-color: #2C73C9;
        }

        .button-logout a:link,
        a:visited {
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

        .button-cart a.cart:link,
        a.cart:visited {
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




    }
</style>

<body>
    <div class="profile">
        <?php
        if (isset($_SESSION['user_login'])) {
            $member_id = $_SESSION['user_login'];
            $stmt = $pdo->prepare("SELECT * FROM member WHERE member_id = $member_id");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        ?>
        <?php
        $sql = $pdo->prepare("SELECT orderitem.item_quantity,item.item_name,item.item_price,order.order_date
        FROM `order`
        INNER JOIN orderitem
        ON `order`.order_id = orderitem.order_id
        INNER JOIN `member`
        ON member.member_id = order.member_id
        INNER JOIN `item`
        ON orderitem.item_id = item.item_id
        WHERE `member`.member_id=$member_id");
        $sql->execute();

        ?>

        <div class="header">
            <a class="" style="text-decoration: none; " href="./home.php">Home</a>

            <label>account : </label><a href="./profile.php"><?php echo $row['member_name']; ?></a>
            <span class="button-logout">

                <a href="signIn.php">Logout</a>
            </span>
            
        </div>
        <section>
            <div class="profile-component">

                <?php
                $mem = $pdo->prepare("SELECT * FROM member WHERE member_id = $member_id");
                $mem->execute();
                if ($mem->rowCount() > 0) {
                    while ($row = $mem->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <div action="" method="post" class="profilebox">
                            <h1>ข้อมูลส่วนตัว</h1>
                            <div class=""><?php echo $row['member_name']; ?></div>
                            <p>รหัสสมาชิก : <?php echo $row['member_id']; ?> </p>

                        </div>

                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link " href="./profile.php">ข้อมูลส่วนตัว</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="./history.php">ประวัติการสั่งซื้อ</a>
                            </li>

                        </ul>
                            <table class="table" >
                                <th>สินค้า</th>
                                <th>ราคา</th>
                                <th>จำนวน</th>
                                <th>วัน เดือน ปี</th>

                                <?php while ($row = $sql->fetch()) { ?>
                                    <tr class="table-light">
                                        <td><?= $row["item_name"] ?></td>
                                        <td><?= $row["item_price"]*$row["item_quantity"] ?></td>
                                        <td><?= $row["item_quantity"] ?></td>
                                        <td><?= $row["order_date"] ?></td>
                                        
                                    </tr>
                                <?php } ?>
                            </table>
                        
                <?php
                    };
                };
                ?>
            </div>
        </section>
    </div>
</body>

</html>