<?php

session_start();
require_once "header.php";
require_once "connetdatabase/conn_db.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>หมวดหมู่</title>


  <!-- Link to Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <!-- css -->
  <link rel="stylesheet" href="Custom/body.css">
  <link rel="stylesheet" href="Custom/allcategory.css">
</head>

<body>

  <!-- ส่วน image ส่วนบน -->
  <div class="div-img">

    <!-- รูปภาพ -->
    <div class="img-container">
      <img src="image/category.jpg" alt="*" class="img-banner">
      <!-- ข้อความด้านบนซ้าย -->
      <div class="top-left-text scale-up-hor-left ">
        <?php
        // ตรวจสอบว่ามีการส่งค่า type_id ผ่าน URL ไหม
        if (isset($_GET['type_id'])) {
          $type_id = $_GET['type_id'];

          // คำสั่ง SQL เพื่อดึงชื่อประเภท (type_name) จากฐานข้อมูล
          $type_name_query = "SELECT type_name FROM types WHERE type_id = :type_id";
          $stmt_type_name = $conn->prepare($type_name_query);
          $stmt_type_name->bindParam(':type_id', $type_id, PDO::PARAM_INT);
          $stmt_type_name->execute();
          $type_name_result = $stmt_type_name->fetch(PDO::FETCH_ASSOC);

          // ตรวจสอบว่าพบข้อมูลหรือไม่ก่อนแสดงผล
          if ($type_name_result) {
            $type_name = $type_name_result['type_name'];
            echo '<p style="text-shadow: 3px 3px 1px #000000;">หมวด ' . $type_name . '</p>';
          } else {
            echo '<p style="text-shadow: 2px 2px 4px #000000;">ไม่มีหมวดหมู่ระบุ</p>';
          }
        }
        ?>
      </div>
    </div>

    <!-- ปุ่มโพสต์-หาสินค้า -->
    <div class="div-btn">
      <a href="category_Sell-find_products.php" class="btn btn-post">
        <i class="fa-solid fa-circle fa-flip-vertical fa-2xs blink-2" style="color: #ffffff; margin-right: 5px;"></i>
        ตามหา / ขาย สินค้า </a>
    </div>

    <!-- Search bar ที่ตรงกลาง -->
    <div class="div-search-bar">
      <form class="form-inline" action="search&filter.php" method="GET">
        <input type="search" name="search" placeholder="คุณกำลังมองหาสินค้าอะไรอยู่...."
          value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>"
          style="padding: 10px; width: 600px; border: 0px;">
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