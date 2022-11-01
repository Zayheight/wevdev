<?php include "db.php"?>
<?php

    session_start();
    
    if(isset($_POST["signIn"])){ // ถ้ามีการกดปุ่ม signIn
        $email = $_POST["member_email"];
        $password = $_POST["password"];

        if(empty($email)){
            $_SESSION['error'] = 'กรุณากรอกอีเมลล์';
            header('location: signIn.php');
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ // check รูปแบบอีเมลล์
            $_SESSION['error'] = 'รูปแบบอีเมลล์ไม่ถูกต้อง';
            header('location: signIn.php');
        }
        else if(empty($password)){
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            header('location: signIn.php');
        }
        else{
            try{
                $check_data = $pdo->prepare("SELECT * FROM member WHERE member_email = ?"); // ใส่ : แทนค่าตัวแปร ไม่ใส่ตรงๆ
                $check_data->bindParam(1,$email);
                $check_data->execute();
                $row = $check_data->fetch(PDO::FETCH_ASSOC);
                if($check_data->rowCount() > 0){ // ข้อมูลที่loginมา มีรึป่าว -> มากกว่า 0 = มีข้อมูล
                    if($email == $row['member_email']){
                        if($password == $row['password']){
                            $_SESSION['user_login'] = $row['member_id'];
                            header('location: home.php');
                        }
                        else{
                            $_SESSION['error'] = 'รหัสผ่านผิด';
                            header('location: signIn.php');
                        }
                    }
                    else{
                        $_SESSION['error'] = 'อีเมลล์ผิด';
                        header('location: signIn.php');
                    }
                }
                else{
                    $_SESSION['error'] = 'ไม่มีข้อมูลในระบบ';
                    header('location: signIn.php');
                }
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    } 
    
?>

