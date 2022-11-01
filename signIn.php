<?php
    session_start();
    include "db.php";
    setcookie("order","", time() + 3600 * 24);
    ?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign In</title>
    </head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        * {
            font-family: 'Prompt', sans-serif;
        } 
        @media (max-width: 820px) { /* mobile */
            * {
                font-size: 16px;
            }
            .container{
                border: 1px black solid;
                border-radius: 10px;
                padding: 10px 35px 10px 35px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                text-align:center;
            }
            .container .header{
                font-size: 20px;
            }
            .box{
                margin: 25px 0px 25px 0px;
            }
            .box .button-submit{
                padding: 5px 15px 5px 15px;
            }
            input {
                border: 1px black solid; 
                border-radius: 2px;
            }
            hr {
                border: 1px black solid; 
            }
        }
        @media (max-width: 1049.99px) { /* tablet */
            * {
                font-size: 20px;
                background-color: #E0E0E0;
            }
            .container {
                background-color: #FFFFFF;
            }
            form {
                background-color: #FFFFFF;
            }
            .container{   
                border: 1px black solid;
                border-radius: 10px;       
                padding: 20px 55px 20px 55px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                text-align:center;
            }
            h3.header{
                background-color: #FFFFFF;
                font-size: 25px;
            }
            label {
                background-color: #FFFFFF;
            }
            a {
                background-color: #FFFFFF
            }
            a:hover {
                color: #FF5C5C;
            }
            .box{
                background-color: #FFFFFF;
                margin: 25px 0px 25px 0px;
            }
            .box .button-submit:hover{
                background-color: #79C6FF;
            }
            .box .button-submit{
                padding: 5px 15px 5px 15px;
                border: none;
                border-radius: 3px;
                background-color: #28A4FF;
            }
            input {
                background-color: #FFFFFF;
                border: 1px black solid; 
                border-radius: 2px;
            }
            hr {
                border: 1px black solid; 
            }
        }
        @media(min-width: 1050px) { /* laptop */
            * {
                font-size: 18px;
                background-color: #E0E0E0;
            }
            .container {
                background-color: #FFFFFF;
            }
            form {
                background-color: #FFFFFF;
            }
            .container{
                border: 1px black solid;   
                border-radius: 10px;  
                padding: 50px 300px 50px 300px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                text-align:center;
            }
            h3.header{
                font-size: 25px;
                background-color: #FFFFFF;
            }
            label {
                background-color: #FFFFFF;
            }
            a {
                background-color: #FFFFFF
            }
            a:hover {
                color: #FF5C5C;
            }
            .box{
                background-color: #FFFFFF;
                margin: 25px 0px 25px 0px;
                display: block;
            }
            .box .button-submit:hover{
                background-color: #79C6FF;
            }
            .box .button-submit{
                padding: 5px 15px 5px 15px;
                border: none;
                border-radius: 3px;
                background-color: #28A4FF;
            }
            input {
                background-color: #FFFFFF;
                border: 1px black solid; 
                border-radius: 2px;
            }
            hr {
                border: 1px black solid; 
            }
        } 
    </style>
    <body>
        <div class="container">
            <h3 class="header">เข้าสู่ระบบ</h3>
            <hr>
            <form action="singIn_db.php" method="post">
                <?php if(isset($_SESSION['error'])) { ?>
                    <div class="alert-danger">
                        <?php 
                            echo $_SESSION['error'];
                            unset($_SESSION['error']); // ไม่ให้ session ค้าง
                        ?>
                    </div>
                <?php } ?>
                <?php if(isset($_SESSION['success'])) { ?>
                    <div class="alert-success">
                        <?php 
                            echo $_SESSION['success'];
                            unset($_SESSION['success']); // ไม่ให้ session ค้าง
                        ?>
                    </div>
                <?php } ?>
                <div class="box">
                    <label>Email</label><br>
                    <input type="email" class="box-input" name="member_email" placeholder="enter email">
                </div>
                <div class="box">
                    <label>Password</label><br>
                    <input type="password" class="box-input" name="password" placeholder="enter password">
                </div>
                <div class="box">
                    <button type="submit" class="button-submit" name="signIn">เข้าสู่ระบบ</button>
                </div>
                
            </form> 
            <hr>
            <a href="signUp.php">สมัครสมาชิก</a>
        </div>
    </body>
</html>