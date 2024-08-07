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

    <div
        style=" box-shadow: 0 -10px 10px 0 rgba(0, 0, 0, 0.15), 0 -3px 10px 0 rgba(0, 0, 0, 0.15); margin-top: 60px; z-index: 1;">
        <footer class="footer h-100" style="background-color: #454955;">
            <div class="container">
                <div class="d-flex justify-content-between text-white">
                    <div class="row col-6">
                        <div>
                            <h3>ติดตามเรา</h3>
                        </div>
                        <div class="d-flex gap-3">
                            <div>
                                <img class=" pointer" src="./image/fackbook.png" alt="" width="30" height="30">
                            </div>
                            <div>
                                <img class="pointer" src="./image/instagram.png" alt="" width="30" height="30">
                            </div>
                            <div>
                                <img class="pointer" src="./image/twitter.png" alt="" width="30" height="30">
                            </div>
                        </div>
                    </div>
                    <div class="row col-6" style="margin-left: 20%;">
                        <div>
                            <h2>ติดต่อกับเรา</h2>
                        </div>
                        <div style="max-width: 600px; word-wrap: break-word; word-break: break-all;" class="my-3">
                            <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure dolore fuga fugit libero
                                possimus corporis quod, vitae illum provident ab necessitatibus voluptatem natus
                                veritatis sequi? Quis molestias omnis magni sapiente!</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column justify-content-end align-items-center mt-3">
                <h6>© NPRU</h6>
            </div>

        </footer>
    </div>


</body>

</html>