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
        <footer class="footer" style="background-color: #454955;">
            <div class="container">
                <div class="d-flex justify-content-between text-white">
                    <div class="row col-6">
                        <div>
                            <h2>เกี่ยวกับ BY P</h2>
                        </div>
                        <div class="d-flex gap-4">
                            <div>
                                <img class="pointer" src="./image/fackbook.png" alt="" width="40" height="40">
                            </div>
                            <div>
                                <img class="pointer" src="./image/instagram.png" alt="" width="40" height="40">
                            </div>
                            <div>
                                <img class="pointer" src="./image/twitter.png" alt="" width="40" height="40">
                            </div>
                        </div>
                    </div>
                    <div class="row col-6">
                        <div>
                            <h2>ติดต่อกับเรา</h2>
                        </div>
                        <div style="max-width: 600px; word-wrap: break-word; word-break: break-all;" class="my-3">
                            <span>aksljdlaskdjaslkjalksjaskdjasldjkaslaskljdaijoqwnlkdansoiushskjbfdkldawdejsuirhfykbnlaksljdlaskdjaslkjalksjaskdjasldjkaslaskljdaijoqwnlkdansoiushskjbfdkldawdejsuirhfykbnlaksljdlaskdjaslkjalksjaskdjasldjkaslaskljdaijoqwnlkdansoiushskjbfdkldawdejsuirhfykbnlaksljdlaskdjaslkjalksjaskdjasldjkaslaskljdaijoqwnlkdansoiushskjbfdkldawdejsuirhfykbnl</span>
                        </div>
                        <div class="mb-3 d-flex gap-3 align-items-center">
                            <img src="./image/telephone.png" alt="" width="40" height="40">
                            <span>088-8888888</span>
                        </div>
                        <div class="d-flex gap-3 align-items-center">
                            <img src="./image/email.png" alt="" width="40" height="40">
                            <span>test@gmail.com</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-2 w-100 border border-2 border-white"></div>

            <div class="d-flex justify-content-center text-white align-items-center">
                <h2>© NPRU BY P</h2>
            </div>
        </footer>
    </div>


</body>

</html>