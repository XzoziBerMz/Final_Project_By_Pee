<?php
session_start(); //เรียกใช้งานsession
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
            width: 700px;
            padding: 40px;
            border: 40px;
            border-radius: 50px;
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

<body>

    <body class="vh-100 d-flex justify-content-center align-items-center">
        <div>
            <div class="w-100 d-flex justify-content-center">
                <img src="image/Logo.png" alt="" style=" width: 140px; height: 140px;">
            </div>

            <div class="new_container m-auto mt-4" style="margin-top: 30px;">
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
                        <input style="padding: 10px;" type="text" class="form-control" name="email" placeholder="อีเมล">
                    </div>
                    <div class="d-flex gap-4 mb-4">
                        <div class="col">
                            <input style="padding: 10px;" type="text" class="form-control" name="firstname"
                                placeholder="ชื่อจริง" maxlength="20px">
                        </div>

                        <div class="col">
                            <input style="padding: 10px;" type="text" class="form-control" name="lastname"
                                placeholder="นามสกุล" maxlength="20px">
                        </div>
                    </div>
                    <div class="mb-4">
                        <input type="tel" class="form-control" name="phone_number" placeholder="เบอร์โทรศัพท์"
                            oninput="validateInput(this)" maxlength="10" required>
                    </div>
                    <div class="mb-4">
                        <input type="text" class="form-control" name="address" placeholder="ที่อยู่" required>
                    </div>
                    <div>
                        <div class="mb-4">
                            <input type="password" class="form-control" name="password" placeholder="รหัสผ่าน" required>
                        </div>
                        <div class="mb-4">
                            <input type="password" class="form-control" name="confirm_password"
                                placeholder="ยืนยันรหัสผ่าน" required>
                        </div>


                        <div class="d-grid">
                            <button type="submit" class="button-27" role="button"
                                name="register">ยืนยันการลงทะเบียน</button>
                        </div>

                </form>

                <hr>
                <p class="text-start" style="margin-bottom: 3px">เป็นสมาชิกใช่ไหม คลิ้กที่นี่เพื่อ <a href="signin.php">
                        เข้าสู่ระบบ</a></p>
            </div>

            <script>
                // ส่วนของ input phone ตัวแปรนี้ทำให้ไม่สามารถใส่ข้อความได้ใส่ได้แค่ตัวเลขเท่านั้น
                function validateInput(element) {
                    let value = element.value.replace(/\D/g, ''); // ลบอักขระที่ไม่ใช่ตัวเลข
                    element.value = value;
                }
            </script>
    </body>

</html>