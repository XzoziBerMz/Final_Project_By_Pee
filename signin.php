<?php
 session_start();
 require_once "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> ลงชื่อเข้าใช้ </title>

    <!-- คำสั่งbootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- css -->
    <link rel="stylesheet" href="custom/mains.css">
    <link rel="stylesheet" href="custom/body.css">

    <style>
            .new_container{
                width :700px;
                padding: 40px;
                border-radius: 40px;
                background-color: #fff;
            }
    </style>

</head>
<body>

<!-- หัวเรื่อง -->
<div class="new_container m-auto mt-5 blurred-box" style="margin-top: 30px; text-align: center;">
    <h3 class="mt-4"><p class="focus-in-expand">LOGIN</p></h3>
    <hr>
<!-- ทำแบบฟอร์ม -->
<form action="signin_db.php" method="post">

<?php if(isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>

  <div class="mb-3">
    <input type="text" class="user-username" name="email" placeholder="อีเมล">
</div>  

<hr>

    <div class="mb-3">
    <input type="password" class="user-password" name="password" placeholder="รหัสผ่าน">
</div>

<hr>

<div class="d-grid">
  <button type="submit" name="signin" class="button-27" role="button">เข้าสู่ระบบ</button>
</div>

</form>
<hr>
<p class="text-start">ยังไม่ได้เป็นสมาชิกใช่ไหม คลิ๊กที่นี่เพื่อ <a href="register.php"> ลงทะเบียน</a></p>

<hr>
<p class="text-end"> <a href="index.php" style="color: gray;"> กลับหน้าหลัก</a></p>

</div>

</body>
</html>