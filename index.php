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