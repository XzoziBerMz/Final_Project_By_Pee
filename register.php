<?php
session_start(); //เรียกใช้งานsession
require_once "header.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> สมัครเข้าใช้งาน </title>

    <!-- คำสั่งbootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- css -->
    <link rel="stylesheet" href="custom/mains.css">
    <link rel="stylesheet" href="custom/body.css">

    <style>
        .new_container {
            width: 600px;
            padding: 30px;
            border: 1px;
            border-radius: 50px;
            background-color: #fff;
        }
    </style>
</head>

<body>
    <div class="new_container m-auto mt-5" style="margin-top: 30px;">
        <h3 class="mt-4">
            <p class="focus-in-expand">REGISTER</p>
        </h3>
        <hr>

        <!-- ทำแบบฟอร์ม -->
        <form action="register_db.php" method="POST">

            <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>

            <?php if (isset($_SESSION['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['warning'])) { ?>
                <div class="alert alert-warning" role="alert">
                    <?php
                    echo $_SESSION['warning'];
                    unset($_SESSION['warning']);
                    ?>
                </div>
            <?php } ?>

            <div class="mb-4">
                <input type="text" class="form-control" name="firstname" placeholder="ชื่อจริง">
            </div>
            <div class="mb-4">
                <input type="text" class="form-control" name="lastname" placeholder="นามสกุล">
            </div>
            <div class="mb-4">
                <input type="text" class="form-control" name="email" placeholder="อีเมล">
            </div>
            <div class="mb-4">
                <input type="password" class="form-control" name="password" placeholder="รหัสผ่าน">
            </div>
            <div class="mb-4">
                <input type="password" class="form-control" name="confirm_password" placeholder="ยืนยันรหัสผ่าน">
            </div>


            <div class="d-grid">
                <button type="submit" class="button-27" role="button" name="register">ยืนยันการลงทะเบียน</button>
            </div>

        </form>

        <hr>
        <p class="text-start" style="margin-bottom: 3px">เป็นสมาชิกใช่ไหม คลิ้กที่นี่เพื่อ <a href="signin.php">
                เข้าสู่ระบบ</a></p>
    </div>

</body>

</html>