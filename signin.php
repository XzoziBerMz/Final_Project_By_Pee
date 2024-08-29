<?php
session_start(); //เรียกใช้งานsession
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> ลงชื่อเข้าใช้ </title>

    <!-- คำสั่งbootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- css -->
    <link rel="stylesheet" href="custom/mains.css">
    <link rel="stylesheet" href="custom/body.css">

    <style>
        .new_container {
            width: 700px;
            padding: 40px;
            border-radius: 40px;
            background-color: #fff;
        }

        body {
            background-image: url(https://cdn.pixabay.com/photo/2020/02/06/09/12/mountain-4823516_1280.png);
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
        }
    </style>

</head>

<body class="d-flex justify-content-center align-items-center" style="margin-top: 100px;">
    <div>
        <div class="w-100 d-flex justify-content-center">
            <img src="image/Logo.png" alt="" style=" width: 140px; height: 140px;">
        </div>
        <!-- หัวเรื่อง -->
        <div class="new_container m-auto mt-4 blurred-box" style="text-align: center;">
            <h3 class="mt-4">
                <p class="focus-in-expand">LOGIN</p>
            </h3>
            <hr>
            <!-- ทำแบบฟอร์ม -->
            <form action="signin_db.php" method="post">

                <?php if (isset($_SESSION['error'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                        ?>
                    </div>
                <?php } ?>

                <div class="mb-2">
                    <label for="email" class="form-label"></label>
                    <input style="padding: 10px; margin-bottom: -12px;" type="text" class="form-control" name="email"
                        placeholder="อีเมล">
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label"></label>
                    <input style="padding: 10px;" type="password" class="form-control" name="password"
                        placeholder="รหัสผ่าน">
                </div>


                <div class="d-grid">
                    <button type="submit" name="signin" class="button-27 p-2 h-100 fs-4"
                        role="button">เข้าสู่ระบบ</button>
                </div>

            </form>
            <hr>
            <p class="text-start">ยังไม่ได้เป็นสมาชิกใช่ไหม คลิ๊กที่นี่เพื่อ <a href="register.php"> ลงทะเบียน</a></p>

            <hr>
            <p class="text-end"> <a href="index.php" style="color: gray;"> กลับหน้าหลัก</a></p>

        </div>
    </div>
</body>

</html>