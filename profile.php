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
$profile_id = isset($_GET['profile_id']) ? $_GET['profile_id'] : null;

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
                    <img src="<?php echo $user['user_photo']; ?>" class="rounded-circle" alt="" width="150"
                        height="150">
                </div>
                <div class="d-flex justify-content-center">
                    <p class="username"> <?php echo $user['firstname'] . ' ' . $user['lastname'] ?> </p>
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <span class="detaill_user">หมายเลขสมาชิก : <?php echo $user['user_id'] ?></span>
                </div>
                <div class="d-flex justify-content-center">
                    <span class="detaill_user">เข้าร่วมเมื่อ : <?php echo formatDate($user['create_at']); ?></span>
                </div>
                <hr>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-personal-information"
                        onclick='viewProfile(<?php echo json_encode($user); ?>)'>ดูข้อมูลส่วนตัว</button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">ข้อมูลส่วนตัว</h1>
                        <button type="button" class="btn-close" onclick="closeModal()"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center" id="form_show_text">
                            <div class="mt-3">
                                <img class="m-0 rounded-circle" src="<?php echo $user['user_photo']; ?>" alt=""
                                    width="200" height="200">
                            </div>
                            <div class="mt-3">
                                <span>หมายเลขสมาชิก : <?php echo $user['user_id'] ?></span>
                            </div>
                            <div class="mt-3">
                                <span>เข้าร่วมเมื่อ : <?php echo formatDate($user['create_at']); ?></span>
                            </div>
                            <div class="mt-3">
                                <span>ชื่อ : <?php echo $user['firstname'] . ' ' . $user['lastname'] ?></span>
                            </div>
                            <div class="mt-3">
                                <span>Email : <?php echo $user['email'] ?></span>
                            </div>
                            <div class="mt-3">
                                <span>เบอร์โทรศัพท์ : <?php echo $user['user_tel'] ?></span>
                            </div>
                            <div class="mt-3">
                                <span>ที่อยู่ :
                                    <?php echo !empty($user['user_address']) ? htmlspecialchars($user['user_address']) : '-'; ?></span>
                            </div>

                            <div class="d-flex justify-content-end align-items-center mt-5">
                                <div>
                                    <button class="btn btn-warning text-light" onclick="onEdit('edit')"
                                        id="edit_profile">แก้ไขข้อมูลส่วนตัว</button>
                                </div>
                            </div>
                        </div>
                        <div class="" id="form_edit_input" style="display: none;">
                            <div class="mt-3 text-center">
                                <img class="m-0 rounded-circle" id="profilePic" src="<?php echo $user['user_photo']; ?>"
                                    alt="" width="200" height="200"
                                    onclick="document.getElementById('fileInput').click();">
                                <input type="file" id="fileInput" hidden>
                            </div>
                            <div class="mt-3 text-center">
                                <span>หมายเลขสมาชิก : <?php echo $user['user_id'] ?></span>
                            </div>
                            <div class="mb-3">
                                <label for="firstname" class="form-label">ชื่อ</label>
                                <input type="text" class="form-control" id="firstname" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="lastname" class="form-label">นามสกุล</label>
                                <input type="text" class="form-control" id="lastname" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                                <input type="text" class="form-control" id="phone_number" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">ที่อยู่</label>
                                <input type="text" class="form-control" id="address" aria-describedby="emailHelp">
                            </div>
                            <div>
                                <div>
                                    <button class="btn btn-warning text-light" onclick="changePassword()"
                                        id="edit_profile">เปลี่ยนรหัสผ่าน</button>
                                </div>
                            </div>
                            <div class="mt-3" id="password_form_change" style="display: none;">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" value="" class="form-control" id="current_password"
                                        aria-describedby="passwordHelp">
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" value="" class="form-control" id="new_password"
                                        aria-describedby="passwordHelp">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end align-items-center gap-3">
                                <div>
                                    <button class="btn btn-danger text-light" onclick="onEdit('cancel')"
                                        id="edit_profile">ยกเลิก</button>
                                </div>
                                <div>
                                    <button class="btn btn-success text-light" onclick="saveChanges()"
                                        id="edit_profile">บันทึก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> -->
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

        <div class="col-md-10 ">
            <div class="mt-4" style="margin-bottom: 2%;">
                <!-- หมวดหมู่ -->
                <div class="categories-container">

                    <a href="profile.php" class="category-item">ทั้งหมด </a>

                    <?php
                    foreach ($result as $row) { ?>
                        <a href="profile.php?act=showbytype&type_id=<?php echo $row['type_id']; ?>" class="category-item">
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