<?php
session_start();
require_once "header.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>โพสต์</title>
  <!-- css -->
  <link rel="stylesheet" href="Custom/filter.css">
</head>

<body>
  <!-- navbar-head -->
  <nav class="navbar navbar-dark bg-dark nav-head slide-right" style="height: 105px;">
    <div class="container-fluid">
      <a class="navbar-brand" href="search&filter.php" style="margin-left: 150px;">
        <img src="image/logo01.png" alt="" width="65" height="70" class="d-inline-block align-text-top"
          style="margin-right: 10px;">
        <h3 style="float: right;"></h3>
      </a>
      <!-- ปุ่มตามหา-ประกาศขาย -->
      <div class="div-btn">
        <a href="category_Sell-find_products.php" class="btn btn-post">
          <i class="fa-solid fa-circle fa-flip-vertical fa-2xs blink-2" style="color: #ffffff;"></i> ตามหา / ขายสินค้า
        </a>
      </div>
    </div>
    <!-- Search bar ที่ตรงกลาง -->
    <div class="div-search">
      <form class="form-inline" action="search&filter.php" method="GET">
        <input type="search" name="search" class="input-search" placeholder="คุณกำลังมองหาสินค้าอะไรอยู่...."
          value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
          style="padding: 10px; width: 600px; border: 0px;">
        <button type="submit" class="btn-search"><i class="fa-solid fa-magnifying-glass"
            style="color: #ffffff;"></i></button>
      </form>
    </div>
  </nav>

  <!-- fliter -->
  <?php
  $type = "SELECT * FROM types";
  $stmt = $conn->prepare($type);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>
  <div class="row fliter m-0">
    <div class="col-md-2 mt-4">
      <!-- หมวดหมู่ -->
      <b class="header-filter">หมวดหมู่</b>
      <div class="list-group" style="margin-top: 10px;">
        <?php
        foreach ($result as $row) { ?>
          <a href="search&filter.php?act=showbytype&type_id=<?php echo $row['type_id']; ?>"
            class="list-group-item list-group-item-action list-group-item-light">
            <?php echo $row["type_name"]; ?></a>
        <?php } ?>
      </div>
      <br>
      <!-- ราคา -->
      <?php
      // ดึงข้อมูลตัวเลขจากฐานข้อมูล
      $typeNumbers = "SELECT MIN(CAST(product_price AS UNSIGNED)) as min_price, MAX(CAST(product_price AS UNSIGNED)) as max_price FROM posts WHERE product_price REGEXP '^[0-9]+$'";
      $stmtNumbers = $conn->prepare($typeNumbers);
      $stmtNumbers->execute();
      $resultNumbers = $stmtNumbers->fetch(PDO::FETCH_ASSOC);

      $minPriceNumbers = $resultNumbers['min_price'];
      $maxPriceNumbers = $resultNumbers['max_price'];

      // ดึงข้อมูลตัวอักษรจากฐานข้อมูล
      $typeStrings = "SELECT product_price FROM posts WHERE product_price NOT REGEXP '^[0-9]+$'";
      $stmtStrings = $conn->prepare($typeStrings);
      $stmtStrings->execute();
      $resultStrings = $stmtStrings->fetchAll(PDO::FETCH_ASSOC);

      // กำหนดค่าต่ำสุดให้กับตัวอักษร
      $minPriceStrings = count($resultStrings) > 0 ? 0 : $minPriceNumbers; // กำหนดค่าต่ำสุดให้กับตัวอักษรเป็น 0
      
      // หาค่าต่ำสุดและค่าสูงสุด
      $minPrice = min($minPriceNumbers, $minPriceStrings);
      $maxPrice = $maxPriceNumbers;
      ?>
      <b class="header-filter">ราคา</b>
      <div class="price-content">
        <div>
          <label>Min</label>
          <p id="min-value"><?php echo $minPrice; ?> บาท</p>
        </div>
        <div>
          <label>Max</label>
          <p id="max-value"><?php echo $maxPrice; ?> บาท</p>
        </div>
      </div>
      <div class="range-slider">
        <div class="range-fill"></div>
        <input type="range" class="min-price" value="<?php echo $minPrice; ?>" min="<?php echo $minPrice; ?>"
          max="<?php echo $maxPrice; ?>" step="10" />
        <input type="range" class="max-price" value="<?php echo $maxPrice; ?>" min="<?php echo $minPrice; ?>"
          max="<?php echo $maxPrice; ?>" step="10" />
      </div>
    </div>

    <!-- ส่วนของ post -->
    <div id="product-list" class="col-md-10 mt-3"></div>

  </div>
  <!-- footer -->
  <?php
  include_once "footer.php";
  ?>
  <!-- fliterprice.js -->
  <script>
    const phpMinPrice = <?php echo $minPrice; ?>;
    const phpMaxPrice = <?php echo $maxPrice; ?>;
  </script>
  <script src="js/filterprice.js"></script>
</body>

</html>