<?php
// ตรวจสอบว่า session ยังไม่ได้เปิด ถึงจะทำการเปิด session
if (!isset($_SESSION)) {
    session_start();
}
require_once "header.php";

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
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

// ส่วนของโชว์ค่าวันที่และเดือนตรง create_at
function getMonth($month)
{
    $thaiMonths = [
        1 => 'มกราคม',
        2 => 'กุมภาพันธ์',
        3 => 'มีนาคม',
        4 => 'เมษายน',
        5 => 'พฤษภาคม',
        6 => 'มิถุนายน',
        7 => 'กรกฎาคม',
        8 => 'สิงหาคม',
        9 => 'กันยายน',
        10 => 'ตุลาคม',
        11 => 'พฤศจิกายน',
        12 => 'ธันวาคม'
    ];
    return $thaiMonths[intval($month)];
}

function formatDate($date)
{
    $timestamp = strtotime($date);
    $year = date('Y', $timestamp) + 543; // แปลงปี ค.ศ. เป็น พ.ศ.
    $month = date('n', $timestamp); // เดือน (1-12)
    $ThaiMonth = getMonth($month);

    return " $ThaiMonth $year ";
}

$profile_id = $_GET['profile_id'];

$user_stmt = $conn->query("SELECT * FROM users WHERE user_id = $profile_id");
$user_stmt->execute();
$userDetail = $user_stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรไฟล์</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="Custom/profile.css">
</head>

<body>
    <div class="row m-0 m-3">

        <!-- profile user -->
        <div class="col-md-2 profile-container ">
            <div class="card card-user">
                <div class="mb-4">
                    <img src="<?php echo $userDetail['user_photo']; ?>" class="rounded-circle" alt="" width="150"
                        height="150">
                </div>
                <div class="d-flex justify-content-center">
                    <p class="username"> <?php echo $userDetail['firstname'] . ' ' . $userDetail['lastname'] ?> </p>
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <span class="detaill_user">หมายเลขสมาชิก : <?php echo $userDetail['user_id'] ?></span>
                </div>
                <?php
                $sqlPointView = "SELECT * FROM points WHERE user_post_id = :user_id";
                $stmtPointView = $conn->prepare($sqlPointView);
                $stmtPointView->bindParam(':user_id', $profile_id, PDO::PARAM_INT);
                $stmtPointView->execute();
                $pointsData = $stmtPointView->fetchAll(PDO::FETCH_ASSOC);

                $totalPoints = 0;
                foreach ($pointsData as $rowPoint) {
                    $totalPoints += $rowPoint['point']; // สมมติว่า column ที่เก็บคะแนนคือ 'point'
                }
                ?>
                <div class="d-flex justify-content-center">
                    <span class="detaill_user">คะแนนความนิยม (<?php echo $totalPoints ?>)</span>
                </div>
            </div>
        </div>

        <!-- post user -->
        <?php
        $type = "SELECT * FROM types";
        $stmt = $conn->prepare($type);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div class="col-md-10">
            <div class="mt-4" style="margin-bottom: 2%;">
                <!-- หมวดหมู่ -->
                <div class="categories-container">

                    <a href="profile_by.php?profile_id=<?php echo $profile_id ?>" class=" category-item">ทั้งหมด </a>

                    <?php
                    foreach ($result as $row) { ?>
                        <a href="profile_by.php?profile_id=<?php echo $profile_id ?>&act=showbytype&type_id=<?php echo $row['type_id']; ?>"
                            class="category-item">
                            <?php echo $row["type_name"]; ?></a>
                    <?php } ?>

                    <!-- ปุ่มตามหา-ประกาศขาย -->
                    <div class="div-btn" style="margin-left: 15%;">
                        <a href="category_Sell-find_products.php" class="btn btn-post">
                            <i class="fa-solid fa-circle fa-flip-vertical fa-2xs blink-2" style="color: #ffffff;"></i>
                            ตามหา / ขายสินค้า
                        </a>
                    </div>

                </div>
                <hr class="hr-catagory">
            </div>

            <!-- post-user -->
            <?php
            include_once "show_product_profile.php";
            ?>

        </div>
    </div>

    <!-- footer -->
    <?php
    include_once "footer.php";
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/profile.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
        </script>

</body>

</html>