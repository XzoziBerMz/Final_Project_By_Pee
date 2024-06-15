<?php

// ตรวจสอบว่า session ยังไม่ได้เปิด ถึงจะทำการเปิด session
if (!isset($_SESSION)) {
    session_start();
}

// ดึงข้อมูลdatabase
require_once 'connetdatabase/conn_db.php';

// ดึงข้อมูลแอดมินและผู้ใช้
if (isset($_SESSION['user_login'])) {
    $user_id = $_SESSION['user_login'];
    $stmt = $conn->query("SELECT * FROM users WHERE user_id = $user_id");
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} elseif (isset($_SESSION['admin_login'])) {
    $admin_id = $_SESSION['admin_login'];
    $stmt = $conn->query("SELECT * FROM users WHERE user_id = $admin_id");
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>footer</title>

    <!-- css -->
    <link rel="stylesheet" href="Custom/footer.css">

</head>

<body>

    <nav
        style=" box-shadow: 0 -10px 10px 0 rgba(0, 0, 0, 0.15), 0 -3px 10px 0 rgba(0, 0, 0, 0.15); margin-top: 60px; z-index: 1;">
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-5" style="margin-top: 30px; margin-left: -150px; font-size: larger;">
                        <h5> หมวดหมู่</h5>
                        <div class="row mt-4">
                            <div class="col-6">
                                <ul class="list-unstyled">
                                    <li><a href="">หนังสือ</a></li>
                                    <li><a href="">เสื้อผ้า</a></li>
                                    <li><a href="">ยานพาหนะ</a></li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <ul class="list-unstyled">
                                    <li><a href="">อุปกรณ์อิเล็กทรอนิกส์</a></li>
                                    <li><a href="">รองเท้า</a></li>
                                    <!-- <li><a href="">About</a></li> -->
                                </ul>
                            </div>
                        </div>
                        <br>
                    </div>

                    <?php
                    // ผู้ใช้
                    if (isset($_SESSION['user_login'])) {
                        echo "";
                        // แอดมิน
                    } else if (isset($_SESSION['admin_login'])) {
                        echo "";
                        // ปุ่มล็อคอิน
                    } else {
                        echo '<div class="col-md-4" style="margin-left: 480px;">
                            <h5 class="text-md-right" style="margin-left: 90px; margin-top: 75px;">ยังไม่ได้สมัครสมาชิกใช่ไหม !</h5>
                            <hr>

                            <form action="register.php" method="post">
                                <fieldset class="form-group text-xs-right">
                                    <button type="submit" class="btn btn-send">สมัครสมาชิก</button>
                                </fieldset>
                            </form>
                        </div>';
                    }
                    ?>
                </div>
            </div>
        </footer>
    </nav>


</body>

</html>