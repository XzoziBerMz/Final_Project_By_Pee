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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="Custom/profile.css">
</head>

<body>
    <div class="row m-0">

        <!-- profile user -->
        <div class="col-md-2 profile-container ">
            <div class="card card-user">
                <div class="mb-4">
                    <img src="https://img.freepik.com/free-vector/businessman-character-avatar-isolated_24877-60111.jpg?size=338&ext=jpg&ga=GA1.1.1224184972.1711670400&semt=ais"
                        class="rounded-circle" alt="" width="150" height="150">
                </div>
                <div class="d-flex justify-content-center">
                    <p class="username"> <?php echo $user['firstname'] . ' ' . $user['lastname'] ?> </p>
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <span class="IDnumber">หมายเลขสมาชิก : <?php echo $user['user_id'] ?></span>
                </div>
                <hr>
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
            <div class="mt-4">
                <!-- หมวดหมู่ -->
                <div class="categories-container">
                   
                     <a href="profile.php" class="category-item">ทั้งหมด </a> 
                    
                    <?php
                    foreach ($result as $row) { ?>
                        <a href="profile.php?act=showbytype&type_id=<?php echo $row['type_id']; ?>" class="category-item">
                            <?php echo $row["type_name"]; ?></a>
                    <?php } ?>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
        </script>

</body>

</html>