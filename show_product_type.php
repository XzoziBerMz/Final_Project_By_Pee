<?php
// ตรวจสอบว่า session ยังไม่ได้เปิด ถึงจะทำการเปิด session
if (!isset($_SESSION)) {
  session_start();
}

// ดึงข้อมูล database
require_once 'connetdatabase/conn_db.php';

// ตรวจสอบว่ามีการส่งค่า type_id มาหรือไม่
if (isset($_GET['type_id'])) {
  $type_id = $_GET['type_id'];

  // ตรวจสอบว่ามีการส่งค่า sub_type_id มาหรือไม่
  if (isset($_GET['sub_type_id'])) {
    $sub_type_id = $_GET['sub_type_id'];

    // โชว์หมดทั้งtype_id และ sub_type_id
    // นำเข้าตาราง database
    $stmt = $conn->prepare("SELECT * FROM posts as p 
    INNER JOIN types as t ON p.type_id = t.type_id
    INNER JOIN sub_type as s ON p.sub_type_id = s.sub_type_id
    WHERE p.type_id = :type_id AND p.sub_type_id = :sub_type_id
    ORDER BY p.posts_id ASC");

    $stmt->bindParam(':type_id', $type_id, PDO::PARAM_INT);
    $stmt->bindParam(':sub_type_id', $sub_type_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } else {
    // โชว์แค่type_idเมื่อไม่ได้ส่งค่าsub_typeมาด้วย
    // นำเข้าตาราง database
    $stmt = $conn->prepare("SELECT * FROM posts as p 
    INNER JOIN types as t ON p.type_id = t.type_id
    INNER JOIN sub_type as s ON p.sub_type_id = s.sub_type_id
    WHERE p.type_id = :type_id
    ORDER BY p.posts_id ASC");

    $stmt->bindParam(':type_id', $type_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>product_type</title>

  <!-- css -->
  <link rel="stylesheet" href="Custom/show_products.css">

</head>

<body>

  <div class="mt-3" style="margin-left: 10px;">

    <!-- Product cards with Carousel -->
    <div class="row m-0">

      <!-- Product -->
      <?php foreach ($result as $row_pro) { ?>
        <div class="product-card position-relative">
          <div
            class="position-absolute top-0 translate-middle <?php echo ($row_pro['type_buy_or_sell'] === 'ขาย') ? 'tag-sell' : ''; ?> <?php echo ($row_pro['type_buy_or_sell'] === 'ซื้อ') ? 'tag-buy' : ''; ?>">
            <span><?php echo $row_pro['type_buy_or_sell']; ?></span>
          </div>
          <div class="product-tumb">

            <?php
            $product_images = json_decode($row_pro["Product_img"]);
            if (!empty($product_images)) {
              $first_image = $product_images[0];
              ?>
              <img src="image/<?php echo $first_image; ?>" class="image-fix" alt="..." width="350" height="200">
            <?php } ?>

          </div>
          <div class="product-details">
            <span class="product-catagory"> ประเภท : <?php echo $row_pro['type_name']; ?> /
              <?php echo $row_pro['sub_type_name']; ?>
            </span>
            <div class="d-flex justify-content-between align-items-center">
              <div class="text-config fs-5">
                <span href="">
                  <?php
                  $product_title = $row_pro['product_name'];
                  if (mb_strlen($product_title) > 35) {
                    $shortened_title = mb_substr($product_title, 0, 22) . '...';
                    echo $shortened_title;
                  } else {
                    echo $product_title;
                  }
                  ?>
                </span>
                <!-- <h4></h4> -->
              </div>
              <div>
                <?php
                if ($row_pro['product_price_type'] === 'ต่อรองได้') {
                  echo '<p class="m-0">' . $row_pro['product_price_type'] . '</p class="m-0">';
                }
                ?>
              </div>
            </div>
            <p>
              <?php
              $product_detail = $row_pro['Product_detail'];
              if (mb_strlen($product_detail) > 40) {
                $shortened_detail = mb_substr($product_detail, 0, 28) . '...';
                echo $shortened_detail;
              } else {
                echo $product_detail;
              }
              ?>
            </p>
            <div class="product-bottom-details">
              <?php
              if ($row_pro['product_price'] === '0') {
                echo '<div class="product-price">ฟรี</div>';
              } else {
                $formatted_price = number_format($row_pro['product_price']);
                echo '<div class="product-price">' . $formatted_price . ' บาท</div>';
              }
              ?>

              <div><a class="btn btn-more"
                  href="post.php?product_id=<?php echo $row_pro['posts_id']; ?>">รายละเอียดเพิ่มเติม</a></div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>

</body>

</html>