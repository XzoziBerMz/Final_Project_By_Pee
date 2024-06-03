<?php

session_start();
require_once  "header.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>อุปกรณือิเล็กทรอนิกส์</title>

  <!-- Link to Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

  <!-- css -->
  <link rel="stylesheet" href="Custom/body.css">
  <link rel="stylesheet" href="Custom/electronic.css">
</head>

<body>

  <!-- ส่วน image ส่วนบน -->
  <div class="div-img">

    <!-- รูปภาพ -->
    <div class="img-container">
      <img src="image/electronic equipment .jpg" alt="*" class="img-banner">
      <!-- ข้อความด้านบนซ้าย -->
      <div class="top-left-text scale-up-hor-left ">
        <p style="background-color: black;">หมวด อุปกรณ์อิเล็กทรอนิกส์</p>
      </div>
    </div>

    <!-- ปุ่มโพสต์-หาสินค้า -->
    <div class="div-btn">
      <a href="category_Sell-find_products.php" class="btn btn-post">
        <i class="fa-solid fa-circle fa-flip-vertical fa-2xs blink-2" style="color: #ffffff; margin-right: 5px;"></i> ตามหา / ขาย สินค้า </a>
    </div>

    <!-- Search bar ที่ตรงกลาง -->
    <div class="div-search-bar">
      <form class="form-inline" action="search&filter.php" method="GET">
        <input type="search" name="search" placeholder="คุณกำลังมองหาสินค้าอะไรอยู่...." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" style="padding: 10px; width: 600px; border: 0px;">
        <button type="submit" class="btn-serch"><i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
        </button>
      </form>
    </div>
  </div>

  <!-- ************************************************************** -->

  <!-- product -->

  <?php

  include_once "show_product_type.php";

  ?>

  <?php
  include_once "footer.php";
  ?>

</body>

</html>