<?php include "db.php"?>
<?php

    session_start();
    
    if(isset($_POST["signUp"])){ // ถ้ามีการกดปุ่ม signUp
        $username = $_POST["member_name"];
        $email = $_POST["member_email"];
        $tel = $_POST["member_tel"];
        $password = $_POST["password"];
        $c_password = $_POST["c_password"];

        // check ว่าทุกตัวมีการกรอกเข้ามาครบมั้ย
        if(empty($username)){
            $_SESSION['error'] = 'กรุณากรอกชื่อผู้ใช้';
            header('location: signUp.php');
        }
        else if(empty($email)){
            $_SESSION['error'] = 'กรุณากรอกอีเมลล์';
            header('location: signUp.php');
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ // check รูปแบบอีเมลล์
            $_SESSION['error'] = 'รูปแบบอีเมลล์ไม่ถูกต้อง';
            header('location: signUp.php');
        }
        else if(empty($password)){
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            header('location: signUp.php');
        }
        else if(empty($c_password)){
            $_SESSION['error'] = 'กรุณายืนยันรหัสผ่าน';
            header('location: signUp.php');
        }
        else if($password != $c_password){ // check ว่า password = c_password
            $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
            header('location: signUp.php');
        }
        else{
            try{
                $check_email = $pdo->prepare("SELECT member_email FROM member WHERE member_email = ?"); // ใส่ : แทนค่าตัวแปร ไม่ใส่ตรงๆ
                $check_email->bindParam(1,$email);
                $check_email->execute();
                $row = $check_email->fetch(PDO::FETCH_ASSOC);
                if($row['email'] == $email){
                    $_SESSION['warning'] = "มีอีเมลล์นี้อยู่ในระบบแล้ว <a href='signIn.php'>เข้าสู่ระบบ</a>";
                    header('location: signUp.php');
                }
                else if(!isset($_SESSION['error'])){
                    $stmt = $pdo->prepare("INSERT INTO member (member_name,member_tel,member_email,`password`) VALUES (?,?,?,?)");
                    $stmt->bindParam(1, $_POST["member_name"]);
                    $stmt->bindParam(2, $_POST["member_tel"]);
                    $stmt->bindParam(3, $_POST["member_email"]);
                    $stmt->bindParam(4, $_POST["password"]);
                    $stmt->execute();
                    $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว <a href='signIn.php' class='alert-link'>เข้าสู่ระบบ</a>";
                    header('location: signUp.php');
                }
                else{
                    $_SESSION['error'] = 'มีบางอย่างผิดพลาด';
                    header('location: signUp.php');
                }
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    } 
    
?>

