<?php
session_start();
require_once "header.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>หน้าหลัก</title>

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">

    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/a94becc44e.js" crossorigin="anonymous"></script>

    <!-- css -->
    <link rel="stylesheet" href="Custom/mains.css">
    <link rel="stylesheet" href="Custom/body.css">
    <link rel="stylesheet" href="Custom/image_main.css">

</head>

<body>

    <!-- ส่วน image ส่วนบน -->
    <div class="div-img">

        <!-- รูปภาพ -->
        <img src="image/bg-banner-01.jpg" alt="*" class="img-banner">

        <div class="welcome-message scale-up-hor-left"
            style="position: absolute; top: 20px; left: 20px; color: white; font-family: 'Kanit', sans-serif; font-size: 35px; text-shadow: 3px 3px 1px #000000;">
            ยินดีต้อนรับสู่เว็บไซต์ KaiDoo เว็บไซต์สำหรับประกาศซื้อขายสินค้ามือสองมหาวิทยาลัยราชภัฏนครปฐม
        </div>

        <!-- ปุ่มโพสต์-หาสินค้า -->
        <div class="div-btn">
            <a href="category_Sell-find_products.php" class="btn btn-post">
                <i class="fa-solid fa-circle fa-flip-vertical fa-2xs blink-2"
                    style="color: #ffffff; margin-right: 5px;"></i> ตามหา / ขาย สินค้า </a>
        </div>

        <!-- Search bar ที่ตรงกลาง -->
        <div class="div-search-bar">
            <form class="form-inline" action="search&filter.php" method="GET">
                <input type="search" name="search" placeholder="คุณกำลังมองหาสินค้าอะไรอยู่...."
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                    style="padding: 10px; width: 600px; border: 0px;">
                <button type="submit" class="btn-serch"><i class="fa-solid fa-magnifying-glass"
                        style="color: #ffffff;"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- ตรวจค่า show_product  -->
    <?php
    include_once "show_product.php";
    ?>

    <?php
    include_once "footer.php";
    ?>

</body>

</html>